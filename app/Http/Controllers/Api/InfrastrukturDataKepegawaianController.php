<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Refactored\Desa\DesaKepegawaian;
use App\Models\Refactored\Kecamatan\KecamatanKepegawaian;
use Illuminate\Support\Facades\DB;

class InfrastrukturDataKepegawaianController extends Controller
{
    public function datatableKecamatan($id)
    {
        DB::statement(DB::raw('set @rownum=0'));
        $prov = KecamatanKepegawaian::select([
            DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'id',
            'jenis_asn',
            'operasional',
            'jumlah',
            'kelembagaan',
        ])->where('id', $id)->get();

        return \Yajra\DataTables\Facades\DataTables::of($prov)
            ->editColumn('jenis_asn', function(KecamatanKepegawaian $data){
                if($data['jenis_asn'] == 1){
                    return '<span class="badge badge-success p-2 mx-1">ASN</span>';
                }else if($data['jenis_asn'] == 2){
                    return '<span class="badge badge-warning p-2 mx-1">NON ASN</span>';
                }
            })
            ->addColumn('staf', function(KecamatanKepegawaian $data){
                return $data->staff_op->keterangan;
            })
            ->editColumn('lemb', function(KecamatanKepegawaian $data){
                return $data->lembaga->keterangan??'Tidak terikat lembaga';
            })
            ->editColumn('jumlah', function(KecamatanKepegawaian $data){
                return number_format($data['jumlah'], 0,',','.').' Orang';
            })
            ->rawColumns(['jenis_asn'])
            ->make(true);
    }

    public function datatableKelurahan($id)
    {
        DB::statement(DB::raw('set @rownum=0'));
        $prov = DesaKepegawaian::select([
            DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'id',
            'jenis_asn',
            'operasional',
            'jumlah',
            'kelembagaan',
        ])->where('id', $id)->get();

        return \Yajra\DataTables\Facades\DataTables::of($prov)
            ->editColumn('jenis_asn', function(DesaKepegawaian $data){
                if($data['jenis_asn'] == 1){
                    return '<span class="badge badge-success p-2 mx-1">ASN</span>';
                }else if($data['jenis_asn'] == 2){
                    return '<span class="badge badge-warning p-2 mx-1">NON ASN</span>';
                }
            })
            ->addColumn('staf', function(DesaKepegawaian $data){
                return $data->staff_op->keterangan;
            })
            ->editColumn('lemb', function(DesaKepegawaian $data){
                return $data->lembaga->keterangan??'Tidak terikat lembaga';
            })
            ->editColumn('jumlah', function(DesaKepegawaian $data){
                return number_format($data['jumlah'], 0,',','.').' Orang';
            })
            ->rawColumns(['jenis_asn'])
            ->make(true);
    }
}
