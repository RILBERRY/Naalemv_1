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
    public function smsVerifiy()
    {
        $otp = rand(0, 99999);
        session::put('otp',$otp);
        $this->sendOTP($otp, '+9609898947');
        return view('sms-verifiy');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function VerifiyOtp(Request $request)
    {
       if($request->otp == session::get('otp')){
        dd('ok');
       }
       return redirect('/sms-verifiy')->with('status_error','OTP doesent match ! New OTP SENT');
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
    public function sendOTP($otp, $number)
    {
 
        $sid    = "AC6542732c447c7ddd1dcd75c864e46845"; 
        $token  = "a592f1b68f10f7157e2fb75d94247183"; 
       // Your Account SID and Auth Token from twilio.com/console
        $twilio_number = "+12563304619";

        $client = new Client($sid, $token);
        $client->messages->create(
            // Where to send a text message (your cell phone?)
            $number,
            array(
                'from' => $twilio_number,
                'body' => 'Naalemv OTP '.$otp
            )
        );
    }
}
