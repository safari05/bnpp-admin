<?php

namespace App\Http\Controllers\Back\User;

use App\Http\Controllers\Controller;
use App\Models\Refactored\Users\UsersRole;
use App\Models\Refactored\Utils\UtilsProvinsi;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserManagerController extends Controller
{
    public function index(){
        $data['roles'] = UsersRole::all();
        return view('back.user.user-list', $data);
    }

    public function list(){
        DB::statement(DB::raw('set @rownum=0'));
        $user = User::select([
            DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'iduser',
            'username',
            'email',
            'active',
            'idrole',
        ])->where('iduser', '!=', Auth::user()->iduser);

        if(Auth::user()->idrole == 3){
            $user = $user->whereNotIn('idrole', ['1', '2']);
        }

        if(!empty(request()->q)){
            $nama = request()->q;
            $user = $user->where('username', 'like', '%'.$nama.'%')
                        ->orWhereHas('detail', function($q) use($nama){
                            $q->where('nama', 'like', '%'.$nama.'%');
                        });
        }

        if(!empty(request()->role)){
            $user = $user->where('idrole', request()->role);
        }

        if(!empty(request()->aktif)){
            if (request()->aktif == 2) {
                $user = $user->where('active', '0');
            }else{
                $user = $user->where('active', request()->aktif);
            }
        }

        $user = $user->get();

        return \Yajra\DataTables\Facades\DataTables::of($user)
            ->addColumn('nama', function(User $data){
                return $data->detail->nama;
            })
            ->addColumn('status', function(User $data){
                if(in_array(Auth::user()->idrole, ['1','2'])){
                    if ($data['iduser'] != Auth::user()->iduser) {
                        if ($data['active'] == 1) {
                            return '<button class="button button--sm w-24 mr-1 mb-2 bg-theme-9 text-white " onclick="ubahStatus('.$data['iduser'].')">Aktif</button>';
                        } else {
                            return '<button class="button button--sm w-24 mr-1 mb-2 bg-theme-6 text-white " onclick="ubahStatus('.$data['iduser'].')">Tidak Aktif</button>';
                        }
                    }else{
                        if ($data['active'] == 1) {
                            return '<span class="px-3 py-2 rounded-full bg-theme-9 text-white mr-1">Aktif</span>';
                        } else {
                            return '<span class="px-3 py-2 rounded-full bg-theme-6 text-white mr-1">Tidak Aktif</span>';
                        }
                    }
                }else{
                    if ($data['iduser'] != Auth::user()->iduser && !in_array($data['idrole'], ['1','2'])) {
                        if ($data['active'] == 1) {
                            return '<button class="button button--sm w-24 mr-1 mb-2 bg-theme-9 text-white " onclick="ubahStatus('.$data['iduser'].')">Aktif</button>';
                        } else {
                            return '<button class="button button--sm w-24 mr-1 mb-2 bg-theme-6 text-white " onclick="ubahStatus('.$data['iduser'].')">Tidak Aktif</button>';
                        }
                    }else{
                        if ($data['active'] == 1) {
                            return '<span class="px-3 py-2 rounded-full bg-theme-9 text-white mr-1">Aktif</span>';
                        } else {
                            return '<span class="px-3 py-2 rounded-full bg-theme-6 text-white mr-1">Tidak Aktif</span>';
                        }
                    }
                }
            })
            ->addColumn('role', function(User $data){
                $color = 'bg-theme-9';
                switch ($data['idrole']) {
                    case 1:
                        $color = 'bg-theme-1';
                        break;
                    case 2:
                        $color = 'bg-theme-9';
                        break;
                    case 3:
                        $color = 'bg-theme-12';
                        break;
                    case 4:
                        $color = 'bg-theme-6';
                        break;
                    case 5:
                        $color = 'bg-theme-1';
                        break;

                    default:
                        $color = 'bg-theme-1';
                        break;
                }
                return '<span class="px-3 py-2 rounded-full '.$color.' text-white mr-1">'.$data->role->keterangan.'</span>';
            })
            ->addColumn('aksi', function(User $data){
                if(in_array(Auth::user()->idrole, ['1','2'])){
                    if ($data['iduser'] != Auth::user()->iduser) {
                        return '<button class="button button--sm w-24 mr-1 mb-2 bg-theme-1 text-white btn-user-edit" data-id="'.$data['iduser'].'">Edit</button>';
                    }else{
                        return 'Tidak Tersedia';
                    }
                }else{
                    if ($data['iduser'] != Auth::user()->iduser && !in_array($data['idrole'], ['1','2'])) {
                        return '<button class="button button--sm w-24 mr-1 mb-2 bg-theme-1 text-white btn-user-edit" data-id="'.$data['iduser'].'">Edit</button>';
                    }else{
                        return 'Tidak Tersedia';
                    }
                }
            })
            ->rawColumns(['status', 'role', 'aksi'])
            ->make(true);
    }

    private function getLastUserId(){
        $last = User::max('iduser');
        return !empty($last)? $last+1:1;
    }

    private function generatePassword($length = 8){
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function create(){
        $data['roles'] = UsersRole::all();
        $data['provinces'] = UtilsProvinsi::where('active', 1)->get();
        $data['mode'] = 'tambah';
        return view('back.user.user-create', $data);
    }

    public function store(Request $request){
        $input = $request->all();

        $valid = Validator::make($input, [
            'username'=>'required|unique:users',
            'email'=>'required|unique:users',
            'role'=>'required',
            'nama'=>'required',
            'gender'=>'required',
            'alamat'=>'required',
        ],[
            'required'=>':attribute harus diisi!',
            'unique'=>':attribute sudah terdaftar'
        ],[
            'username'=>'Username',
            'email'=>'Email',
            'role'=>'Role Akun',
            'nama'=>'Nama Lengkap',
            'gender'=>'Gender Pengguna',
            'alamat'=>'Alamat Pengguna',
            'telepon'=>'Telepon Pengguna'
        ]);

        $valid->sometimes('kecid', 'required', function($input){
            return $input['role'] == 5;
        });

        if(!$valid->fails()){
            $iduser = $this->getLastUserId();
            $raw_pass = strtolower($this->generatePassword(6));
            $data_akun = [
                'iduser'=>$iduser,
                'username'=>strtolower(preg_replace('/\s+/', '', $input['username'])),
                'email'=>$input['email'],
                'idrole'=>$input['role'],
                'password'=>Hash::make($raw_pass),
                'created_at'=>Carbon::now('Asia/Jakarta')->toDateTimeString(),
                'updated_at'=>Carbon::now('Asia/Jakarta')->toDateTimeString(),
                'active'=>'1'
            ];

            $data_detail = [
                'iduser'=>$iduser,
                'nama'=>$input['nama'],
                'gender'=>$input['gender'],
                'alamat'=>$input['alamat'],
                'telepon'=>@$input['telepon'],
            ];

            $data_akun_camat = [];
            if($input['role'] == 5){
                $data_akun_camat = [
                    'iduser'=>$iduser,
                    'idkecamatan'=>$input['kecid']
                ];
            }

            DB::beginTransaction();
            try {
                DB::table('users')->insert($data_akun);
                DB::table('users_detail')->insert($data_detail);
                if ($input['role'] == 5) {
                    DB::table('users_camat')->insert($data_akun_camat);
                }
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
                    'msg'=>'Berhasil menyimpan User. Silakan simpan password berikut ini : '.$raw_pass
                ]);
            }else{
                return response()->json([
                    'status'=>500,
                    'msg'=>'Gagal menyimpan User',
                ]);
            }
        }else{
            return response()->json([
                'status'=>500,
                'msg'=>$valid->errors()->first(),
            ]);
        }
    }

    public function edit($id){
        $user = User::where('iduser', $id)->first();
        if(!empty($user)){
            if((Auth::user()->idrole == 3 && !in_array($user->idrole, ['1','2']) && Auth::user()->iduser != $user->iduser) || (Auth::user()->idrole != 3 && Auth::user()->iduser != $user->iduser)){
                $data['roles'] = UsersRole::all();
                $data['provinces'] = UtilsProvinsi::where('active', 1)->get();
                $data['mode'] = 'edit';
                $data['user'] = $user;
                return view('back.user.user-create', $data);
            }else{
                return back()->with('error', 'Anda tidak memilik akses untuk mengedi user tersebut!');
            }
        }else{
            return back()->with('error', 'User tidak ditemukan');
        }
    }

    public function update(Request $request){
        $input = $request->all();
        $valid = Validator::make($input, [
            'iduser'=>'required',
            'username'=>'required|unique:users,username,'.$input['iduser'].',iduser',
            'email'=>'required|unique:users,email,'.$input['iduser'].',iduser',
            'role'=>'required',
            'nama'=>'required',
            'gender'=>'required',
            'alamat'=>'required',
        ],[
            'required'=>':attribute harus diisi!',
            'unique'=>':attribute sudah terdaftar'
        ],[
            'iduser'=>'User',
            'username'=>'Username',
            'email'=>'Email',
            'role'=>'Role Akun',
            'nama'=>'Nama Lengkap',
            'gender'=>'Gender Pengguna',
            'alamat'=>'Alamat Pengguna',
            'telepon'=>'Telepon Pengguna'
        ]);

        if(!$valid->fails()){
            $data_akun = [
                'username'=>$input['username'],
                'email'=>$input['email'],
                'idrole'=>$input['role'],
                'created_at'=>Carbon::now('Asia/Jakarta')->toDateTimeString(),
                'updated_at'=>Carbon::now('Asia/Jakarta')->toDateTimeString(),
                'active'=>'1'
            ];

            $data_detail = [
                'nama'=>$input['nama'],
                'gender'=>$input['gender'],
                'alamat'=>$input['alamat'],
                'telepon'=>@$input['telepon'],
            ];

            DB::beginTransaction();
            try {
                DB::table('users')->where('iduser', $input['iduser'])->update($data_akun);
                DB::table('users_detail')->where('iduser', $input['iduser'])->update($data_detail);
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
                    'msg'=>'Berhasil mengupdate data User',
                ]);
            }else{
                return response()->json([
                    'status'=>500,
                    'msg'=>'Gagal mengupdate User',
                ]);
            }
        }else{
            return response()->json([
                'status'=>500,
                'msg'=>$valid->errors()->first(),
            ]);
        }
    }

    public function getStatusUser($id){
        $user = User::where('iduser', $id)->first();
        if (!empty($user)) {
            return response()->json([
                'status'=>200,
                'data'=>[
                    'iduser'=>$id,
                    'user'=>$user->username,
                    'mail'=>$user->email,
                    'status'=>$user->active
                ]
            ]);
        }else{
            return response()->json([
                'status'=>500,
                'msg'=>'User tidak ditemukan'
            ]);
        }
    }

    public function ubahStatusUser(Request $request){
        $input = $request->all();
        if(!empty($input['id']) && (!empty($input['status']) || $input['status'] == '0')){
            DB::beginTransaction();
            try {
                DB::table('users')->where('iduser', $input['id'])->update([
                    'active'=>$input['status']
                ]);

                DB::commit();
                $oke = true;
            } catch (\Exception $th) {
                DB::rollback();
                $oke = false;
                dd($th);
            }

            if($oke){
                return response()->json([
                    'status'=>200,
                    'msg'=>'Berhasil mengubah status user'
                ]);
            }else{
                return response()->json([
                    'status'=>500,
                    'msg'=>'Gagal mengubah status user'
                ]);
            }
        }else{
            return response()->json([
                'status'=>500,
                'msg'=>'Id User tidak dapat ditemukan'
            ]);
        }
    }
}
