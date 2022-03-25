<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Refactored\Kecamatan\KecamatanLokpri;
use App\Models\Refactored\Kecamatan\KecamatanType;
use App\Models\Refactored\Utils\UtilsProvinsi;

class InfrastrukturPetaController extends Controller
{
    public function index(){
        $data['provinces'] = UtilsProvinsi::where('active', 1)->get();
        $data['tipe'] = KecamatanType::all();
        $data['lokpri'] = KecamatanLokpri::all();

        return view('front.infrastruktur-peta.index', $data);
    }
}
