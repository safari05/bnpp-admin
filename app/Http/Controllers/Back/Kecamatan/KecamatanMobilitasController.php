<?php

namespace App\Http\Controllers\Back\Kecamatan;

use App\Http\Controllers\Controller;
use App\Models\Refactored\Kecamatan\KecamatanMobilitas;
use App\Models\Refactored\Master\MobilitasItem;
use App\Models\Refactored\Utils\UtilsKecamatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class KecamatanMobilitasController extends Controller
{
    public function srcAutocomplete(){
        $data = MobilitasItem::get()->pluck('nama')->toArray();
        return response()->json($data);
    }

    public function listMobil($id){
        DB::statement(DB::raw('set @rownum=0'));
        $prov = KecamatanMobilitas::select([
            DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'id',
            'idmobilitas',
            'jumlah',
            'foto',
        ]);

        if(Auth::user()->idrole != 5) $prov = $prov->where('id', $id);
        else $prov = $prov->where('id', @Auth::user()->kecamatan->idkecamatan);

        if(!empty(request()->q)){
            $nama = request()->q;
            $prov = $prov->whereHas('mobilitas', function($q) use($nama){
                $q->where('nama', 'like', $nama);
            });
        }

        $prov = $prov->get();

        return \Yajra\DataTables\Facades\DataTables::of($prov)
            ->addColumn('nama', function(KecamatanMobilitas $data){
                return $data->item->nama;
            })
            ->editColumn('jumlah', function(KecamatanMobilitas $data){
                return number_format($data->jumlah, 0, ',', '.');
            })
            ->editColumn('foto', function(KecamatanMobilitas $data){
                if(empty($data['foto'])){
                    return 'Tidak tersedia';
                }else{
                    return '<button class="button w-24 inline-block mr-1 mb-2 border border-theme-1 text-theme-1 dark:border-theme-10 dark:text-theme-10 btn-foto-mobil" data-url="'.asset('upload/mobilitas').'/'.$data['foto'].'">Lihat Foto</button>';
                }
                return number_format($data->jumlah, 0, ',', '.');
            })
            ->addColumn('aksi', function(KecamatanMobilitas $data){
                $aksi = '<button class="button button--sm w-24 mr-1 mb-2 bg-theme-1 text-white btn-edit-mobil" data-id="'.$data['idmobilitas'].'">Edit</button>';
                return $aksi;
            })
            ->rawColumns(['aksi', 'foto'])
            ->make(true);
    }

    public function chartMobil($id){
        if (Auth::user()->idrole != 5 || @Auth::user()->kecamatan->idkecamatan == $id) {
            $aset = KecamatanMobilitas::where('id', $id)->get();
            $data['warna_baik'] = 'rgba(143, 247, 45, 0.4)';
            $data['border_baik'] = 'rgba(143, 247, 45, 1)';
            $data['warna_rusak'] = 'rgba(247, 45, 45, 0.4)';
            $data['border_rusak'] = 'rgba(247, 45, 45, 1)';

            $chart = [
                'label'=>[],
                'jumlah'=>[],
            ];
            foreach ($aset as $key => $value) {
                array_push($chart['label'], $value->item->nama);
                array_push($chart['jumlah'], $value->jumlah);
            }

            $data['chart'] = $chart;

            return response()->json($data);
        }
    }

    public function create($id){
        if (Auth::user()->idrole != 5 || @Auth::user()->kecamatan->idkecamatan == $id) {
            $kecamatan = UtilsKecamatan::where('id', $id)->first();
            $data['kec'] = $kecamatan;
            $data['mode'] = 'add';
            return view('back.kecamatan.aset.create-mobilitas', $data);
        }else{
            return back()->with('error', 'Anda tidak memiliki akses ke halaman tersebut!');
        }
    }

    private function getLastIdMobilitas(){
        $last = MobilitasItem::max('idmobilitas');
        return !empty($last)? $last+1:1;
    }

    public function store(Request $request){
        $input = $request->all();
        // dd($input);
        $valid = Validator::make($input,
        [
            'id'=>'required',
            'nama'=>'required',
            'jumlah'=>'required'
        ],
        [
            'required'=>':attribute harus diisi!',
        ],
        [
            'id'=>'Kecamatan',
            'nama'=>'Nama Item',
            'jumlah'=>'Jumlah Item',
        ]);

        if(!$valid->fails()){
            $exist = MobilitasItem::where('nama', $input['nama'])->first();
            $data_master = [
                'idmobilitas'=>@$exist->idmobilitas
            ];

            if(empty($exist)){
                $idmobilitas = $this->getLastIdMobilitas();
                $data_master = [
                    'idmobilitas'=>$idmobilitas,
                    'nama'=>$input['nama'],
                    'ishapus'=>'0',
                ];
            }

            $data_mobil = [
                'id'=>$input['id'],
                'idmobilitas'=>$data_master['idmobilitas'],
                'jumlah'=>(int)$input['jumlah'],
            ];

            if ($request->has('foto')) {
                $imagename = strtolower('m-'.$input['nama'].'-kec-'.preg_replace('/\s+/', '', UtilsKecamatan::where('id', $input['id'])->first()->name).'-'.time().'.'.$request->foto->extension());
                $request->foto->move(public_path('upload/mobilitas'), $imagename);
                $data_mobil['foto'] = $imagename;
            }

            $mobil_exist = KecamatanMobilitas::where([['id', $input['id']], ['idmobilitas', $data_master['idmobilitas']]])->first();

            if(!empty($mobil_exist)){
                $data_mobil['jumlah'] += (int)$mobil_exist['jumlah'];
            }

            DB::beginTransaction();
            try {
                if(empty($exist)){
                    DB::table('mobilitas_item')->insert($data_master);
                }

                if (empty($mobil_exist)) {
                    DB::table('kecamatan_mobilitas')->insert($data_mobil);
                }else{
                    DB::table('kecamatan_mobilitas')->where([['id', $input['id']], ['idmobilitas', $data_master['idmobilitas']]])->update($data_mobil);
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
                    'msg'=>'Berhasil menambahkan Mobilitas',
                ]);
            }else{
                return response()->json([
                    'status'=>500,
                    'msg'=>'Gagal menambahkan Mobilitas',
                ]);
            }

        }else{
            return response()->json([
                'status'=>500,
                'msg'=>$valid->errors()->first()
            ]);
        }
    }

    public function edit($id, $idmobilitas){
        if (Auth::user()->idrole != 5 || @Auth::user()->kecamatan->idkecamatan == $id) {
            $mobil = KecamatanMobilitas::where([['id', $id], ['idmobilitas', $idmobilitas]])->first();
            if(!empty($mobil)){
                $kecamatan = UtilsKecamatan::where('id', $id)->first();
                $data['kec'] = $kecamatan;
                $data['mobil'] = $mobil;
                $data['mode'] = 'edit';

                return view('back.kecamatan.aset.create-mobilitas', $data);
            }else{
                return back()->with('error', 'Mobilitas tidak ditemukan');
            }
        }else{
            return back()->with('error', 'Anda tidak memiliki akses ke halaman tersebut!');
        }
    }

    public function update(Request $request){
        $input = $request->all();

        $valid = Validator::make($input,
        [
            'id'=>'required',
            'idmobilitas'=>'required',
            'jumlah'=>'required',
        ],
        [
            'required'=>':attribute harus diisi!',
        ],
        [
            'id'=>'Kecamatan',
            'idmobilitas'=>'Mobilitas Item',
            'jumlah'=>'Jumlah Item',
        ]);

        if(!$valid->fails()){
            $data_mobil = [
                'jumlah'=>(int)$input['jumlah'],
            ];

            if ($request->has('foto')) {
                $imagename = strtolower('m-'.$input['nama'].'-kec-'.preg_replace('/\s+/', '', UtilsKecamatan::where('id', $input['id'])->first()->name).'-'.time().'.'.$request->foto->extension());
                $request->foto->move(public_path('upload/mobilitas/'), $imagename);
                $data_mobil['foto'] = $imagename;
            }

            DB::beginTransaction();
            try {
                DB::table('kecamatan_mobilitas')->where([['id', $input['id']], ['idmobilitas', $input['idmobilitas']]])->update($data_mobil);
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
                    'msg'=>'Berhasil mengupdate Mobilitas',
                ]);
            }else{
                return response()->json([
                    'status'=>500,
                    'msg'=>'Gagal mengupdate Mobilitas',
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
