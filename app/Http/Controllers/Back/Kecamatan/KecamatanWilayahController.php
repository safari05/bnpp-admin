<?php

namespace App\Http\Controllers\Back\Kecamatan;

use App\Http\Controllers\Controller;
use App\Models\Refactored\Kecamatan\KecamatanCoord;
use App\Models\Refactored\Kecamatan\KecamatanWilayah;
use App\Models\Refactored\Utils\UtilsKecamatan;
use App\Traits\KecDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class KecamatanWilayahController extends Controller
{
    use KecDetail;

    public function index($id){
        if (Auth::user()->idrole != 5 || @Auth::user()->kecamatan->idkecamatan == $id) {
            $kecamatan = UtilsKecamatan::where('id', $id)->first();
            $data['kec'] = $kecamatan;
            $data['detail'] = $this->getDetailKecamatan($id);
            $coord = KecamatanCoord::where('id', $id)->first();
            $data['coord'] = [
                'lat'=>$coord->latitude??null,
                'lng'=>$coord->longitude??null
            ];
            $data['wilayah'] = KecamatanWilayah::where('id', $id)->first();

            return view('back.kecamatan.wil.kec-wil', $data);
        }else{
            return back()->with('error', 'Anda tidak memiliki akses ke halaman tersebut');
        }
    }

    public function pin($id){
        if (Auth::user()->idrole != 5 || @Auth::user()->kecamatan->idkecamatan == $id) {
            $kecamatan = UtilsKecamatan::where('id', $id)->first();
            $data['kec'] = $kecamatan;
            $data['mode'] = 'add';
            $coord = KecamatanCoord::where('id', $id)->first();

            $data['coord'] = [
                'lat'=>$coord->latitude??null,
                'lng'=>$coord->longitude??null
            ];

            return view('back.kecamatan.wil.set-map', $data);
        }else{
            return back()->with('error', 'Anda tidak memiliki akses ke halaman tersebut');
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
            'lat:required'=>'Anda belum memilih lokasi Kantor Kecamatan',
            'long:required'=>'Anda belum memilih lokasi Kantor Kecamatan'
        ],
        [
            'id'=>'Kecamatan',
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
                DB::table('kecamatan_coord')->updateOrInsert(
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
                    'msg'=>'Berhasil menyimpan lokasi kantor kecamatan'
                ]);
            }else{
                return response()->json([
                    'status'=>500,
                    'msg'=>'Gagal menyimpan lokasi kantor kecamatan'
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
        if (Auth::user()->idrole != 5 || @Auth::user()->kecamatan->idkecamatan == $id) {
            $kecamatan = UtilsKecamatan::where('id', $id)->first();
            $data['kec'] = $kecamatan;
            $data['mode'] = 'atur';
            $data['tipe'] = $tipe;
            if (in_array($tipe, ['adm', 'batas'])) {
                $data['wilayah'] = KecamatanWilayah::where('id', $id)->first();
                return view('back.kecamatan.wil.atur-wil', $data);
            }else{
                return back()->with('error', 'Form tidak ditemukan');
            }
        }else{
            return back()->with('error', 'Anda tidak memiliki akses ke halaman tersebut');
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
            "id" => "Kecamatan",
            "ibukota" => "Ibukota Kecamatan",
            "luas" => "Luas Wilayah",
            'jarakkot' => 'Jarak ke Kota',
            'jarakprov' => 'Jarak ke Provinsi',
            "desa" => "Jumlah Desa",
            "kelurahan" => "Jumlah Kelurahan",
            "pulau" => "Jumlah Pulau",
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
                'ibukota', 'luas', 'desa', 'kelurahan', 'pulau', 'status_plb', 'jarakkot', 'jarakprov'
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
                        'ibukota_kecamatan'=>$input['ibukota'],
                        'luas_wilayah'=>$input['luas'],
                        'jumlah_desa'=>$input['desa'],
                        'jarak_ke_provinsi'=>$input['jarakprov'],
                        'jarak_ke_kota'=>$input['jarakkot'],
                        'jumlah_kelurahan'=>$input['kelurahan'],
                        'jumlah_pulau'=>$input['pulau'],
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
                    DB::table('kecamatan_wilayah')->updateOrInsert(
                        ['id'=>$input['id']],
                        $data_adm
                    );
                    DB::commit();
                    $oke = true;
                } catch (\Exception $e) {
                    DB::rollback();
                    $oke = false;
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
