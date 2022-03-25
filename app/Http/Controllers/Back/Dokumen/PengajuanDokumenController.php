<?php

namespace App\Http\Controllers\Back\Dokumen;

use App\Http\Controllers\Controller;
use App\Models\Refactored\Dokumen\DokumenKategori;
use App\Models\Refactored\Dokumen\DokumenPengajuan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PengajuanDokumenController extends Controller
{
    private function getLastPengajuan($id, $iduser){
        $last = DokumenPengajuan::where([['iddokumen', $id], ['iduser_pengaju', $iduser]])->max('idpengajuan');
        return !empty($last)? $last + 1: 1;
    }

    public function requestAkses(Request $request){
        $input = $request->all();
        if (!empty($input['id'])) {
            $iduser = Auth::user()->iduser;
            $data_pengaju = [
                'iddokumen'=>$input['id'],
                'iduser_pengaju'=>$iduser,
                'idpengajuan'=>$this->getLastPengajuan($input['id'], $iduser),
                'waktu_pengajuan'=>Carbon::now('Asia/Jakarta')->toDateTimeString(),
                'status_pengajuan'=>'1',
            ];

            DB::beginTransaction();
            try {
                DB::table('dokumen_pengajuan')->insert($data_pengaju);
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
                    'msg'=>'Berhasil mengirimkan pengajuan dokumen'
                ]);
            }else{
                return response()->json([
                    'status'=>500,
                    'msg'=>'Gagal mengirimkan pengajuan dokumen'
                ]);
            }
        }else{
            return response()->json([
                'status'=>500,
                'msg'=>'Dokumen yang diminta tidak ditemukan'
            ]);
        }
    }

    public function index(){
        $data['kategoris'] = DokumenKategori::all();
        return view('back.dokumen.pengajuan.req-list', $data);
    }

    public function list(){
        DB::statement(DB::raw('set @rownum=0'));
        $dokumen = DokumenPengajuan::select([
            DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'iddokumen',
            'iduser_pengaju',
            'idpengajuan',
            'status_pengajuan',
            'waktu_pengajuan',
        ])->whereHas('dokumen', function($q){
            $q->where('uploaded_by', Auth::user()->iduser);
        });

        if(!empty(request()->q)){
            $nama = request()->q;
            $dokumen = $dokumen->whereHas('dokumen', function($q) use($nama){
                $q->where('nama', 'like', '%'.$nama.'%');
            });
        }

        if(!empty(request()->kat)){
            $idkat = request()->kat;
            $dokumen = $dokumen->whereHas('dokumen', function($q) use($idkat){
                $q->where('idkategori', $idkat);
            });
        }

        if(!empty(request()->respon)){
            $respon = request()->respon;
            $dokumen = $dokumen->where('status_pengajuan', $respon);
        }

        $dokumen = $dokumen->get();

        return \Yajra\DataTables\Facades\DataTables::of($dokumen)
            ->addColumn('pengaju', function(DokumenPengajuan $data){
                return $data->pengaju->username;
            })
            ->addColumn('namadok', function(DokumenPengajuan $data){
                return $data->dokumen->nama;
            })
            ->addColumn('katdok', function(DokumenPengajuan $data){
                return $data->dokumen->kategori->keterangan;
            })
            ->addColumn('status', function(DokumenPengajuan $data){
                if($data['status_pengajuan'] == 1) return '<span class="px-3 py-2 bg-theme-1 text-white mr-1">Menunggu</span>';
                else if($data['status_pengajuan'] == 2) return '<span class="px-3 py-2 bg-theme-9 text-white mr-1">Disetujui</span>';
                else if($data['status_pengajuan'] == 3) return '<span class="px-3 py-2 bg-theme-6 text-white mr-1">Ditolak</span>';
            })
            ->addColumn('aksi', function(DokumenPengajuan $data){
                $aksi = '';
                $aksi .= '<a href="'.url('dokumen/manage/detail').'/'.$data['id'].'"><button class="button button--sm w-24 mr-1 mb-2 bg-theme-1 text-white">Detail</button></a>';
                if ($data['status_pengajuan'] == 1) {
                    $aksi .= '<button class="button button--sm w-24 mr-1 mb-2 bg-theme-9 text-white" onclick="respon(\''.$data['iddokumen'].'-'.$data['iduser_pengaju'].'-'.$data['idpengajuan'].'\', 2)">Terima</button>';
                    $aksi .= '<button class="button button--sm w-24 mr-1 mb-2 bg-theme-6 text-white" onclick="respon(\''.$data['iddokumen'].'-'.$data['iduser_pengaju'].'-'.$data['idpengajuan'].'\', 3)">Tolak</button>';
                }else{
                    $aksi .= '<button class="button button--sm w-24 mr-1 mb-2 bg-theme-12 text-white" onclick="respon(\''.$data['iddokumen'].'-'.$data['iduser_pengaju'].'-'.$data['idpengajuan'].'\')">Edit Respon</button>';
                }
                return $aksi;
            })
            ->rawColumns(['status', 'aksi'])
            ->make(true);
    }

    public function getDetailRespon($id){
        $iddok = explode('-', $id)[0];
        $iduser = explode('-', $id)[1];
        $idpengajuan = explode('-', $id)[2];

        $temp = DokumenPengajuan::where([['iddokumen', $iddok], ['iduser_pengaju', $iduser], ['idpengajuan', $idpengajuan]])->first();
        if (!empty($temp)) {
            $data['aju'] = [
                'iddokumen'=>$temp->iddokumen,
                'iduser_pengaju'=>$temp->iduser_pengaju,
                'idpengajuan'=>$temp->idpengajuan,
                'user'=>@$temp->pengaju->username,
                'dokumen'=>@$temp->dokumen->nama,
                'status'=>$temp->status_pengajuan,
            ];

            return response()->json([
                'status'=>200,
                'data'=>$data['aju']
            ]);
        }else{
            return response()->json([
                'status'=>500,
                'msg'=>'Dokumen tidak ditemukan'
            ]);
        }

    }

    public function respon(Request $request){
        $input = $request->all();
        $valid = Validator::make($input, [
            'idseries'=>'required',
            'status'=>'required'
        ]);

        if(!$valid->fails()){
            $iddok = explode('-', $input['idseries'])[0];
            $iduser = explode('-', $input['idseries'])[1];
            $idpengajuan = explode('-', $input['idseries'])[2];
            $status_text = $input['status']==2? 'menyetujui':($input['status']==3? 'menolak':'merespon');
            DB::beginTransaction();
            try {
                DB::table('dokumen_pengajuan')->where([['iddokumen', $iddok], ['iduser_pengaju', $iduser], ['idpengajuan', $idpengajuan]])->update([
                    'status_pengajuan'=>$input['status']
                ]);
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
                    'msg'=>'Berhasil '.$status_text.' pengajuan dokumen'
                ]);
            }else{
                return response()->json([
                    'status'=>500,
                    'msg'=>'Gagal '.$status_text.' pengajuan dokumen'
                ]);
            }
        }else{
            return response()->json([
                'status'=>500,
                'msg'=>$valid->errors()->first()
            ]);
        }
    }

    public function history(){
        $data['kategoris'] = DokumenKategori::all();
        return view('back.dokumen.pengajuan.his-list', $data);
    }

    public function listHistory(){
        DB::statement(DB::raw('set @rownum=0'));
        $dokumen = DokumenPengajuan::select([
            DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'iddokumen',
            'iduser_pengaju',
            'idpengajuan',
            'status_pengajuan',
            'waktu_pengajuan',
        ])->where('iduser_pengaju', Auth::user()->iduser);

        if(!empty(request()->q)){
            $nama = request()->q;
            $dokumen = $dokumen->whereHas('dokumen', function($q) use($nama){
                $q->where('nama', 'like', '%'.$nama.'%');
            });
        }

        if(!empty(request()->kat)){
            $idkat = request()->kat;
            $dokumen = $dokumen->whereHas('dokumen', function($q) use($idkat){
                $q->where('idkategori', $idkat);
            });
        }

        if(!empty(request()->respon)){
            $respon = request()->respon;
            $dokumen = $dokumen->where('status_pengajuan', $respon);
        }

        $dokumen = $dokumen->get();

        return \Yajra\DataTables\Facades\DataTables::of($dokumen)
            ->addColumn('namadok', function(DokumenPengajuan $data){
                return $data->dokumen->nama;
            })
            ->addColumn('katdok', function(DokumenPengajuan $data){
                return $data->dokumen->kategori->keterangan;
            })
            ->addColumn('status', function(DokumenPengajuan $data){
                if($data['status_pengajuan'] == 1) return '<span class="px-3 py-2 bg-theme-1 text-white mr-1">Menunggu</span>';
                else if($data['status_pengajuan'] == 2) return '<span class="px-3 py-2 bg-theme-9 text-white mr-1">Disetujui</span>';
                else if($data['status_pengajuan'] == 3) return '<span class="px-3 py-2 bg-theme-6 text-white mr-1">Ditolak</span>';
            })
            ->addColumn('waktu', function(DokumenPengajuan $data){
                return Carbon::parse($data['waktu_pengajuan'])->locale('id')->translatedFormat('d F Y @ H:i:s');
            })
            ->rawColumns(['status'])
            ->make(true);
    }
}
