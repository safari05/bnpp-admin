<?php

namespace App\Http\Controllers\Back\Monev;

use App\Http\Controllers\Controller;
use App\Models\Refactored\Monev\DataMonevs;
use App\Models\Refactored\Monev\DetailMonevs;
use App\Models\Refactored\Monev\DetailPertanyaanMonevs;
use App\Models\Refactored\Monev\Indikators;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DetailMonevController extends Controller
{
    public function index($id){
        $data['monev'] = DataMonevs::where('id', $id)->first();
        if(!empty($data['monev'])){
            $data['monev']['tahun'] = Carbon::parse($data['monev']->created_at)->format('Y');
            $data['detail'] = DetailMonevs::where('monev_id', $id)->orderBy('variabel_id', 'ASC')->get();
            $data['indikator'] = Indikators::all();
            $data['tanya'] = [];
            
            $data['tanya'] = Indikators::get()->pluck('id')->toArray();
            foreach ($data['tanya'] as $key => $value) {
                $data['tanya'][$key] = [];
            }
            $temp = [];
            foreach($data['detail'] as $key => $item){
                $temp = DetailPertanyaanMonevs::where('detail_monev_id', $item->id)->get();
                foreach($temp as $kay => $value){
                    array_push($data['tanya'][$value->pertanyaan->indikator_id - 1], $value);
                }
            }
            
            return view('back.monev.detailmonev-list', $data);
        }else{
            return back()->with('error', 'Data Monev tidak ditemukan');
        }
    }
}
