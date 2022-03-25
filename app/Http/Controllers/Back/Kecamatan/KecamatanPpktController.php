<?php

namespace App\Http\Controllers\Back\Kecamatan;

use App\Http\Controllers\Controller;
use App\Models\Refactored\Kecamatan\KecamatanPpkt;
use App\Models\Refactored\Utils\UtilsKecamatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class KecamatanPpktController extends Controller
{
    public function create($id){
        if (Auth::user()->idrole != 5 || @Auth::user()->kecamatan->idkecamatan == $id) {
            $kecamatan = UtilsKecamatan::where('id', $id)->first();
            $data['kec'] = $kecamatan;

            return view('back.kecamatan.wil.create-ppkt', $data);
        }else{
            return back()->with('error', 'Anda tidak memiliki akses ke halaman tersebut');
        }
    }

    private function getLastPPKT($id){
        $last = KecamatanPpkt::where('id', $id)->max('idppkt');
        return !empty($last)? $last+1:1;
    }

    public function store(Request $request){
        $input = $request->all();
        $valid = Validator::make($input, [
            'nama'=>'required',
            'jenis'=>'required',
            'id'=>'required'
        ], [
            'required'=>':attribute harus diisi'
        ], [
            'nama'=>'Nama Pulau',
            'jenis'=>'Jenis Pulau',
            'id'=>'Kecamatan'
        ]);

        if(!$valid->fails()){
            $data_ppkt = [
                'id'=>$input['id'],
                'idppkt'=>$this->getLastPPKT($input['id']),
                'nama'=>$input['nama'],
                'jenis'=>$input['jenis']
            ];

            DB::beginTransaction();
            try {
                DB::table('kecamatan_ppkt')->insert($data_ppkt);
                DB::commit();
                $oke = true;
            } catch (\Exception $e) {
                DB::rollback();
                $oke = false;
            }

            if($oke){
                return response()->json([
                    'status'=>200,
                    'msg'=>'Berhasil menambahkan PPKT'
                ]);
            }else{
                return response()->json([
                    'status'=>500,
                    'msg'=>'Gagal menambahkan PPKT'
                ]);
            }
        }else{
            return response()->json([
                'status'=>500,
                'msg'=>$valid->errors()->first()
            ]);
        }
    }

    public function listppkt($id){
        DB::statement(DB::raw('set @rownum=0'));
        $prov = KecamatanPpkt::select([
            DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'id',
            'idppkt',
            'nama',
            'jenis',
        ]);

        if(Auth::user()->idrole != 5) $prov = $prov->where('id', $id);
        else $prov = $prov->where('id', @Auth::user()->kecamatan->idkecamatan);

        if(!empty(request()->q)){
            $nama = request()->q;
            $prov = $prov->whereHas('aset', function($q) use($nama){
                $q->where('nama', 'like', $nama);
            });
        }

        $prov = $prov->get();

        return \Yajra\DataTables\Facades\DataTables::of($prov)
            ->editColumn('jenis', function(KecamatanPpkt $data){
                return $data['jenis'] == 1? 'Berpenghuni':'Tidak Berpenghuni';
            })
            ->addColumn('aksi', function(KecamatanPpkt $data){
                $aksi = '<button class="button button--sm w-24 mr-1 mb-2 bg-theme-6 text-white btn-delete-ppkt" data-id="'.$data['idppkt'].'">Hapus</button>';
                return $aksi;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function chartppkt($id){
        if (Auth::user()->idrole != 5 || @Auth::user()->kecamatan->idkecamatan == $id) {
            $query = "SELECT a.id, COALESCE(a.total, 0) AS berpenghuni, COALESCE(b.total, 0) AS tidak FROM (
                        SELECT id, COUNT(jenis) AS total, jenis FROM kecamatan_ppkt
                        WHERE jenis = 1
                    ) a
                    LEFT JOIN (
                        SELECT id, COUNT(jenis) AS total, jenis FROM kecamatan_ppkt
                        WHERE jenis = 2
                    ) b ON a.id = b.id
                    WHERE a.id = '$id'";

            $pulau = @DB::select($query)[0];

            $chart = [
                [
                    'label'=>'Berpenghuni',
                    'data'=>''.@$pulau->berpenghuni??0,
                    'backgroundColor'=>'rgba(143, 247, 45, 0.4)',
                    'borderColor'=>'rgba(143, 247, 45, 1)',
                    'borderWidth'=>'1'
                ],
                [
                    'label'=> 'Tidak Berpenguni',
                    'data'=>''.@$pulau->tidak??0,
                    'backgroundColor'=>'rgba(252, 198, 3, 0.4)',
                    'borderColor'=>'rgba(252, 198, 3, 1)',
                    'borderWidth'=>'1'
                ]
            ];

            $data['data'] = $chart;

            return response()->json($data);
        }
    }

    public function delete($id, $idppkt){
        if (Auth::user()->idrole != 5 || @Auth::user()->kecamatan->idkecamatan == $id) {
            $ppkt = KecamatanPpkt::where('id', $id)->where('idppkt', $idppkt)->first();
            if (!empty($ppkt)) {
                DB::beginTransaction();
                try {
                    DB::table('kecamatan_ppkt')->where('id', $id)->where('idppkt', $idppkt)->delete();
                    DB::commit();
                    $oke = true;
                } catch (\Exception $th) {
                    DB::rollback();
                    $oke = false;
                }

                if ($oke) {
                    return response()->json([
                        'status'=>200,
                        'msg'=>'Berhasil menghapus PPKT'
                    ]);
                } else {
                    return response()->json([
                        'status'=>500,
                        'msg'=>'Gagal menghapus PPKT'
                    ]);
                }
            } else {
                return response()->json([
                    'status'=>500,
                    'msg'=>'PPKT tidak ditemukan'
                ]);
            }
        }else{
            return response()->json([
                'status'=>500,
                'msg'=>'Anda tidak memiliki akses untuk aksi tersebut'
            ]);
        }
    }
}
