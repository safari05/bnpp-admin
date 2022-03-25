<?php

namespace App\Http\Controllers\Back\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request){
        // Retrive Input
        $credentials = $request->only('email', 'password');

        $input = $request->all();
        // dd($input);
        $user = User::where('email','=',$input['email'])->whereIn('idrole', ['1','2','3','4','5'])->get();
        if (count($user)>0) {
            $isPassOk = password_verify($input['password'], $user->first()->password);
            if ($isPassOk) {
                Auth::loginUsingId($user->first()->iduser);
                $url = url('dashboard');
                return redirect($url);
            }else{
                return back()->with('error', 'Password salah!')->withInput();
            }
        }
        else{
            return back()->with('error', 'User tidak terdaftar!')->withInput();
        }
    }

    public function logout(){
        Auth::logout();
        return redirect('login');
    }
}
