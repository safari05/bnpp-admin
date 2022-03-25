<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Refactored\Desa\DesaAset;
use App\Models\Refactored\Kecamatan\KecamatanAset;
use App\Models\Refactored\Utils\UtilsDesa;
use Illuminate\Support\Facades\DB;

class InfrastrukturDataAsetController extends Controller
{
    public function datatableKecamatan($id)
    {
        DB::statement(DB::raw('set @rownum=0'));
        $prov = KecamatanAset::select([
            DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'id',
            'iditem',
            'jumlah_baik',
            'jumlah_rusak',
        ])->where('id', $id);

        if (!empty(request()->q)) {
            $nama = request()->q;
            $prov = $prov->whereHas('aset', function ($q) use ($nama) {
                $q->where('nama', 'like', $nama);
            });
        }

        $prov = $prov->get();

        return \Yajra\DataTables\Facades\DataTables::of($prov)
            ->addColumn('nama', function (KecamatanAset $data) {
                return $data->item->nama;
            })
            ->editColumn('jumlah_baik', function (KecamatanAset $data) {
                return number_format($data->jumlah_baik, 0, ',', '.');
            })
            ->editColumn('jumlah_rusak', function (KecamatanAset $data) {
                return number_format($data->jumlah_rusak, 0, ',', '.');
            })
            ->make(true);
    }

    public function datatableKelurahan($id)
    {
        DB::statement(DB::raw('set @rownum=0'));
        $prov = DesaAset::select([
            DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'id',
            'iditem',
            'jumlah_baik',
            'jumlah_rusak',
        ])->where('id', $id);

        if (!empty(request()->q)) {
            $nama = request()->q;
            $prov = $prov->whereHas('aset', function ($q) use ($nama) {
                $q->where('nama', 'like', '%' . $nama . '%');
            });
        }

        $prov = $prov->get();

        return \Yajra\DataTables\Facades\DataTables::of($prov)
            ->addColumn('nama', function (DesaAset $data) {
                return $data->item->nama;
            })
            ->editColumn('jumlah_baik', function (DesaAset $data) {
                return number_format($data->jumlah_baik, 0, ',', '.');
            })
            ->editColumn('jumlah_rusak', function (DesaAset $data) {
                return number_format($data->jumlah_rusak, 0, ',', '.');
            })
            ->make(true);
    }
}
