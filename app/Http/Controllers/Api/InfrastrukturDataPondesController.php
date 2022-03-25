<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Refactored\Desa\DesaPondes;
use Illuminate\Support\Facades\DB;

class InfrastrukturDataPondesController extends Controller
{
    public function datatableKelurahan($id)
    {
        DB::statement(DB::raw('set @rownum=0'));
        $prov = DesaPondes::select([
            DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'id',
            'jenis_pondes',
            'jumlah',
        ])->where('id', $id);

        if(!empty(request()->q)){
            $nama = request()->q;
            $prov = $prov->whereHas('pondes', function($q) use($nama){
                $q->where('keterangan', 'like', '%'.$nama.'%');
            });
        }

        $prov = $prov->get();

        return \Yajra\DataTables\Facades\DataTables::of($prov)
            ->addColumn('nama', function(DesaPondes $data){
                return $data->jenis->keterangan;
            })
            ->editColumn('jumlah', function(DesaPondes $data){
                return number_format($data->jumlah, 0, ',', '.');
            })
            ->make(true);
    }
}
