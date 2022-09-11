<?php

namespace App\Http\Controllers;

use App\Actions\Fortify\PasswordValidationRules;
use App\Models\setting;
use App\Models\User;
use App\Models\vessel;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


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
        $users = User::all();
        Session::get('isDhivehi') ? $lang = "dhi" : $lang = "eng";
        return view("$lang.setting",['users'=>$users]);
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
        return redirect('/setting')->with('status', 'Password dont match');
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
            return redirect('/setting')->with('status','Password doesent match');
        }

        $user->forceFill([
            'password' => Hash::make($request['new_pass']),
        ])->save();
        return redirect('/setting')->with('status','Password Change Successfull');
       
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function show(setting $setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function edit(setting $setting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, setting $setting)
    {
        //
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
