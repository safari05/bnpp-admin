<?php

namespace App\Http\Controllers\Back\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfilController extends Controller
{
    public function index(){
        $iduser = Auth::user()->iduser;
        $data['user'] = User::where('iduser', $iduser)->first();
        return view('back.user.profile.profile', $data);
    }

    public function editProfile(){
        $iduser = Auth::user()->iduser;
        $data['user'] = User::where('iduser', $iduser)->first();
        return view('back.user.profile.edit-profile', $data);
    }

    public function updateProfile(Request $request){
        $input = $request->all();
        $iduser = Auth::user()->iduser;

        $valid = Validator::make($input, [
            // 'username'=>'required|unique:users,username,'.$iduser.',iduser',
            'email'=>'required|unique:users,email,'.$iduser.',iduser',
            'nama'=>'required',
            'gender'=>'required',
            'alamat'=>'required',
        ],[
            'required'=>':attribute harus diisi!',
            'unique'=>':attribute sudah terdaftar'
        ],[
            // 'username'=>'Username',
            'email'=>'Email',
            'nama'=>'Nama Lengkap',
            'gender'=>'Gender Pengguna',
            'alamat'=>'Alamat Pengguna',
            'telepon'=>'Telepon Pengguna'
        ]);

        if(!$valid->fails()){
            $data_akun = [
                'email'=>$input['email'],
                'updated_at'=>Carbon::now('Asia/Jakarta')->toDateTimeString(),
            ];

            $data_detail = [
                'nama'=>$input['nama'],
                'gender'=>$input['gender'],
                'alamat'=>$input['alamat'],
                'telepon'=>@$input['telepon'],
            ];

            DB::beginTransaction();
            try {
                DB::table('users')->where('iduser', $iduser)->update($data_akun);
                DB::table('users_detail')->where('iduser', $iduser)->update($data_detail);
                DB::commit();
                $oke = true;
            } catch (\Exception $e) {
                DB::rollback();
                $oke = false;
                dd($e);
            }

            if($oke){
                return response()->json([
                    'status'=>200,
                    'msg'=>'Berhasil memperbarui Profile',
                ]);
            }else{
                return response()->json([
                    'status'=>500,
                    'msg'=>'Gagal memperbarui Profile',
                ]);
            }
        }else{
            return response()->json([
                'status'=>500,
                'msg'=>$valid->errors()->first(),
            ]);
        }
    }

    public function updatePassword(Request $request){
        $input = $request->all();
        $iduser = Auth::user()->iduser;
        // dd($input);
        $valid = Validator::make($input, [
            'password' => 'required|confirmed|min:6',
        ],[
            'required'=>':attribute harus diisi!',
            'unique'=>':attribute sudah terdaftar',
            'confirmed'=>':attribute harus sama dengan Konfirmasi Password',
        ],[
            'password'=>'Password Baru',
            'password_confirmation'=>'Konfirmasi Password Baru',
            'old_password'=>'Password Lama',
        ]);

        if(!$valid->fails()){
            $user = User::where('iduser', $iduser)->first();
            $isPassOk = password_verify($input['old_password'], @$user->password);

            if ($isPassOk) {
                $data_akun = [
                    'password'=>Hash::make($input['password']),
                    'updated_at'=>Carbon::now('Asia/Jakarta')->toDateTimeString(),
                ];

                DB::beginTransaction();
                try {
                    DB::table('users')->where('iduser', $iduser)->update($data_akun);
                    DB::commit();
                    $oke = true;
                } catch (\Exception $e) {
                    DB::rollback();
                    $oke = false;
                    dd($e);
                }

                if ($oke) {
                    return response()->json([
                        'status'=>200,
                        'msg'=>'Berhasil memperbarui Password',
                    ]);
                } else {
                    return response()->json([
                        'status'=>500,
                        'msg'=>'Gagal memperbarui Password',
                    ]);
                }
            }else{
                return response()->json([
                    'status'=>500,
                    'msg'=>'Password lama salah!',
                ]);
            }
        }else{
            return response()->json([
                'status'=>500,
                'msg'=>$valid->errors()->first(),
            ]);
        }
    }
}
