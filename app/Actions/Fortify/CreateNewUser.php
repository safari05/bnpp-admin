<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
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
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
        ])->validate();

        return User::create([
            'iduser'=>$this->generateIdUser(),
            'username' => $input['username'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'active'=>'1',
        ]);
    }

    private function generateIdUser(){
        $last = User::max('iduser');
        return !empty($last)? $last + 1:1;
    }
}
