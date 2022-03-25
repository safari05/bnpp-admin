<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Refactored\Konten\Content;
use App\Models\Refactored\Konten\ContentCategory;
use Illuminate\Http\Request;

class BeritaController extends Controller
{
    public function index(Request $request){
        $data['kategori'] = ContentCategory::all();
        $data['beritaTerbaru'] = Content::orderBy('idcontent', 'desc')->limit(5)->get();
        $data['berita'] = new Content();
        if(@$request->kategori){
            $data['berita'] = $data['berita']->where('idkategori', @$request->kategori);
        }
        if(@$request->cari){
            $data['berita'] = $data['berita']->where('content', 'like', '%'.$request->cari.'%')->orWhere('judul', 'like', '%'.$request->cari.'%');
        }

        $data['berita'] =  $data['berita']->paginate(10);

        return view('front.berita.index', $data);
    }

    public function show($slug){
        $data['kategori'] = ContentCategory::all();
        $data['beritaTerbaru'] = Content::orderBy('idcontent', 'desc')->limit(5)->get();
        $data['berita'] = Content::where('slug', $slug)->first();

        if(empty($data['berita'])){
            abort(404);
        }else{
            $data['beritaNext'] = Content::where('idcontent', '>', $data['berita']->idcontent)->first();
            $data['beritaPrevious'] = Content::where('idcontent', '<', $data['berita']->idcontent)->orderBy('idcontent', 'desc')->first();
        }
        $prev = Content::where('idcontent', '<', $data['berita']->idcontent)->where('status', '1')->orderBy('created_at', 'desc')->first();
        if(!empty($prev)){
            $data['prev'] = $prev->slug;
        }

        $next = Content::where('idcontent', '>', $data['berita']->idcontent)->where('status', '1')->orderBy('created_at', 'asc')->first();
        if(!empty($next)){
            $data['next'] = $next->slug;
        }

        return view('front.berita.show', $data);
    }
}
