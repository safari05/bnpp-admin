<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Refactored\Desa\DesaPenduduk;
use App\Models\Refactored\Kecamatan\KecamatanPenduduk;
use Illuminate\Support\Facades\DB;

class InfrastrukturDataPendudukController extends Controller
{
    public function datatableKecamatan($id)
    {
        DB::statement(DB::raw('set @rownum=0'));
        $prov = KecamatanPenduduk::select([
            DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'id',
            'idjenis',
            'jumlah',
        ])->whereNotIn('idjenis', ['1','2'])
        ->where('id', $id)->get();

        return \Yajra\DataTables\Facades\DataTables::of($prov)
            ->editColumn('jumlah', function(KecamatanPenduduk $data){
                return number_format($data['jumlah'], 0, ',', '.').' Orang';
            })
            ->addColumn('ket', function(KecamatanPenduduk $data){
                return $data->jenis->nama;
            })
            ->make(true);
    }

    public function datatableKelurahan($id)
    {DB::statement(DB::raw('set @rownum=0'));
        $prov = DesaPenduduk::select([
            DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'id',
            'idjenis',
            'jumlah',
        ])->whereNotIn('idjenis', ['1','2'])
        ->where('id', $id)->get();

        return \Yajra\DataTables\Facades\DataTables::of($prov)
            ->editColumn('jumlah', function(DesaPenduduk $data){
                return number_format($data['jumlah'], 0, ',', '.').' Orang';
            })
            ->addColumn('ket', function(DesaPenduduk $data){
                return $data->jenis->nama;
            })
            ->make(true);
    }
}
