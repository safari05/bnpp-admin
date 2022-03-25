<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Refactored\Dokumen\Dokumen;

class DownloadDokumenController extends Controller
{
    public function index(){
        $data['dokumen'] = new Dokumen();
        $data['fileExt'] = [
            'pdf' => 'pdf',
            'xls' => 'excel',
            'xlsx' => 'excel',
            'doc' => 'word',
            'docx' => 'word',
            'ppt' => 'powerpoint',
            'pptx' => 'powerpoint',
            'jpg' => 'image',
            'jpeg' => 'image',
            'png' => 'image',
            'mp4' => 'video'
        ];

        if(@request()->cari){
            $key = request()->cari;
            $data['dokumen'] = $data['dokumen']->whereHas('kategori', function($q) use($key){
                $q->where('keterangan', 'like', '%'.$key.'%');
            })->orWhere('nama', 'like', '%'.$key.'%');
        }

        $data['dokumen'] = $data['dokumen']->where('ispublic', 1)->orderBy('id', 'desc')->paginate(10);

        return view('front.download-dokumen.index',$data);
    }

    public function create(){
        return view('front.download-dokumen.form');
    }
}
