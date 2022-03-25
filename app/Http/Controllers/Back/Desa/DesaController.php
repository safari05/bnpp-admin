<?php

namespace App\Http\Controllers\Back\Desa;

use App\Http\Controllers\Controller;
use App\Models\Refactored\Desa\DesaKades;
use App\Models\Refactored\Utils\UtilsDesa;
use App\Models\Refactored\Utils\UtilsKota;
use App\Models\Refactored\Utils\UtilsProvinsi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DesaController extends Controller
{
    public function index(){
        $data['provinces'] = UtilsProvinsi::where('active', 1);
        if(Auth::user()->idrole == 5){
            $data['provinces'] = $data['provinces']->where('id', @Auth::user()->kecamatan->kecamatan->kota->provinsiid);
        }

        $data['provinces'] = $data['provinces']->get();
        return view('back.desa.detail.desa-list', $data);
    }

    public function list(){
        DB::statement(DB::raw('set @rownum=0'));
        $prov = UtilsDesa::select([
            DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'id',
            'kecamatanid',
            'name',
            'active'
        ])->where('active', '1');

        if(Auth::user()->idrole == 5){
            $prov = $prov->where('kecamatanid', Auth::user()->kecamatan->idkecamatan);
        }

        if(!empty(request()->q)){
            $prov = $prov->where('name', 'like', '%'.request()->q.'%');
        }

        if(!empty(request()->provid)){
            $id = request()->provid;
            $prov = $prov->whereHas('kecamatan', function($q) use($id){
                $q->whereHas('kota', function($r) use ($id){
                    $r->where('provinsiid', $id);
                });
            });
        }else{
            $prov = $prov->where('kecamatanid', 'like', UtilsKota::where('active', 1)->first()->id.'%');
        }

        if(!empty(request()->kotaid)){
            $idkota = request()->kotaid;
            $prov = $prov->whereHas('kecamatan', function($q) use($idkota){
                $q->where('kotaid', $idkota);
            });
        }else{
            $prov = $prov->where('kecamatanid', 'like', UtilsKota::where('active', 1)->first()->id.'%');
        }

        if(!empty(request()->kecid)){
            $prov = $prov->where('kecamatanid', request()->kecid);
        }

        if(!empty(request()->active) || request()->active == '0'){
            $prov = $prov->where('active', request()->active);
        }

        $prov = $prov->get();

        return \Yajra\DataTables\Facades\DataTables::of($prov)
            ->addColumn('kota', function(UtilsDesa $data){
                return $data->kecamatan->kota->name.', '.$data->kecamatan->kota->provinsi->name;
            })
            ->addColumn('kec', function(UtilsDesa $data){
                return $data->kecamatan->name;
            })
            ->addColumn('aksi', function(UtilsDesa $data){
                return '<button class="button button--sm w-24 mr-1 mb-2 bg-theme-1 text-white btn-desa-detail" data-id="'.$data['id'].'">Detail</button>';
            })
            ->rawColumns(['aksi'])
            ->make(true);

    }

    public function detail($id){
        $data['desa'] = $desa = UtilsDesa::where('id', $id)->first();
        if(Auth::user()->idrole != 5 || @Auth::user()->kecamatan->idkecamatan == @$desa->kecamatanid){
            $data['detail'] = @$desa->detail;
            $data['kades'] = @$desa->detail->kades;
            // dd($data['desa']);
            switch (@$desa->detail->kades->kondisi_kantor) {
                case 1:
                    $data['kades']['kon_kan'] = 'Baik';
                    break;
                case 2:
                    $data['kades']['kon_kan'] = 'Rusak';
                    break;
                case 0:
                    $data['kades']['kon_kan'] = 'Tidak Ada';
                    break;
                default:
                    $data['kades']['kon_kan'] = 'Tidak Ada';
                    break;
            }
            $data['kades']['sta_kan'] = (@$desa->detail->kades->status_kantor==1)?'Ada':'Tidak Ada';

            switch (@$desa->detail->kades->kondisi_balai) {
                case 1:
                    $data['kades']['kon_bal'] = 'Baik';
                    break;
                case 2:
                    $data['kades']['kon_bal'] = 'Rusak';
                    break;
                case 0:
                    $data['kades']['kon_bal'] = 'Tidak Ada';
                    break;
                default:
                    $data['kades']['kon_bal'] = 'Tidak Ada';
                    break;
            }
            $data['kades']['sta_bal'] = (@$desa->detail->kades->status_balai==1)?'Ada':'Tidak Ada';

            $data['kades']['foto_kantor'] = (!empty($desa->detail->kades->foto_kantor))?asset('upload/desa/kantor').'/'.$desa->detail->kades->foto_kantor:asset('assets/back/images/preview-3.jpg');
            $data['kades']['foto_balai'] = (!empty($desa->detail->kades->foto_balai))?asset('upload/desa/balai').'/'.$desa->detail->kades->foto_balai:asset('assets/back/images/preview-3.jpg');

            return view('back.desa.detail.desa-detail', $data);
        }else{
            return back()->with('error', 'Anda tidak memiliki akses ke halaman tersebut!');
        }
    }

    public function getKades($id){
        $data = DesaKades::where('id', $id)->first();
        return response()->json([
            'nama_kades'=>@$data->nama_kades,
            'gender_kades'=>@$data->gender_kades,
            'pendidikan_kades'=>@$data->pendidikan_kades,
        ]);
    }

    public function updateKades(Request $request, $id){
        $input = $request->all();

        $valid = Validator::make($input,
            [
                'nama_kades'=>'required',
                'gender_kades'=>'required',
                'pendidikan_kades'=>'required'
            ],
            [ 'required'=>':attribute harus diisi' ],
            [
                'nama_kades'=>'Nama Kades',
                'gender_kades'=>'Gender Kades',
                'pendidikan_kades'=>'Pendidikan Kades'
            ],
        );

        if(!$valid->fails()){
            $exist = count(DesaKades::where('id', $id)->get()->toArray()) > 0;
            $data_camat = [
                'nama_kades'=>$input['nama_kades'],
                'gender_kades'=>$input['gender_kades'],
                'pendidikan_kades'=>$input['pendidikan_kades'],
            ];

            DB::beginTransaction();
            try {
                if($exist){
                    DB::table('desa_kades')->where('id', $id)->update($data_camat);
                }else{
                    $data_camat['id']=$id;
                    DB::table('desa_kades')->insert($data_camat);
                }
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
                    'msg'=>'Berhasil mengubah Informasi Kepala Desa'
                ]);
            }else{
                return response()->json([
                    'status'=>500,
                    'msg'=>'Gagal mengubah Informasi Kepala Desa'
                ]);
            }
        }else{
            return response()->json([
                'status'=>500,
                'msg'=>$valid->errors()->first()
            ]);
        }
    }

    public function getKantor($id){
        $data = DesaKades::where('id', $id)->first();
        return response()->json([
            'status'=>@$data->status_kantor,
            'alamat'=>@$data->alamat_desa,
            'kondisi'=>@$data->kondisi_kantor,
            'regulasi'=>@$data->regulasi,
        ]);
    }

    public function updateKantor(Request $request, $id){
        $input = $request->all();

        $valid = Validator::make($input,
            [
                'status'=>'required',
                // 'regulasi'=>'required',
                'foto'=>'mimes:png,jpg,jpeg|max:2048'
            ],
            [
                'required'=>':attribute harus diisi',
                'mimes'=>'format :attribute harus :mimes',
                'foto:max'=>'Ukuran maksimal foto adalah :max'
            ],
            [
                'status'=>'Status Kantor',
                'alamat'=>'Alamat Kantor',
                'kondisi'=>'Kondisi Kantor',
                'regulasi'=>'Regulasi',
                'foto'=>'Foto Kantor'
            ],
        );

        $valid->sometimes(['alamat', 'kondisi'], 'required', function() use ($input){
            return $input['status'] == 1;
        });

        if(!$valid->fails()){
            $exist = count(DesaKades::where('id', $id)->get()->toArray()) > 0;
            $data_kantor = [
                'status_kantor'=>$input['status'],
                'alamat_desa'=>($input['status']==0)? '':$input['alamat'],
                'kondisi_kantor'=>($input['status']==0)? '0':$input['kondisi'],
                'regulasi'=>$input['regulasi'],
            ];

            if ($request->has('foto')) {
                $imagename = strtolower('kantor-desa'.preg_replace('/\s+/', '', UtilsDesa::where('id', $id)->first()->name).'-'.time().'.'.$request->foto->extension());
                $request->foto->move(public_path('upload/desa/kantor'), $imagename);
                $data_kantor['foto_kantor'] = $imagename;
            }

            DB::beginTransaction();
            try {
                if($exist){
                    DB::table('desa_kades')->where('id', $id)->update($data_kantor);
                }else{
                    $data_kantor['id']=$id;
                    DB::table('desa_kades')->insert($data_kantor);
                }
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
                    'msg'=>'Berhasil mengubah Informasi Kantor Desa'
                ]);
            }else{
                return response()->json([
                    'status'=>500,
                    'msg'=>'Gagal mengubah Informasi Kantor Desa'
                ]);
            }
        }else{
            return response()->json([
                'status'=>500,
                'msg'=>$valid->errors()->first()
            ]);
        }
    }

    public function getBalai($id){
        $data = DesaKades::where('id', $id)->first();
        return response()->json([
            'status'=>@$data->status_balai,
            'kondisi'=>@$data->kondisi_balai,
        ]);
    }

    public function updateBalai(Request $request, $id){
        $input = $request->all();

        $valid = Validator::make($input,
            [
                'status'=>'required',
                'foto'=>'mimes:png,jpg,jpeg|max:2048'
            ],
            [
                'required'=>':attribute harus diisi',
                'mimes'=>'format :attribute harus :mimes',
                'foto:max'=>'Ukuran maksimal foto adalah :max'
            ],
            [
                'status'=>'Status Balai',
                'kondisi'=>'Kondisi Balai',
                'foto'=>'Foto Balai'
            ],
        );

        $valid->sometimes('kondisi', 'required', function() use ($input){
            return $input['status'] == 1;
        });

        if(!$valid->fails()){
            $exist = count(DesaKades::where('id', $id)->get()->toArray()) > 0;
            $data_balai = [
                'status_balai'=>$input['status'],
                'kondisi_balai'=>($input['status']==0)? '0':$input['kondisi'],
            ];

            if ($request->has('foto')) {
                $imagename = strtolower('balai-desa'.preg_replace('/\s+/', '', UtilsDesa::where('id', $id)->first()->name).'-'.time().'.'.$request->foto->extension());
                $request->foto->move(public_path('upload/desa/balai'), $imagename);
                $data_balai['foto_balai'] = $imagename;
            }

            DB::beginTransaction();
            try {
                if($exist){
                    DB::table('desa_kades')->where('id', $id)->update($data_balai);
                }else{
                    $data_balai['id']=$id;
                    DB::table('desa_kades')->insert($data_balai);
                }
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
                    'msg'=>'Berhasil mengubah Informasi Balai Desa'
                ]);
            }else{
                return response()->json([
                    'status'=>500,
                    'msg'=>'Gagal mengubah Informasi Balai Desa'
                ]);
            }
        }else{
            return response()->json([
                'status'=>500,
                'msg'=>$valid->errors()->first()
            ]);
        }
    }
}
