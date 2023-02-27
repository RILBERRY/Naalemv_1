<?php

namespace App\Http\Controllers;

use App\Actions\Fortify\PasswordValidationRules;
use App\Models\setting;
use App\Models\User;
use App\Models\islands;
use App\Models\schedule;
use App\Models\vessel;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use Twilio\Rest\Client; 


class SettingController extends Controller
{
    use PasswordValidationRules;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vessel = vessel::find(auth()->user()->boatid);
        $DepatrueTime = schedule::where([['vessel_name',$vessel->name],['status','!=', 'COMPLETE']])->orderByDesc('id')->first();
        $allIslands = islands::orderBy('name','asc')->get();
        $users = User::where('boatid',auth()->user()->boatid)->where('rank','!=','customer')->get();
        Session::get('isDhivehi') ? $lang = "dhi" : $lang = "eng";
        return view("$lang.setting",['users'=>$users, 'allIslands'=> $allIslands, 'DepatrueTime'=>$DepatrueTime]);
    }
    public function dathuru(Request $request){
        $this->validate($request, [
            'DI' => ['required'],
            'VI' => ['required'],
            'DDate' => ['required'],
        ]);
        $vesselName = vessel::find(auth()->user()->boatid);
        schedule::create([
            'dep_date' => $request['DDate'],
            'visiting_to' => $request['VI'],
            'dock_island' => $request['DI'],
            'vessel_name' => $vesselName->name,
            'vessel_Contact' => auth()->user()->contact,
            'status' => "",
        ])->save();
        return redirect('/setting');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function AddNewUser(Request $request)
    {
        
        $this->validate($request, [
            'Fname' => ['required', 'string', 'max:255'],
            'email' => ['required'],
            'contact' => [
                'required',
                'integer',
                Rule::unique(User::class),
            ],
            'password' => ['required'],
        ]);
        if($request->password == $request->password_confirmation){

            User::create([
                'fullname' => $request['Fname'],
                'contact' => $request['contact'],
                'boatid' => auth()->user()->boatid,
                'rank' => "CREW",
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
            ])->save();
            return redirect('/setting')->with('status', 'New Crew is created');
        }
        return redirect('/setting')->with('status_error', 'Password dont match');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function ChangePassword(Request $request)
    {
        $user = User::find(auth()->user()->id);    
        if (! Hash::check($request['old_pass'], $user->password) || $request['new_pass'] != $request['con_pass']) {
            if(auth()->user()->rank == "customer"){
                return redirect('/customer/setting')->with('status_error','Password doesent match');
            }
            return redirect('/setting')->with('status_error','Password doesent match');
        }

        $user->forceFill([
            'password' => Hash::make($request['new_pass']),
        ])->save();
        if(auth()->user()->rank == "customer"){
            return redirect('/customer/setting')->with('status_success','Password Change Successfull');
        }
        return redirect('/setting')->with('status_success','Password Change Successfull');
       
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function selectMethode( Request $request)
    {
        return view('verifiy-methode');
        
    }
    public function sendOTP( Request $request)
    {
        $otp = rand(0, 999999);
        session::put('otpCode',$otp);
        $status = $request->varify_method == "SMS" 
        ? $this->sendSMSotp(auth()->user()->contact, $otp)
        : $this->sendEmailotp(auth()->user()->email, $otp);
        // return $status == true
        return redirect('/varify-otp')->with('status_success','OTP Send to '.$request->varify_method);
        // : redirect('/verifiy-methode')->with('status_error','OTP Send Fail');
    }

    public function sendSMSotp($number, $otp)
    {

        // try {
            $sid    = "AC038354145edddd0e14d83741d4fd703f"; 
            $token  = "bad67dc8c4d1cfa0323fff0cbb774b16"; 
           // Your Account SID and Auth Token from twilio.com/console
            $twilio_number = "+12708195486";
    
            $client = new Client($sid, $token);
            return $client->messages->create(
                // Where to send a text message (your cell phone?)
                // $number,
                '+9609555905',
                array(
                    'from' => $twilio_number,
                    'body' => 'Naalemv OTP '.$otp
                )
            );
        // } catch (\Throwable $th) {
        //     return false;
        // }
        // return true;
    }

    public function sendEmailotp($email, $otp)
    {
      
    }




    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function varifyOTP()
    {
        return view('verifiy-OTP');
    }

    public function varify(Request $request)
    {
        $user = User::find(auth()->user()->id);
        $request->otp_code == session::get('otpCode') 
        ?$user->Update([
            'mobile_verified_at' => Carbon::now()->toDateTimeString(),
        ])
        : ''; 
        return redirect('/dashboard');

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id )
    {   
        $editingUser = User::find($id);  
        $editingUser->Update([
            'fullname' => $request['Fname'],
            'contact' => $request['contact'],
            'email' => $request['email'],
            'status' => $request['status'],
        ]);

        if($request['password']){
            if ($request['password'] != $request['password_confirmation']) {
                return redirect('/setting')->with('status_error','Password doesent match');
            }
            $editingUser->forceFill([
                'password' => Hash::make($request['password']),
            ])->save();
            return redirect('/setting')->with('status_success','Password Change Successfull');
            
        }
        
        return redirect('/setting')->with('status_success','User update Sucessfull');

        
    }
    public function dathuruUpdate(Request $request, $id )
    {   
        $editingdathuru = schedule::find($id);  
        if($request->completed == "COMPLETE"){
            $editingdathuru->Update([
                'status' => $request['completed'],
            ]);
            return redirect('/setting')->with('status_success','Dhathuru update Sucessfull');
        }
        $status = "";
        if($request['status']){
            $status = $request['status'];
        }
        $editingdathuru->Update([
            'dep_date' => $request['DDate'],
            'status' => $status,
        ]);
        return redirect('/setting')->with('status_success','Dhathuru update Sucessfull');

        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function destroy(setting $setting)
    {
        //
    }
}
