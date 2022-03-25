<?php

namespace App\Http\Controllers\Back\Dokumen;

use App\Http\Controllers\Controller;
use App\Models\Refactored\Dokumen\Dokumen;
use App\Models\Refactored\Dokumen\DokumenKategori;
use App\Models\Refactored\Dokumen\DokumenPengajuan;
use App\Traits\UserKecamatan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DokumenController extends Controller
{
    use UserKecamatan;

    private function getAksesDokumen(){
        $iduser = Auth::user()->iduser;
        $iddok = DokumenPengajuan::where([['iduser_pengaju', $iduser], ['status_pengajuan', 2]])->get()->pluck('iddokumen')->toArray();
        return array_unique($iddok);
    }

    private function getWaitAcc(){
        $iduser = Auth::user()->iduser;
        $iddok = DokumenPengajuan::where([['iduser_pengaju', $iduser], ['status_pengajuan', 1]])->get()->pluck('iddokumen')->toArray();
        return array_unique($iddok);
    }

    public function index(){
        $data['kategoris'] = DokumenKategori::all();
        return view('back.dokumen.dok-list', $data);
    }

    public function list(){
        DB::statement(DB::raw('set @rownum=0'));
        $dokumen = Dokumen::select([
            DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'id', 'nama', 'file', 'deskripsi', 'idkategori', 'tahun', 'ispublic', 'created_at', 'uploaded_by', 'validated', 'validated_by'
        ]);

        // if(Auth::user()->idrole == 5){
        //     $dokumen = $dokumen->where(function($q){
        //         $q->whereIn('uploaded_by', $this->getUserKecamatan())->orWhere('ispublic', 1);
        //     });
        // }else{
        //     $dokumen = $dokumen->where(function($q){
        //         $q->whereIn('uploaded_by', [Auth::user()->iduser])->orWhere('ispublic', 1);
        //     });
        // }

        if(!empty(request()->q)){
            $nama = request()->q;
            $dokumen = $dokumen->where('keterangan', 'like', '%'.$nama.'%');
        }

        if(!empty(request()->kat)){
            $idkat = request()->kat;
            $dokumen = $dokumen->where('idkategori', $idkat);
        }

        if(!empty(request()->akses) || request()->akses == 0){
            $akses = request()->akses;
            if ($akses >= 0) {
                $dokumen = $dokumen->where('ispublic', $akses);
            }
        }

        $dokumen = $dokumen->get();

        return \Yajra\DataTables\Facades\DataTables::of($dokumen)
            ->editColumn('akses', function(Dokumen $data){
                $onclick = '';
                if (Auth::user()->iduser == $data['uploaded_by']) {
                    $onclick = 'onclick="ubahPublic('.$data['id'].')"';
                }else{
                    $onclick = 'style="cursor:default;"';
                }
                if ($data['ispublic'] == 1) {
                    return '<button class="button button--sm w-24 mr-1 mb-2 bg-theme-1 text-white" '.$onclick.'>Public</button>';
                } else {
                    return '<button class="button button--sm w-24 mr-1 mb-2 bg-theme-12 text-white" '.$onclick.'>Private</button>';
                }
            })
            ->addColumn('kategori', function(Dokumen $data){
                return $data->kategori->keterangan;
            })
            // ->addColumn('validasi', function(Dokumen $data){
            //     if (!empty($data['validated'])) {
            //         return '<span class="button button--sm w-24 mr-1 mb-2 bg-theme-1 text-white">Divalidasi</span>';
            //     } else {
            //         return '<span class="button button--sm w-24 mr-1 mb-2 bg-theme-12 text-white">Belum divalidasi</span>';
            //     }
            // })
            ->addColumn('aksi', function(Dokumen $data){
                $aksi = '';
                if(Auth::user()->idrole == 5){
                    if ($data['ispublic'] == 1 || in_array($data['uploaded_by'], $this->getUserKecamatan()) || in_array($data['id'], $this->getAksesDokumen())) {
                        $aksi = '<a href="'.asset('upload/dokumen').'/'.$data['file'].'" target="_blank"><button class="button button--sm w-24 mr-1 mb-2 bg-theme-9 text-white">Download</button></a>';
                        $aksi .= '<a href="'.url('dokumen/manage/detail').'/'.$data['id'].'"><button class="button button--sm w-24 mr-1 mb-2 bg-theme-1 text-white">Detail</button></a>';
                    }else{
                        if(in_array($data['id'], $this->getWaitAcc())){
                            $aksi = 'Permintaan Akses sudah dikirim';
                        }else{
                            $aksi = '<button class="button button--sm w-24 mr-1 mb-2 bg-theme-12 text-white" onclick="mintaAkses('.$data['id'].')">Minta Akses</button>';
                        }
                    }
                }else{
                    if ($data['ispublic'] == 1 || in_array($data['uploaded_by'], [Auth::user()->iduser]) || in_array($data['id'], $this->getAksesDokumen())) {
                        $aksi = '<a href="'.asset('upload/dokumen').'/'.$data['file'].'" target="_blank"><button class="button button--sm w-24 mr-1 mb-2 bg-theme-9 text-white">Download</button></a>';
                        $aksi .= '<a href="'.url('dokumen/manage/detail').'/'.$data['id'].'"><button class="button button--sm w-24 mr-1 mb-2 bg-theme-1 text-white">Detail</button></a>';
                    }else{
                        if(in_array($data['id'], $this->getWaitAcc())){
                            $aksi = 'Permintaan Akses sudah dikirim';
                        }else{
                            $aksi = '<button class="button button--sm w-24 mr-1 mb-2 bg-theme-12 text-white" onclick="mintaAkses('.$data['id'].')">Minta Akses</button>';
                        }
                    }
                }

                if (Auth::user()->iduser == $data['uploaded_by']) {
                    // $aksi .= '<a href="'.url('dokumen/manage/detail').'/'.$data['id'].'"><button class="button button--sm w-24 mr-1 mb-2 bg-theme-1 text-white">Detail</button></a>';
                    $aksi .= '<button class="button button--sm w-24 mr-1 mb-2 bg-theme-6 text-white" onclick="hapusDokumen('.$data['id'].')">Hapus</button>';
                }
                return $aksi;
            })
            ->rawColumns(['akses', 'validasi', 'aksi'])
            ->make(true);
    }

    public function getDetail($id){
        $data = Dokumen::where('id', $id)->first();
        if(!empty($data)){
            return response()->json([
                'status'=>200,
                'data'=>$data
            ]);
        }else{
            return response()->json([
                'status'=>500,
                'msg'=>'Dokumen tidak ditemukan'
            ]);
        }
    }

    public function detail($id){
        $data['dok'] = $dok = Dokumen::where('id', $id)->first();
        if(!empty($dok)){
            $data['dok']['created_at'] = Carbon::parse($data['dok']['created_at'])->locale('id')->translatedFormat('d F Y @ H:i:m');
            return view('back.dokumen.detail-dok', $data);
        }else{
            return back()->with('error','Dokumen tidak ditemukan');
        }
    }

    public function ubahPublic(Request $request, $id){
        $input = $request->all();
        if(!empty($input['public']) || $input['public'] == 0){
            DB::beginTransaction();
            try {
                DB::table('dokumen')->where('id', $id)->update([
                    'ispublic'=>$input['public']
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
                    'msg'=>'Berhasil mengubah akses file'
                ]);
            }else{
                return response()->json([
                    'status'=>500,
                    'msg'=>'Gagal mengubah akses file'
                ]);
            }
        }else{
            return response()->json([
                'status'=>500,
                'msg'=>'Status Publik harus diisi'
            ]);
        }
    }

    public function create(){
        $data['mode'] = 'tambah';
        $data['kategoris'] = DokumenKategori::all();
        return view('back.dokumen.create-dok', $data);
    }

    public function lastIdDokumen(){
        $last = Dokumen::max('id');
        return !empty($last)? $last + 1 : 1;
    }

    public function store(Request $request){
        $input = $request->all();

        $valid = Validator::make($input, [
            'nama'=>'required',
            'file'=>'required|mimes:pdf,docx,doc,xlc,xlcx,txt|max:10240',
            'akses'=>'required|numeric',
            'deskripsi'=>'max:1000',
            'tahun'=>'',
            'kategori'=>'required',
        ],[
            'required'=>':attribute harus diisi',
            'file.max'=>'Ukuran file maksimal :max',
            'numeri'=>':attribute harus berupa angka',
            'max'=>':attribute maksimal :max karakter',
            'file.mimes'=>'Ekstensi :attribute harus pdf,docx,doc,xlc,xlcx,txt'
        ], [
            'nama'=>'Nama Dokumen',
            'file'=>'File Dokumen',
            'akses'=>'Hak Akses',
            'deskripsi'=>'Dekripsi',
            'tahun'=>'Tahun',
            'kategori'=>'Kategori Dokumen',
        ]);

        if(!$valid->fails()){
            $data_dokumen = [
                'id'=>$this->lastIdDokumen(),
                'nama'=>$input['nama'],
                'deskripsi'=>$input['deskripsi'],
                'idkategori'=>$input['kategori'],
                'tahun'=>$input['tahun'],
                'ispublic'=>$input['akses'],
                'created_at'=>Carbon::now('Asia/Jakarta')->toDateTimeString(),
                'uploaded_by'=>Auth::user()->iduser,
            ];

            if ($request->has('file')) {
                $filename = strtolower(preg_replace('/\s+/', '', $input['nama']).'-'.time().'.'.$request->file->extension());
                $request->file->move(public_path('upload/dokumen'), $filename);
                $data_dokumen['file'] = preg_replace('/\s+/', '', $filename);
            }

            DB::beginTransaction();
            try {
                DB::table('dokumen')->insert($data_dokumen);
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
                    'msg'=>'Berhasil menyimpan Dokumen',
                ]);
            }else{
                return response()->json([
                    'status'=>500,
                    'msg'=>'Gagal menyimpan Dokumen',
                ]);
            }

        }else{
            return response()->json([
                'status'=>500,
                'msg'=>$valid->errors()->first()
            ]);
        }
    }

    public function edit($id){
        $data['mode'] = 'edit';
        $data['kategoris'] = DokumenKategori::all();
        $data['dok'] = Dokumen::where('id', $id)->first();
        return view('back.dokumen.create-dok', $data);
    }

    public function update(Request $request, $id){
        $input = $request->all();

        $valid = Validator::make($input, [
            'nama'=>'required',
            'file'=>'mimes:pdf,docx,doc,xlc,xlcx,txt|max:10240',
            'akses'=>'required|numeric',
            'deskripsi'=>'max:1000',
            'tahun'=>'',
            'kategori'=>'required',
        ],[
            'required'=>':attribute harus diisi',
            'file.max'=>'Ukuran file maksimal :max',
            'numeri'=>':attribute harus berupa angka',
            'max'=>':attribute maksimal :max karakter',
            'file.mimes'=>'Ekstensi :attribute harus pdf,docx,doc,xlc,xlcx,txt'
        ], [
            'nama'=>'Nama Dokumen',
            'file'=>'File Dokumen',
            'akses'=>'Hak Akses',
            'deskripsi'=>'Dekripsi',
            'tahun'=>'Tahun',
            'kategori'=>'Kategori Dokumen',
        ]);

        if(!$valid->fails()){
            $data_dokumen = [
                'nama'=>$input['nama'],
                'deskripsi'=>$input['deskripsi'],
                'idkategori'=>$input['kategori'],
                'tahun'=>$input['tahun'],
                'ispublic'=>$input['akses'],
            ];

            if ($request->has('file')) {
                $filename = strtolower(preg_replace('/\s+/', '', $input['nama']).'-'.time().'.'.$request->file->extension());
                $request->file->move(public_path('upload/dokumen'), $filename);
                $data_dokumen['file'] = preg_replace('/\s+/', '', $filename);
            }

            DB::beginTransaction();
            try {
                DB::table('dokumen')->where('id', $id)->update($data_dokumen);
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
                    'msg'=>'Berhasil mengupdate Dokumen',
                ]);
            }else{
                return response()->json([
                    'status'=>500,
                    'msg'=>'Gagal mengupdate Dokumen',
                ]);
            }

        }else{
            return response()->json([
                'status'=>500,
                'msg'=>$valid->errors()->first()
            ]);
        }
    }

    public function delete($id){
        $data = Dokumen::where('id', $id)->first();
        if(!empty($data)){
            DB::beginTransaction();
            try {
                DB::table('dokumen')->where('id', $id)->update([
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
                    'msg'=>'Berhasil menghapus dokumen'
                ]);
            }else{
                return response()->json([
                    'status'=>500,
                    'msg'=>'Gagal menghapus dokumen'
                ]);
            }
        }else{
            return repsonse()->json([
                'status'=>500,
                'msg'=>'Kategori tidak ditemukan'
            ]);
        }
    }
}
