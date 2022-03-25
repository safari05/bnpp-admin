<?php

namespace App\Http\Controllers\Back\Kecamatan;

use App\Http\Controllers\Controller;
use App\Models\Refactored\Kecamatan\KecamatanCamat;
use App\Models\Refactored\Kecamatan\KecamatanDetail;
use App\Models\Refactored\Kecamatan\KecamatanLokpri;
use App\Models\Refactored\Kecamatan\KecamatanType;
use App\Models\Refactored\Utils\UtilsKecamatan;
use App\Models\Refactored\Utils\UtilsProvinsi;
use App\Traits\KecDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class KecamatanController extends Controller
{
    use KecDetail;
    public function index(){
        if (Auth::user()->idrole != 5) {
            $data['provinces'] = UtilsProvinsi::where('active', 1)->get();
            $data['tipe'] = KecamatanType::all();
            $data['lokpri'] = KecamatanLokpri::all();
            return view('back.kecamatan.detail.kec-list', $data);
        }else{
            return redirect(url('kecamatan/detail').'/'.Auth::user()->kecamatan->idkecamatan);
        }
    }

    public function list(){
        DB::statement(DB::raw('set @rownum=0'));
        $prov = UtilsKecamatan::select([
            DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'id',
            'kotaid',
            'name',
            'active',
        ])
        ->where('active', 1)
        ->whereHas('kota', function($q){
            $q->where('active', 1)->whereHas('provinsi', function($r){
                $r->where('active', 1);
            });
        });

        if(Auth::user()->idrole == 5){
            $prov = $prov->where('id', Auth::user()->kecamatan->idkecamatan);
        }

        if(!empty(request()->q)){
            $prov = $prov->where('name', 'like', '%'.request()->q.'%');
        }

        if(!empty(request()->provid)){
            $id = request()->provid;
            $prov = $prov->whereHas('kota', function($q) use($id){
                $q->where('provinsiid', $id);
            });
        }else{
            $prov = $prov->where('kotaid', 'like', '11%');
        }

        if(!empty(request()->kotaid)){
            $prov = $prov->where('kotaid', request()->kotaid);
        }

        // if(!empty(request()->tipe)){
        //     $tipe = request()->tipe;
        //     $prov = $prov->whereHas('detail', function($q) use($tipe){
        //         $q->where('typeid', 'like', '%'.$tipe.'%');
        //     });
        // }

        if(!empty(request()->lokpri)){
            $lokpri = request()->lokpri;
            $prov = $prov->whereHas('detail', function($q) use($lokpri){
                $q->where('lokpriid', 'like', '%'.$lokpri.'%');
            });
        }

        $prov = $prov->get();

        return \Yajra\DataTables\Facades\DataTables::of($prov)
            ->addColumn('provinsi', function(UtilsKecamatan $data){
                return $data->kota->provinsi->name;
            })
            // ->addColumn('tipe', function(UtilsKecamatan $data){
            //     $cur_types = explode(',', $data->detail->typeid);

            //     $tipe = KecamatanType::select(['typeid', 'nickname'])->whereIn('typeid', $cur_types)->get()->toArray();
            //     $badges = '';
            //     foreach ($tipe as $key => $value) {
            //         if ($value['typeid'] == 1) {
            //             $badges .= '<span class="px-3 py-2 rounded-full bg-theme-9 text-white mr-1">'.$value['nickname'].'</span>';
            //         }else if ($value['typeid'] == 2) {
            //             $badges .= '<span class="px-3 py-2 rounded-full bg-theme-12 text-white mr-1">'.$value['nickname'].'</span>';
            //         }else {
            //             $badges .= '<span class="px-3 py-2 rounded-full bg-theme-6 text-white mr-1">'.$value['nickname'].'</span>';
            //         }
            //     }
            //     return !empty($badges)? $badges:'Data tidak tersedia';
            // })
            ->addColumn('lokpri', function(UtilsKecamatan $data){
                $cur_lokpri = explode(',', $data->detail->lokpriid);

                $tipe = KecamatanLokpri::select('lokpriid', 'nickname')->whereIn('lokpriid', $cur_lokpri)->get()->toArray();
                $badges = '';
                foreach ($tipe as $key => $value) {
                    if ($value['lokpriid'] == 1) {
                        $badges .= '<span class="px-3 py-2 rounded-full bg-theme-9 text-white mr-1">'.$value['nickname'].'</span>';
                    }else if ($value['lokpriid'] == 2) {
                        $badges .= '<span class="px-3 py-2 rounded-full bg-theme-12 text-white mr-1">'.$value['nickname'].'</span>';
                    }else {
                        $badges .= '<span class="px-3 py-2 rounded-full bg-theme-6 text-white mr-1">'.$value['nickname'].'</span>';
                    }
                }
                return !empty($badges)? $badges:'Data tidak tersedia';
            })
            ->addColumn('kota', function(UtilsKecamatan $data){
                return $data->kota->name;
            })
            ->addColumn('aksi', function(UtilsKecamatan $data){
                $aksi = '<button class="button button--sm w-24 mr-1 mb-2 bg-theme-1 text-white btn-detail" data-id="'.$data['id'].'">Detail</button>';
                return $aksi;
            })
            ->rawColumns(['tipe', 'lokpri', 'aksi'])
            ->make(true);

    }

    public function detail($id){
        if(Auth::user()->idrole != 5 || @Auth::user()->kecamatan->idkecamatan == $id){
            $kecamatan = UtilsKecamatan::where('id', $id)->first();
            $data['kec'] = $kecamatan;
            $data['detail'] = $kecamatan->detail;
            $data['camat'] = $kecamatan->detail->camat;

            switch (@$kecamatan->detail->camat->kondisi_kantor) {
                case 1:
                    $data['camat']['kon_kan'] = 'Baik';
                    break;
                case 2:
                    $data['camat']['kon_kan'] = 'Rusak';
                    break;
                case 0:
                    $data['camat']['kon_kan'] = 'Tidak Ada';
                    break;
                default:
                    $data['camat']['kon_kan'] = 'Tidak Ada';
                    break;
            }
            $data['camat']['sta_kan'] = (@$kecamatan->detail->camat->status_kantor==1)?'Ada':'Tidak Ada';

            switch (@$kecamatan->detail->camat->kondisi_balai) {
                case 1:
                    $data['camat']['kon_bal'] = 'Baik';
                    break;
                case 2:
                    $data['camat']['kon_bal'] = 'Rusak';
                    break;
                case 0:
                    $data['camat']['kon_bal'] = 'Tidak Ada';
                    break;
                default:
                    $data['camat']['kon_bal'] = 'Tidak Ada';
                    break;
            }
            $data['camat']['sta_bal'] = (@$kecamatan->detail->camat->status_balai==1)?'Ada':'Tidak Ada';

            $data['camat']['foto_kantor'] = (!empty($kecamatan->detail->camat->foto_kantor))?asset('upload/camat/kantor').'/'.$kecamatan->detail->camat->foto_kantor:asset('assets/back/images/preview-3.jpg');
            $data['camat']['foto_balai'] = (!empty($kecamatan->detail->camat->foto_balai))?asset('upload/camat/balai').'/'.$kecamatan->detail->camat->foto_balai:asset('assets/back/images/preview-3.jpg');

            $data['detail'] = $this->getDetailKecamatan($id);

            return view('back.kecamatan.detail.kec-detail', $data);
        }else{
            return back()->with('error', 'Anda tidak memiliki akses ke halaman tersebut!');
        }
    }

    public function getCamat($id){
        if (Auth::user()->idrole != 5 || @Auth::user()->kecamatan->idkecamatan == $id) {
            $data = KecamatanCamat::where('id', $id)->first();
            return response()->json([
                'nama_camat'=>@$data->nama_camat,
                'gender_camat'=>@$data->gender_camat,
                'pendidikan_camat'=>@$data->pendidikan_camat,
            ]);
        }
    }

    public function updateCamat(Request $request, $id){
        if (Auth::user()->idrole != 5 || @Auth::user()->kecamatan->idkecamatan == $id) {
            $input = $request->all();
            $valid = Validator::make(
                $input,
                [
                    'nama_camat'=>'required',
                    'gender_camat'=>'required',
                    'pendidikan_camat'=>'required'
                ],
                [ 'required'=>':attribute harus diisi' ],
                [
                    'nama_camat'=>'Nama Camat',
                    'gender_camat'=>'Gender Camat',
                    'pendidikan_camat'=>'Pendidikan Camat'
                ],
            );

            if (!$valid->fails()) {
                $exist = count(KecamatanCamat::where('id', $id)->get()->toArray()) > 0;
                $data_camat = [
                    'nama_camat'=>$input['nama_camat'],
                    'gender_camat'=>$input['gender_camat'],
                    'pendidikan_camat'=>$input['pendidikan_camat'],
                ];

                DB::beginTransaction();
                try {
                    if ($exist) {
                        DB::table('kecamatan_camat')->where('id', $id)->update($data_camat);
                    } else {
                        $data_camat['id']=$id;
                        DB::table('kecamatan_camat')->insert($data_camat);
                    }
                    DB::commit();
                    $oke = true;
                } catch (\Exception $th) {
                    DB::rollback();
                    $oke = false;
                    dd($th);
                }

                if ($oke) {
                    return response()->json([
                        'status'=>200,
                        'msg'=>'Berhasil mengubah Informasi Camat'
                    ]);
                } else {
                    return response()->json([
                        'status'=>500,
                        'msg'=>'Gagal mengubah Informasi Camat'
                    ]);
                }
            } else {
                return response()->json([
                    'status'=>500,
                    'msg'=>$valid->errors()->first()
                ]);
            }
        }else{
            return response()->json([
                'status'=>500,
                'msg'=>'Anda tidak memiliki akses ke halaman tersebut'
            ]);
        }
    }

    public function getKantor($id){
        if (Auth::user()->idrole != 5 || @Auth::user()->kecamatan->idkecamatan == $id) {
            $data = KecamatanCamat::where('id', $id)->first();
            return response()->json([
                'status'=>@$data->status_kantor,
                'alamat'=>@$data->alamat_kantor,
                'kondisi'=>@$data->kondisi_kantor,
                'regulasi'=>@$data->regulasi,
            ]);
        }
    }

    public function updateKantor(Request $request, $id){
        if (Auth::user()->idrole != 5 || @Auth::user()->kecamatan->idkecamatan == $id) {
            $input = $request->all();

            $valid = Validator::make(
                $input,
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

            $valid->sometimes(['alamat', 'kondisi'], 'required', function () use ($input) {
                return $input['status'] == 1;
            });

            if (!$valid->fails()) {
                $exist = count(KecamatanCamat::where('id', $id)->get()->toArray()) > 0;
                $data_kantor = [
                    'status_kantor'=>$input['status'],
                    'alamat_kantor'=>($input['status']==0)? '':$input['alamat'],
                    'kondisi_kantor'=>($input['status']==0)? '0':$input['kondisi'],
                    'regulasi'=>$input['regulasi'],
                ];

                if ($request->has('foto')) {
                    $imagename = strtolower('kantor-kec'.preg_replace('/\s+/', '', UtilsKecamatan::where('id', $id)->first()->name).'-'.time().'.'.$request->foto->extension());
                    $request->foto->move(public_path('upload/camat/kantor'), $imagename);
                    $data_kantor['foto_kantor'] = $imagename;
                }

                DB::beginTransaction();
                try {
                    if ($exist) {
                        DB::table('kecamatan_camat')->where('id', $id)->update($data_kantor);
                    } else {
                        $data_kantor['id']=$id;
                        DB::table('kecamatan_camat')->insert($data_kantor);
                    }
                    DB::commit();
                    $oke = true;
                } catch (\Exception $th) {
                    DB::rollback();
                    $oke = false;
                    dd($th);
                }

                if ($oke) {
                    return response()->json([
                        'status'=>200,
                        'msg'=>'Berhasil mengubah Informasi Kantor Kecamatan'
                    ]);
                } else {
                    return response()->json([
                        'status'=>500,
                        'msg'=>'Gagal mengubah Informasi Kantor Kecamatan'
                    ]);
                }
            } else {
                return response()->json([
                    'status'=>500,
                    'msg'=>$valid->errors()->first()
                ]);
            }
        }else{
            return response()->json([
                'status'=>500,
                'msg'=>'Anda tidak memiliki akses ke halaman tersebut'
            ]);
        }
    }

    public function getBalai($id){
        if (Auth::user()->idrole != 5 || @Auth::user()->kecamatan->idkecamatan == $id) {
            $data = KecamatanCamat::where('id', $id)->first();
            return response()->json([
                'status'=>@$data->status_balai,
                'kondisi'=>@$data->kondisi_balai,
            ]);
        }
    }

    public function updateBalai(Request $request, $id){
        if (Auth::user()->idrole != 5 || @Auth::user()->kecamatan->idkecamatan == $id) {
            $input = $request->all();

            $valid = Validator::make(
                $input,
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

            $valid->sometimes('kondisi', 'required', function () use ($input) {
                return $input['status'] == 1;
            });

            if (!$valid->fails()) {
                $exist = count(KecamatanCamat::where('id', $id)->get()->toArray()) > 0;
                $data_balai = [
                    'status_balai'=>$input['status'],
                    'kondisi_balai'=>($input['status']==0)? '0':$input['kondisi'],
                ];

                if ($request->has('foto')) {
                    $imagename = strtolower('balai-kec'.preg_replace('/\s+/', '', UtilsKecamatan::where('id', $id)->first()->name).'-'.time().'.'.$request->foto->extension());
                    $request->foto->move(public_path('upload/camat/balai'), $imagename);
                    $data_balai['foto_balai'] = $imagename;
                }

                DB::beginTransaction();
                try {
                    if ($exist) {
                        DB::table('kecamatan_camat')->where('id', $id)->update($data_balai);
                    } else {
                        $data_balai['id']=$id;
                        DB::table('kecamatan_camat')->insert($data_balai);
                    }
                    DB::commit();
                    $oke = true;
                } catch (\Exception $th) {
                    DB::rollback();
                    $oke = false;
                    dd($th);
                }

                if ($oke) {
                    return response()->json([
                        'status'=>200,
                        'msg'=>'Berhasil mengubah Informasi Balai Kecamatan'
                    ]);
                } else {
                    return response()->json([
                        'status'=>500,
                        'msg'=>'Gagal mengubah Informasi Balai Kecamatan'
                    ]);
                }
            } else {
                return response()->json([
                    'status'=>500,
                    'msg'=>$valid->errors()->first()
                ]);
            }
        }else{
            return response()->json([
                'status'=>500,
                'msg'=>'Anda tidak memiliki akses ke halaman tersebut'
            ]);
        }
    }
}
