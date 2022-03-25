<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Refactored\Kecamatan\KecamatanPpkt;
use Illuminate\Support\Facades\DB;

class InfrastrukturDataPPKTController extends Controller
{
    public function datatableKecamatan($id)
    {
        DB::statement(DB::raw('set @rownum=0'));
        $prov = KecamatanPpkt::select([
            DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'id',
            'idppkt',
            'nama',
            'jenis',
        ])->where('id', $id);

        if(!empty(request()->q)){
            $nama = request()->q;
            $prov = $prov->whereHas('aset', function($q) use($nama){
                $q->where('nama', 'like', '%'.$nama.'%');
            });
        }

        $prov = $prov->get();

        return \Yajra\DataTables\Facades\DataTables::of($prov)
            ->editColumn('jenis', function(KecamatanPpkt $data){
                return $data['jenis'] == 1? 'Berpenghuni':'Tidak Berpenghuni';
            })
            ->make(true);
    }
}
