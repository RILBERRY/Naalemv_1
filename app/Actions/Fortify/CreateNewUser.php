<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Models\vessel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'Fname' => ['required', 'string', 'max:255'],
            'bname' => ['required', 'string', 'max:255'],
            'boatLoc' => ['required', 'string', 'max:255'],
            'boatRegNo' => ['required', 'string', 'max:255'],
            'email' => ['required','email', 'string', 'max:255'],
            'contact' => [
                'required',
                'integer',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
        ])->validate();
        
        if(!vessel::where('name',$input['bname'])->exists()){
            $NewVessel = vessel::create([
                'name' => $input['bname'],
                'island' => $input['boatLoc'],
                'regno' => $input['boatRegNo'],
            ]);
            $NewVessel->save();
    
            return User::create([
                'fullname' => $input['Fname'],
                'contact' => $input['contact'],
                'boatid' => $NewVessel->id,
                'rank' => "OWNER",
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
            ]);

        }else{
            return redirect('/register')->with('status','The vessel name is already register!!');
        }
    }
}
