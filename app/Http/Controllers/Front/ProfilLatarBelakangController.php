<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Refactored\Konten\StaticContent;

class ProfilLatarBelakangController extends Controller
{
    public function index(){
        $data['static_content'] = StaticContent::first();
        return view('front.profil-latar-belakang.index', $data);
    }
}
