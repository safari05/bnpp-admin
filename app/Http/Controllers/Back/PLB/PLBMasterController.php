<?php

namespace App\Http\Controllers\Back\PLB;

use App\Http\Controllers\Controller;
use App\Models\Refactored\Desa\DesaCoord;
use App\Models\Refactored\Kecamatan\KecamatanCoord;
use App\Models\Refactored\Kecamatan\KecamatanLokpri;
use App\Models\Refactored\Kecamatan\KecamatanType;
use App\Models\Refactored\Plb\Plb;
use App\Models\Refactored\PLB\PlbCoord;
use App\Models\Refactored\Utils\UtilsProvinsi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PLBMasterController extends Controller
{
    public function index(){
        $data['provinces'] = UtilsProvinsi::where('active', 1);
        if(Auth::user()->idrole == 5){
            $data['provinces'] = $data['provinces']->where('id', @Auth::user()->kecamatan->kecamatan->kota->provinsiid);
        }
        $data['provinces'] = $data['provinces']->get();
        return view('back.plb.master.list-plb', $data);
    }

    public function list(){
        DB::statement(DB::raw('set @rownum=0'));
        $prov = Plb::select([
            DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'idplb',
            'nama_plb',
            'jenis_plb',
            'alamat_plb',
            'tipe_plb',
            'status_imigrasi',
            'status_karantina_kesehatan',
            'status_karantina_pertanian',
            'status_karantina_perikanan',
            'status_keamanan_tni',
            'status_keamanan_polri',
            'jenis_perbatasan',
            'batas_negara_timur',
            'batas_negara_barat',
            'batas_negara_utara',
            'batas_negara_selatan',
            'kecamatanid',
            'desaid'
        ])->whereHas('desa', function($q){
            $q->where('active', 1);
        })->whereHas('kecamatan', function($q){
            $q->where('active', 1);
        });

        if(Auth::user()->idrole == 5){
            $prov = $prov->where('kecamatanid', Auth::user()->kecamatan->idkecamatan);
        }

        if(!empty(request()->q)){
            $prov = $prov->where('nama_plb', 'like', '%'.request()->q.'%');
        }

        if(!empty(request()->jenis)){
            $prov = $prov->where('jenis_plb', request()->jenis);
        }

        if(!empty(request()->kec)){
            $prov = $prov->where('kecamatanid', request()->kec);
        }

        if(!empty(request()->desa)){
            $prov = $prov->where('desaid', request()->desa);
        }
        $prov = $prov->get();

        return \Yajra\DataTables\Facades\DataTables::of($prov)
            ->addColumn('lokasi', function(Plb $data){
                return @$data->kecamatan->name.', '.@$data->desa->name;
            })
            ->addColumn('jenis', function(Plb $data){
                return ($data->jenis_plb == 1)? 'Non PLBN':'PLBN';
            })
            ->addColumn('aksi', function(Plb $data){
                $aksi = '<a href="'.url('plb/master/detail').'/'.$data['idplb'].'"><button class="button button--sm w-24 mr-1 mb-2 bg-theme-1 text-white">Detail</button></a>';
                $aksi .= '<button class="button button--sm w-24 mr-1 mb-2 bg-theme-6 text-white" onclick="hapusPLB('.$data['idplb'].')">Hapus</button>';
                return $aksi;
            })
            ->rawColumns(['aksi'])
            ->make(true);

    }

    public function create(){
        $data['provinces'] = UtilsProvinsi::where('active', 1);
        if(Auth::user()->idrole == 5){
            $data['provinces'] = $data['provinces']->where('id', @Auth::user()->kecamatan->kecamatan->kota->provinsiid);
        }
        $data['provinces'] = $data['provinces']->get();
        $data['mode'] = 'tambah';
        return view('back.plb.master.create-plb', $data);
    }

    private function getLastPLB(){
        $last = Plb::max('idplb');
        return !empty($last)? $last+1:1;
    }

    public function store(Request $request){
        $input = $request->all();

        $valid = Validator::make($input, [
            "nama" => "required",
            "tipe" => "required",
            "jenis" => "required",
            "alamat" => "required",
            "kecid" => "required",
            "desaid" => "required",
        ],[
            'required'=>':attribute harus diisi',
        ],[
            "nama" => "Nama Pos",
            "tipe" => "Tipe Pos",
            "jenis" => "Jenis Pos",
            "alamat" => "Alamat Pos",
            "kecid" => "Kecamatan",
            "desaid" => "Desa",
            "staimig" => "Status Imigrasi",
            "karkes" => "Karantina Kesehatan",
            "kartan" => "Karantina Pertanian",
            "karkan" => "Karantina Perikanan",
            "kamtni" => "Keamanan TNI",
            "kampol" => "Keamanan POLRI",
            "barat" => "Batas Negara Barat",
            "timur" => "Batas Negara Timur",
            "utara" => "Batas Negara Utara",
            "selatan" => "Batas Negara Selatan",
            "jenisbatas" => "Jenis Batas Negara Selatan",
        ]);

        if(!$valid->fails()){
            $data_plb = [
                'idplb'=>$this->getLastPLB(),
                'nama_plb'=>$input['nama'],
                'jenis_plb'=>$input['jenis'],
                'tipe_plb'=>$input['tipe'],
                'alamat_plb'=>$input['alamat'],
                'status_imigrasi'=>$input['staimig'],
                'status_karantina_kesehatan'=>$input['karkes'],
                'status_karantina_pertanian'=>$input['kartan'],
                'status_karantina_perikanan'=>$input['karkan'],
                'status_keamanan_tni'=>$input['kamtni'],
                'status_keamanan_polri'=>$input['kampol'],
                'jenis_perbatasan'=>$input['jenisbatas'],
                'batas_negara_timur'=>$input['timur'],
                'batas_negara_barat'=>$input['barat'],
                'batas_negara_utara'=>$input['utara'],
                'batas_negara_selatan'=>$input['selatan'],
                'kecamatanid'=>$input['kecid'],
                'desaid'=>$input['desaid'],
            ];

            DB::beginTransaction();
            try {
                DB::table('plb')->insert($data_plb);
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
                    'msg'=>'Berhasil menambahkan Pos Lintas Batas'
                ]);
            }else{
                return response()->json([
                    'status'=>500,
                    'msg'=>'Gagal menambahkan Pos Lintas Batas'
                ]);
            }
        }else{
            return response()->json([
                'status'=>500,
                'msg'=>$valid->errors()
            ]);
        }
    }

    public function detail($id){
        $data['plb'] = $plb = Plb::where('idplb', $id)->first();
        if (Auth::user()->idrole != 5 || @Auth::user()->kecamatan->idkecamatan == @$plb->kecamatanid) {
            $coord = PlbCoord::where('idplb', $id)->first();
            $data['coord'] = [
                'lat'=>@$coord->latitude??null,
                'lng'=>@$coord->longitude??null,
            ];

            $keccoord = @KecamatanCoord::where('id', @$data['plb']->kecamatanid)->first();
            $data['keccoord'] = [
                'lat'=>@$keccoord->latitude??0,
                'lng'=>@$keccoord->longitude??0,
            ];

            $desacoord = @DesaCoord::where('id', @$data['plb']->desaid)->first();
            $data['desacoord'] = [
                'lat'=>@$desacoord->latitude??0,
                'lng'=>@$desacoord->longitude??0,
            ];
            return view('back.plb.master.plb-detail', $data);
        }else{
            return back()->with('error', 'Anda tidak memiliki akses ke halaman tersebut!');
        }
    }

    public function edit($id){
        $data['plb'] = $plb = Plb::where('idplb', $id)->first();
        if (Auth::user()->idrole != 5 || @Auth::user()->kecamatan->idkecamatan == @$plb->kecamatanid) {
            $data['provinces'] = UtilsProvinsi::where('active', 1);
            if (Auth::user()->idrole == 5) {
                $data['provinces'] = $data['provinces']->where('id', @Auth::user()->kecamatan->kecamatan->kota->provinsiid);
            }
            $data['provinces'] = $data['provinces']->get();
            $data['mode'] = 'edit';
            $data['section'] = @request()->sec;
            return view('back.plb.master.create-plb', $data);
        }else{
            return back()->with('error', 'Anda tidak memiliki akses ke halaman tersebut!');
        }
    }

    public function update(Request $request, $id){
        $input = $request->all();

        $valid = Validator::make($input, [
            "nama" => "required",
            "tipe" => "required",
            "jenis" => "required",
            "alamat" => "required",
            // "kecid" => "required",
            // "desaid" => "required",
        ],[
            'required'=>':attribute harus diisi',
        ],[
            "nama" => "Nama Pos",
            "tipe" => "Tipe Pos",
            "jenis" => "Jenis Pos",
            "alamat" => "Alamat Pos",
            "kecid" => "Kecamatan",
            "desaid" => "Desa",
            "staimig" => "Status Imigrasi",
            "karkes" => "Karantina Kesehatan",
            "kartan" => "Karantina Pertanian",
            "karkan" => "Karantina Perikanan",
            "kamtni" => "Keamanan TNI",
            "kampol" => "Keamanan POLRI",
            "barat" => "Batas Negara Barat",
            "timur" => "Batas Negara Timur",
            "utara" => "Batas Negara Utara",
            "selatan" => "Batas Negara Selatan",
            "jenisbatas" => "Jenis Batas Negara Selatan",
        ]);

        if(!$valid->fails()){
            $data_plb = [
                'nama_plb'=>$input['nama'],
                'jenis_plb'=>$input['jenis'],
                'tipe_plb'=>$input['tipe'],
                'alamat_plb'=>$input['alamat'],
                'status_imigrasi'=>$input['staimig'],
                'status_karantina_kesehatan'=>$input['karkes'],
                'status_karantina_pertanian'=>$input['kartan'],
                'status_karantina_perikanan'=>$input['karkan'],
                'status_keamanan_tni'=>$input['kamtni'],
                'status_keamanan_polri'=>$input['kampol'],
                'jenis_perbatasan'=>$input['jenisbatas'],
                'batas_negara_timur'=>$input['timur'],
                'batas_negara_barat'=>$input['barat'],
                'batas_negara_utara'=>$input['utara'],
                'batas_negara_selatan'=>$input['selatan'],
                'kecamatanid'=>$input['kecid'],
                'desaid'=>$input['desaid'],
            ];

            DB::beginTransaction();
            try {
                DB::table('plb')->where('idplb', $id)->update($data_plb);
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
                    'msg'=>'Berhasil mengubah Pos Lintas Batas'
                ]);
            }else{
                return response()->json([
                    'status'=>500,
                    'msg'=>'Gagal mengubah Pos Lintas Batas'
                ]);
            }
        }else{
            return response()->json([
                'status'=>500,
                'msg'=>$valid->errors()
            ]);
        }
    }

    public function delete($id){
        $data['plb'] = $plb = Plb::where('idplb', $id)->first();
        if (Auth::user()->idrole != 5 || @Auth::user()->kecamatan->idkecamatan == @$plb->kecamatanid) {
            if(!empty($data)){
                DB::beginTransaction();
                try {
                    DB::table('plb')->where('idplb', $id)->update([
                        'deleted_at'=>Carbon::now('Asia/Jakarta')->toDateTimeString(),
                    ]);
                    DB::commit();
                    $oke = true;
                } catch (\Exception $th) {
                    DB::rollback();
                    $oke = false;
                }

                if($oke){
                    return response()->json([
                        'status'=>200,
                        'msg'=>'Berhasil menghapus Pos Lintas Batas'
                    ]);
                }else{
                    return response()->json([
                        'status'=>500,
                        'msg'=>'Gagal menghapus Pos Lintas Batas'
                    ]);
                }
            }else{
                return response()->json([
                    'status'=>500,
                    'msg'=>'Kategori tidak ditemukan'
                ]);
            }
        }else{
            return back()->with('error', 'Anda tidak memiliki akses ke halaman tersebut!');
        }
    }

    public function pin($id){
        $data['plb'] = $plb = Plb::where('idplb', $id)->first();
        if (Auth::user()->idrole != 5 || @Auth::user()->kecamatan->idkecamatan == @$plb->kecamatanid) {
            $data['mode'] = 'atur';
            $coord = PlbCoord::where('idplb', $id)->first();

            $data['coord'] = [
                'lat'=>$coord->latitude??null,
                'lng'=>$coord->longitude??null
            ];

            return view('back.plb.master.set-map', $data);
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
                'idplb'=>$input['id'],
                'latitude'=>$input['lat'],
                'longitude'=>$input['long']
            ];

            DB::beginTransaction();
            try {
                DB::table('plb_coord')->updateOrInsert(
                    ['idplb'=> $input['id']],
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
                    'msg'=>'Berhasil menyimpan lokasi Pos Lintas Batas'
                ]);
            }else{
                return response()->json([
                    'status'=>500,
                    'msg'=>'Gagal menyimpan lokasi Pos Lintas Batas'
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
