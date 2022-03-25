<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Refactored\Konten\StaticContent;

class ProfilMaksudTujuanController extends Controller
{
    public function index(){
        $data['static_content'] = StaticContent::first();
        return view('front.profil-maksud-tujuan.index', $data);
    }
}
