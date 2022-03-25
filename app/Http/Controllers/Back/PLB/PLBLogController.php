<?php

namespace App\Http\Controllers\Back\PLB;

use App\Http\Controllers\Controller;
use App\Models\Refactored\Plb\Plb;
use App\Models\Refactored\PLB\PlbLogLintasan;
use App\Models\Refactored\PLB\PlbLogLintasanBarang;
use App\Models\Refactored\PLB\PlbLogLintasanJenisBarang;
use App\Models\Refactored\PLB\PlbLogLintasanOrang;
use App\Models\Refactored\Utils\UtilsProvinsi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PLBLogController extends Controller
{
    public function index(){
        $data['provinces'] = UtilsProvinsi::where('active', 1);
        if(Auth::user()->idrole == 5){
            $data['provinces'] = $data['provinces']->where('id', @Auth::user()->kecamatan->kecamatan->kota->provinsiid);
        }
        $data['provinces'] = $data['provinces']->get();
        return view('back.plb.log.list-lintas', $data);
    }

    public function srcAutocomplete(){
        $data = PlbLogLintasanJenisBarang::get()->pluck('nama')->toArray();
        return response()->json($data);
    }

    public function list(){
        DB::statement(DB::raw('set @rownum=0'));
        $plb = PlbLogLintasan::select([
            DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'idplb',
            'idlintas',
            'tanggal_lintas',
            'jam_lintas',
            'jenis_identitas',
            'nomor_identitas',
            'nama_pelintas',
            'gender_pelintas',
            'tipe_penduduk_pelintas'
        ]);

        if(Auth::user()->idrole == 5){
            $plb = $plb->whereHas('plb', function($q){
                $q->where('kecamatanid', Auth::user()->kecamatan->idkecamatan);
            });
        }

        if(!empty(request()->q)){
            $nama = request()->q;
            $plb = $plb->whereHas('plb', function($q) use($nama){
                $q->where('nama_plb', 'like', '%'.$nama.'%');
            });
        }

        if(!empty(request()->jenis)){
            $jenis = request()->jenis;
            $plb = $plb->whereHas('plb', function($q) use($jenis){
                $q->where('jenis_plb', $jenis);
            });
        }

        if(!empty(request()->kec)){
            $kecid = request()->kec;
            $plb = $plb->whereHas('plb', function($q) use($kecid){
                $q->where('kecamatanid', $kecid);
            });
        }

        if(!empty(request()->kota)){
            $kotaid = request()->kota;
            $plb = $plb->whereHas('plb', function($q) use($kotaid){
                $q->where(DB::raw('SUBSTRING(kecamatanid, 1, 4)'), $kotaid);
            });
        }
        if(!empty(request()->prov)){
            $provid = request()->prov;
            $plb = $plb->whereHas('plb', function($q) use($provid){
                $q->where(DB::raw('SUBSTRING(kecamatanid, 1, 2)'), $provid);
            });
        }

        if(!empty(request()->desa)){
            $desaid = request()->desa;
            $plb = $plb->whereHas('plb', function($q) use($desaid){
                $q->where('desaid', $desaid);
            });
        }
        $plb = $plb->get();

        return \Yajra\DataTables\Facades\DataTables::of($plb)
            ->addColumn('plb', function(PlbLogLintasan $data){
                return @$data->plb->nama_plb;
            })
            ->addColumn('waktu', function(PlbLogLintasan $data){
                return Carbon::parse($data['tanggal_lintas'])->locale('id')->translatedFormat('d M Y').' @ '.$data['jam_lintas'];
            })
            ->addColumn('muatan', function(PlbLogLintasan $data){
                $text = '';
                if(count($data->barang->toArray()) > 0) $text .= 'Barang';
                if (count($data->orang->toArray()) > 0) {
                    if (!empty($text)) {
                        $text .= ' & Orang';
                    }else{
                        $text .= 'Orang';
                    }
                }
                return $text;
            })
            ->addColumn('aksi', function(PlbLogLintasan $data){
                $aksi = '<a href="'.url('plb/log/detail').'/'.$data['idplb'].'-'.$data['idlintas'].'"><button class="button button--sm w-24 mr-1 mb-2 bg-theme-1 text-white">Detail</button></a>';
                // $aksi .= '<button class="button button--sm w-24 mr-1 mb-2 bg-theme-6 text-white" onclick="">Hapus</button>';
                return $aksi;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function getPLB(){
        $data = Plb::select(['idplb', 'nama_plb', 'kecamatanid', 'desaid']);
        if(request()->kecid){
            $data = $data->where('kecamatanid', request()->kecid);
        }
        if(request()->desaid){
            $data = $data->where('desaid', request()->desaid);
        }
        $data = $data->get()->toArray();
        return response()->json($data);
    }

    public function create(){
        $data['provinces'] = UtilsProvinsi::where('active', 1);
        if(Auth::user()->idrole == 5){
            $data['provinces'] = $data['provinces']->where('id', @Auth::user()->kecamatan->kecamatan->kota->provinsiid);
        }
        $data['provinces'] = $data['provinces']->get();
        $data['mode'] = 'tambah';
        return view('back.plb.log.create-lintas', $data);
    }

    private function getLastLintas($idplb){
        $last = PlbLogLintasan::where('idplb', $idplb)->max('idlintas');
        return !empty($last)? $last+1:1;
    }

    private function getLastIdBarang($idplb, $idlintas){
        $last = PlbLogLintasanBarang::where([['idplb', $idplb], ['idlintas', $idlintas]])->max('idbarang');
        return !empty($last)? $last+1:1;
    }

    private function getLastIdOrang($idplb, $idlintas){
        $last = PlbLogLintasanOrang::where([['idplb', $idplb], ['idlintas', $idlintas]])->max('idorang');
        return !empty($last)? $last+1:1;
    }

    private function getLastJenisBarang(){
        $last = PlbLogLintasanJenisBarang::max('idjenis');
        return !empty($last)? $last+1:1;
    }

    private function customValidation($input){
        $data_count = [
            count(array_filter($input['jenis_barang'])),
            count(array_filter($input['nama_barang'])),
            count(array_filter($input['jumlah_barang'])),
            count(array_filter($input['satuan_barang']))
        ];

        if((count(array_filter($input['jenis_barang'])) == max($data_count)) &&
            (count(array_filter($input['nama_barang'])) == max($data_count)) &&
            (count(array_filter($input['jumlah_barang'])) == max($data_count)) &&
            (count(array_filter($input['satuan_barang'])) == max($data_count))){
            return true;
        }else{
            return false;
        }
    }

    public function store(Request $request){
        $input = $request->all();
        // dd($input);
        // dd(Carbon::parse($input['tanggal_lintas'])->format('Y-m-d'));
            $validasi = $this->customValidation($input);
        if ($validasi) {
            $valid = Validator::make($input, [
                "plb" => "required",
                "tanggal_lintas" => "required",
                "waktu_lintas" => "required",
                "zona_waktu" => "required",
                "jenis_identitas" => "required",
                "tipe_penduduk_pelintas" => "required",
                "nomor_identitas" => "required",
                "nama_pelintas" => "required",
                "gender_pelintas" => "required",
                "jenis_barang"=>'array',
                "nama_barang"=>'array',
                "jumlah_barang"=>'array',
                "satuan_barang"=>'array',
                "jumlah_orang"=>'array',
            ],[
                'required'=>':attribute harus diisi',
                'jenis_barang.required'=>':attribute harus minimal 1 data',
                'jenis_barang.array'=>':attribute harus minimal 1 data',
                'jenis_barang.min'=>':attribute harus minimal 1 data',
            ],[
                "plb" => "Pos Lintas Batas",
                "Zona Waktu" => "required",
                "tanggal_lintas" => "Tanggal Lintas",
                "waktu_lintas" => "Waktu Lintas",
                "jenis_identitas" => "Jenis Identitas",
                "tipe_penduduk_pelintas" => "Tipe Penduduk Pelintas",
                "nomor_identitas" => "Nomor Identitas Pelintas",
                "nama_pelintas" => "Nama Pelintas",
                "gender_pelintas" => "Gender Pelintas",
            ]);
            $valid->sometimes(['jenis_barang', 'nama_barang', 'jumlah_barang', 'satuan_barang'], 'required|min:1', function($input){
                return count(array_filter($input['jumlah_orang'])) < 1;
            });
            $valid->sometimes(['jenis_barang.*', 'nama_barang.*', 'jumlah_barang.*', 'satuan_barang.*'], 'required', function($input){
                return count(array_filter($input['jumlah_orang'])) < 1;
            });
            $valid->sometimes('jumlah_orang', 'required|min:1', function($input){
                return count(array_filter($input['jenis_barang'])) < 1;
            });
            $valid->sometimes('jumlah_orang.*', 'required', function($input){
                return count(array_filter($input['jenis_barang'])) < 1;
            });

            if(!$valid->fails()){
                $idlintas = $this->getLastLintas($input['plb']);
                $data_pelintas = [
                    'idplb'=>$input['plb'],
                    'idlintas'=>$idlintas,
                    "tanggal_lintas" => Carbon::parse($input['tanggal_lintas'])->format('Y-m-d'),
                    "jam_lintas" => $input['waktu_lintas'],
                    "zona_waktu" => $input['zona_waktu'],
                    "jenis_identitas" => $input['jenis_identitas'],
                    "tipe_penduduk_pelintas" => $input['tipe_penduduk_pelintas'],
                    "nomor_identitas" => $input['nomor_identitas'],
                    "nama_pelintas" => $input['nama_pelintas'],
                    "gender_pelintas" => $input['gender_pelintas'],
                ];

                $data_barang_muatan = [];
                $data_jenis_barang = [];
                $idbarang = $this->getLastIdBarang($input['plb'], $idlintas);
                foreach ($input['jenis_barang'] as $key => $value) {
                    if ($value != null) {
                        $barang_exist = PlbLogLintasanJenisBarang::where('nama', $value)->first();
                        $idjenisbarang = $this->getLastJenisBarang();
                        if (!empty($barang_exist)) {
                            $idjenisbarang = $barang_exist->idjenis;
                        } else {
                            $idjenisbarang = $idjenisbarang+$key;
                            $temp_jenis = [
                                'idjenis'=>$idjenisbarang,
                                'nama'=>$value,
                            ];

                            array_push($data_jenis_barang, $temp_jenis);
                        }

                        $temp = [
                            'idplb'=>$input['plb'],
                            'idlintas'=>$idlintas,
                            'idbarang'=>$idbarang+$key,
                            'idjenis'=>$idjenisbarang,
                            'nama_barang'=>$input['nama_barang'][$key],
                            'jumlah_barang'=>$input['jumlah_barang'][$key],
                            'satuan_jumlah_barang'=>$input['satuan_barang'][$key],
                        ];

                        array_push($data_barang_muatan, $temp);
                    }
                }

                $data_orang_muatan = [];
                $idorang = $this->getLastIdOrang($input['plb'], $idlintas);
                foreach ($input['jumlah_orang'] as $key => $value) {
                    if (!empty($value)) {
                        $temp = [
                            'idplb'=>$input['plb'],
                            'idlintas'=>$idlintas,
                            'idorang'=>$idorang+$key,
                            'jumlah_orang'=>$value,
                        ];

                        array_push($data_orang_muatan, $temp);
                    }
                }

                DB::beginTransaction();
                try {
                    foreach ($data_jenis_barang as $key => $value) {
                        DB::table('plb_log_lintasan_jenis_barang')->insert($value);
                    }

                    DB::table('plb_log_lintasan')->insert($data_pelintas);
                    foreach ($data_barang_muatan as $key => $value) {
                        DB::table('plb_log_lintasan_barang')->insert($value);
                    }
                    foreach ($data_orang_muatan as $key => $value) {
                        DB::table('plb_log_lintasan_orang')->insert($value);
                    }

                    DB::commit();
                    $oke = true;
                } catch (\Exception $e) {
                    DB::rollback();
                    $oke = false;
                }

                if ($oke) {
                    return response()->json([
                        'status'=>200,
                        'msg'=>'Berhasil menambahkan Log Pos Lintas Batas'
                    ]);
                } else {
                    return response()->json([
                        'status'=>500,
                        'msg'=>'Gagal menambahkan Log Pos Lintas Batas'
                    ]);
                }
            }else{
                if(count(array_filter($input['jumlah_orang'])) < 1 && count(array_filter($input['jenis_barang'])) < 1){
                    return response()->json([
                        'status'=>500,
                        'msg'=>'Salah satu muatan harus diisi (Barang atau Orang)',
                    ]);
                }else{
                    return response()->json([
                        'status'=>500,
                        'msg'=>$valid->errors()->first(),
                    ]);
                }
            }
        }else{
            return response()->json([
                'status'=>500,
                'msg'=>'Informasi barang kurang lengkap, Silakan hapus barang, jika ada informasi yang kosong'
            ]);
        }
    }

    public function detail($id){
        $idplb = explode('-',$id)[0];
        $idlintas = explode('-',$id)[1];

        $data['lintas'] = $lintas = PlbLogLintasan::where([['idplb', $idplb],['idlintas', $idlintas]])->first();

        if (Auth::user()->idrole != 5 || @Auth::user()->kecamatan->idkecamatan == @$lintas->plb->kecamatanid) {
            if (!empty($lintas)) {
                return view('back.plb.log.lintas-detail', $data);
            } else {
                return back()->with('error', 'Catatan Pos Lintas Batas Tidak ditemukan');
            }
        }else{
            return back()->with('error', 'Anda tidak memiliki akses ke halaman tersebut!');
        }
    }

    // public function edit($id){
    //     $data['provinces'] = UtilsProvinsi::where('active', 1)->get();
    //     $data['mode'] = 'edit';
    //     $data['section'] = @request()->sec;
    //     $data['plb'] = Plb::where('idplb', $id)->first();
    //     return view('back.plb.master.create-plb', $data);
    // }

    // public function update(Request $request, $id){
    //     $input = $request->all();

    //     $valid = Validator::make($input, [
    //         "nama" => "required",
    //         "tipe" => "required",
    //         "jenis" => "required",
    //         "alamat" => "required",
    //         // "kecid" => "required",
    //         // "desaid" => "required",
    //     ],[
    //         'required'=>':attribute harus diisi',
    //     ],[
    //         "nama" => "Nama Pos",
    //         "tipe" => "Tipe Pos",
    //         "jenis" => "Jenis Pos",
    //         "alamat" => "Alamat Pos",
    //         "kecid" => "Kecamatan",
    //         "desaid" => "Desa",
    //         "staimig" => "Status Imigrasi",
    //         "karkes" => "Karantina Kesehatan",
    //         "kartan" => "Karantina Pertanian",
    //         "karkan" => "Karantina Perikanan",
    //         "kamtni" => "Keamanan TNI",
    //         "kampol" => "Keamanan POLRI",
    //         "barat" => "Batas Negara Barat",
    //         "timur" => "Batas Negara Timur",
    //         "utara" => "Batas Negara Utara",
    //         "selatan" => "Batas Negara Selatan",
    //         "jenisbatas" => "Jenis Batas Negara Selatan",
    //     ]);

    //     if(!$valid->fails()){
    //         $data_plb = [
    //             'nama_plb'=>$input['nama'],
    //             'jenis_plb'=>$input['jenis'],
    //             'tipe_plb'=>$input['tipe'],
    //             'alamat_plb'=>$input['alamat'],
    //             'status_imigrasi'=>$input['staimig'],
    //             'status_karantina_kesehatan'=>$input['karkes'],
    //             'status_karantina_pertanian'=>$input['kartan'],
    //             'status_karantina_perikanan'=>$input['karkan'],
    //             'status_keamanan_tni'=>$input['kamtni'],
    //             'status_keamanan_polri'=>$input['kampol'],
    //             'jenis_perbatasan'=>$input['jenisbatas'],
    //             'batas_negara_timur'=>$input['timur'],
    //             'batas_negara_barat'=>$input['barat'],
    //             'batas_negara_utara'=>$input['utara'],
    //             'batas_negara_selatan'=>$input['selatan'],
    //             'kecamatanid'=>$input['kecid'],
    //             'desaid'=>$input['desaid'],
    //         ];

    //         DB::beginTransaction();
    //         try {
    //             DB::table('plb')->where('idplb', $id)->update($data_plb);
    //             DB::commit();
    //             $oke = true;
    //         } catch (\Exception $e) {
    //             DB::rollback();
    //             $oke = false;
    //             dd($e);
    //         }

    //         if($oke){
    //             return response()->json([
    //                 'status'=>200,
    //                 'msg'=>'Berhasil mengubah Pos Lintas Batas'
    //             ]);
    //         }else{
    //             return response()->json([
    //                 'status'=>500,
    //                 'msg'=>'Gagal mengubah Pos Lintas Batas'
    //             ]);
    //         }
    //     }else{
    //         return response()->json([
    //             'status'=>500,
    //             'msg'=>$valid->errors()
    //         ]);
    //     }
    // }
}
