<?php

namespace App\Http\Controllers\Back\Desa;

use App\Http\Controllers\Controller;
use App\Models\Refactored\Desa\DesaCoord;
use App\Models\Refactored\Desa\DesaWilayah;
use App\Models\Refactored\Utils\UtilsDesa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DesaWilayahController extends Controller
{
    public function index($id){
        $data['desa'] = $desa = UtilsDesa::where('id', $id)->first();
        if (Auth::user()->idrole != 5 || @Auth::user()->kecamatan->idkecamatan == @$desa->kecamatanid) {
            $coord = DesaCoord::where('id', $id)->first();
            $data['coord'] = [
                'lat'=>$coord->latitude??null,
                'lng'=>$coord->longitude??null
            ];
            $data['wilayah'] = DesaWilayah::where('id', $id)->first();

            return view('back.desa.wil.desa-wil', $data);
        }else{
            return back()->with('error', 'Anda tidak memiliki akses ke halaman tersebut!');
        }
    }

    public function pin($id){
        $data['desa'] = $desa = UtilsDesa::where('id', $id)->first();
        if (Auth::user()->idrole != 5 || @Auth::user()->kecamatan->idkecamatan == @$desa->kecamatanid) {
            $data['mode'] = 'add';
            $coord = DesaCoord::where('id', $id)->first();

            $data['coord'] = [
                'lat'=>$coord->latitude??null,
                'lng'=>$coord->longitude??null
            ];

            return view('back.desa.wil.set-map', $data);
        }else{
            return back()->with('error', 'Anda tidak memiliki akses ke halaman tersebut!');
        }
    }

    public function setCoord(Request $request){
        $input = $request->all();
        $valid = Validator::make($input, [
            'id'=>'required',
            'lat'=>'required',
            'long'=>'required',
        ],
        [
            'required'=>':attribute harus diisi!',
            'lat:required'=>'Anda belum memilih lokasi Kantor Desa',
            'long:required'=>'Anda belum memilih lokasi Kantor Desa'
        ],
        [
            'id'=>'Desa',
            'lat'=>'Latitude',
            'long'=>'Longitude'
        ]);

        if(!$valid->fails()){
            $data_coord = [
                'id'=>$input['id'],
                'latitude'=>$input['lat'],
                'longitude'=>$input['long']
            ];

            DB::beginTransaction();
            try {
                DB::table('desa_coord')->updateOrInsert(
                    ['id'=> $input['id']],
                    $data_coord
                );
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
                    'msg'=>'Berhasil menyimpan lokasi kantor desa'
                ]);
            }else{
                return response()->json([
                    'status'=>500,
                    'msg'=>'Gagal menyimpan lokasi kantor desa'
                ]);
            }
        }else{
            return response()->json([
                'status'=>500,
                'msg'=>$valid->errors()->first(),
            ]);
        }
    }

    public function atur($id, $tipe){
        $data['desa'] = $desa = UtilsDesa::where('id', $id)->first();
        if (Auth::user()->idrole != 5 || @Auth::user()->kecamatan->idkecamatan == @$desa->kecamatanid) {
            $data['mode'] = 'atur';
            $data['tipe'] = $tipe;
            if (in_array($tipe, ['adm', 'batas'])) {
                $data['wilayah'] = DesaWilayah::where('id', $id)->first();
                return view('back.desa.wil.atur-wil', $data);
            }else{
                return back()->with('error', 'Form tidak ditemukan');
            }
        }else{
            return back()->with('error', 'Anda tidak memiliki akses ke halaman tersebut!');
        }
    }

    public function storeWilayah(Request $request){
        $input = $request->all();

        $valid = Validator::make($input, [
            'tipe'=>'required',
            'id'=>'required',
        ],[
            'requried'=>'::attribute harus diisi'
        ],[
            "id" => "Desa",
            "jarakkab"=> "Jarak ke Kabupaten",
            "jarakkec"=> "Jarak ke Kecamatan",
            "ibukota" => "Ibukota Desa",
            "luas" => "Luas Wilayah",
            "status_plb" => "Status PLB",
            "plb" => "PLB",
            "barat" => "Batas Barat",
            "timur" => "Batas Timur",
            "utara" => "Batas Utara",
            "selatan" => "Batas Selatan",
            "jenis_negara" => "Jenis Batas Negara",
            "negara" => "Negara Perbatasan",
        ]);

        if(!$valid->fails()){
            $tipe = $input['tipe'];
            $stat_plb = $input['status_plb']??false;

            $valid->sometimes([
                'ibukota', 'luas', 'status_plb', 'jarakkab', 'jarakkec'
            ], 'required', function() use ($tipe){
                return $tipe == 'adm';
            });
            $valid->sometimes('plb', 'required', function() use ($tipe, $stat_plb){
                return $tipe == 'adm' && $stat_plb;
            });

            $valid->sometimes([
                'barat', 'timur', 'utara', 'selatan', 'jenis_negara'
            ], 'required', function() use ($tipe){
                return $tipe == 'batas';
            });

            $jenis_negara = (@$input['jenis_negara']!=0)?true:false;
            $valid->sometimes('negara', 'required', function() use ($tipe, $jenis_negara){
                return $tipe == 'batas' && $jenis_negara;
            });

            if(!$valid->fails()){
                $oke = false;
                if ($tipe=='adm') {
                    $data_adm = [
                        'ibukota_desa'=>$input['ibukota'],
                        'luas_wilayah'=>$input['luas'],
                        'jarak_ke_kabupaten'=>$input['jarakkab'],
                        'jarak_ke_kecamatan'=>$input['jarakkec'],
                        'status_plb'=>($input['status_plb']==0)?null:$input['status_plb'],
                        'nama_plb'=>($input['status_plb']==0)?null:$input['plb'],
                    ];
                }else if($tipe == 'batas'){
                    $data_adm = [
                        'batas_barat'=>$input['barat'],
                        'batas_timur'=>$input['timur'],
                        'batas_utara'=>$input['utara'],
                        'batas_selatan'=>$input['selatan'],
                        'batas_negara'=>($input['jenis_negara']==0)?null:$input['negara'],
                        'batas_negara_jenis'=>($input['jenis_negara']==0)?null:$input['jenis_negara'],
                    ];
                }

                DB::beginTransaction();
                try {
                    DB::table('desa_wilayah')->updateOrInsert(
                        ['id'=>$input['id']],
                        $data_adm
                    );
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
                        'msg'=>'Berhasil menyimpan data wilayah'
                    ]);
                }else{
                    return response()->json([
                        'status'=>500,
                        'msg'=>'Gagal menyimpan data wilayah'
                    ]);
                }

            }else{
                return response()->json([
                    'status'=>500,
                    'msg'=>$valid->errors()->first()
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
