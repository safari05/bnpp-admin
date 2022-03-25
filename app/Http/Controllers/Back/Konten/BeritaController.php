<?php

namespace App\Http\Controllers\Back\Konten;

use App\Http\Controllers\Controller;
use App\Models\Refactored\Konten\Content;
use App\Models\Refactored\Konten\ContentCategory;
use Carbon\Carbon;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class BeritaController extends Controller
{
    public function index(){
        $data['kategoris'] = ContentCategory::all();
        return view('back.konten.berita-list', $data);
    }

    public function list(){
        DB::statement(DB::raw('set @rownum=0'));
        $dokumen = Content::select([
            DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'idcontent',
            'judul',
            'created_at',
            'status',
            'idkategori',
            'idauthor'
        ]);

        if(!empty(request()->q)){
            $nama = request()->q;
            $dokumen = $dokumen->where('judul', 'like', '%'.$nama.'%');
        }

        if(!empty(request()->kat)){
            $idkat = request()->kat;
            $dokumen = $dokumen->where('idkategori', $idkat);
        }

        if(!empty(request()->status) || request()->status == 0){
            $status = request()->status;
            if ($status >= 0) {
                $dokumen = $dokumen->where('status', $status);
            }
        }

        $dokumen = $dokumen->get();

        return \Yajra\DataTables\Facades\DataTables::of($dokumen)
            ->editColumn('created_at', function(Content $data){
                return Carbon::parse($data['created_at'])->locale('id')->translatedFormat('d M Y @ H:i:s');
            })
            ->editColumn('status', function(Content $data){
                return ($data->status == 1)? 'Sudah Publis':'Draft';
            })
            ->addColumn('penulis', function(Content $data){
                return $data->author->username;
            })
            ->addColumn('kategori', function(Content $data){
                return $data->kategori->nama;
            })
            ->addColumn('aksi', function(Content $data){
                return '<a href="'.url('konten/berita/edit').'/'.$data['idcontent'].'"><button class="button button--sm w-24 mr-1 mb-2 bg-theme-1 text-white">Edit</button></a>
                        <a href="'.url('konten/berita/preview').'/'.$data['idcontent'].'" target="_blank"><button class="button button--sm w-24 mr-1 mb-2 bg-theme-9 text-white">Previews</button></a>
                        <button class="button button--sm w-24 mr-1 mb-2 bg-theme-6 text-white" onclick="hapusKonten('.$data['idcontent'].')">Hapus</button>';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    private function getLastContent(){
        $last = Content::max('idcontent');
        return !empty($last)? $last + 1: 1;
    }

    private function slugify($text){
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        $text = preg_replace('~[^-\w]+~', '', $text);
        $text = trim($text, '-');
        $text = preg_replace('~-+~', '-', $text);
        $text = strtolower($text);
        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }

    public function create(){
        $data['mode'] = 'tambah';
        $data['kategoris'] = ContentCategory::all();
        return view('back.konten.editor', $data);
    }

    public function store(Request $request){
        $input = $request->all();

        $valid = Validator::make($input, [
            'konten' => 'required',
            'judul' => 'required',
            'poster' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'kategori'=>'required',
            'status'=>'required',
        ]);

        if (!$valid->fails()) {
            $idkonten = $this->getLastContent();
            $slug = $this->slugify($input['judul']).time();
            $dom_content = $this->storeContentImage($slug, $input['konten']);

            $data_konten = [
                'idcontent'=>$idkonten,
                'idauthor'=>Auth::user()->iduser,
                'judul'=>$input['judul'],
                'content'=>$dom_content->saveHTML(),
                'created_at'=>Carbon::now('Asia/Jakarta')->toDateTimeString(),
                'updated_at'=>Carbon::now('Asia/Jakarta')->toDateTimeString(),
                'slug'=>$slug,
                'status'=>$input['status'],
                'idkategori'=>$input['kategori']
            ];

            if ($request->has('poster')) {
                $filename = strtolower('poster-'.time().'.'.$request->poster->extension());
                $request->poster->move(public_path('upload/content/'.$slug), $filename);
                $data_konten['poster'] = preg_replace('/\s+/', '', $filename);
            }

            #insert target content
            DB::beginTransaction();
            try {
                DB::table('content')->insert($data_konten);
                DB::commit();
                $oke = true;
            } catch (\Exception $e) {
                DB::rollback();
                $oke = false;
                $message = $e->getMessage();
            }

            if($oke){
                return response()->json([
                    'status'=>200,
                    'msg'=>'Berhasil menyimpan Konten'
                ]);
            }else{
                return response()->json([
                    'status'=>500,
                    'msg'=>'Gagal menyimpan Konten'
                ]);
            }
        }else{
            return response()->json([
                'status'=>500,
                'msg'=>$valid->errors()->first()
            ]);
        }
    }

    private function storeContentImage($slug, $content){
        $dom = new \DomDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML(
            mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8'),
            LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD
        );
        $images = $dom->getElementsByTagName('img');

        foreach($images as $k => $img){
            $data = $img->getAttribute('src');

            if (preg_match('/data:image/', $data)) {
                preg_match('/data:image\/(?<mime>.*?)\;/', $data, $groups);
                $mimeType = $groups['mime'];

                $path = "upload/content/".$slug.'/inner';
                $image_name= time().$k.'.'.$mimeType;
                if(!file_exists(public_path($path))){
                    mkdir($path, 0777, true);
                }

                Image::make($data)
                    ->resize(750, null, function ($constraint) {
                        $constraint->aspectRatio();
                })
                ->encode($mimeType, 80)
                ->save(public_path($path).'/'.$image_name);

                $new_src = asset($path.'/'.$image_name);
                $img->removeAttribute('src');
                $img->setAttribute('src', $new_src);
            }
        }

        return $dom;
    }

    public function previewKonten($id){
        $data['kategori'] = ContentCategory::all();
        $data['berita'] = Content::where('idcontent', $id)->first();
        if(empty($data['berita'])){
            abort(404);
        }

        return view('back.konten.preview', $data);
    }

    public function edit($id){
        $data['konten'] = Content::where('idcontent', $id)->first();
        if(!empty($data['konten'])){
            $data['kategoris'] = ContentCategory::all();
            $data['mode'] = 'edit';
            return view('back.konten.editor', $data);
        }else{
            return back()->with('error', 'Konten tidak ditemukan');
        }
    }

    public function update(Request $request, $id){
        $input = $request->all();

        $valid = Validator::make($input, [
            'konten' => 'required',
            'judul' => 'required',
            'poster' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'kategori'=>'required',
            'status'=>'required',
        ]);

        if (!$valid->fails()) {
            $current_content = Content::where('idcontent', $id)->first();
            $old_path = public_path('upload/content').'/'.$current_content->slug.'/inner';

            // if (File::exists($old_path)) {
            //     File::deleteDirectory($old_path);
            // }

            $dom_content = $this->storeContentImage($current_content->slug, $input['konten']);

            $data_konten = [
                'judul'=>$input['judul'],
                'content'=>$dom_content->saveHTML(),
                'updated_at'=>Carbon::now('Asia/Jakarta')->toDateTimeString(),
                'status'=>$input['status'],
                'idkategori'=>$input['kategori']
            ];

            if ($request->has('poster')) {
                $filename = strtolower('poster-'.time().'.'.$request->poster->extension());
                if(File::exists(public_path('upload/content/'.$current_content->slug.'/'.$current_content->poster))){
                    File::delete(public_path('upload/content/'.$current_content->slug.'/'.$current_content->poster));
                }
                $request->poster->move(public_path('upload/content/'.$current_content->slug), $filename);
                $data_konten['poster'] = preg_replace('/\s+/', '', $filename);
            }

            #insert target content
            DB::beginTransaction();
            try {
                DB::table('content')->where('idcontent', $id)->update($data_konten);
                DB::commit();
                $oke = true;
            } catch (\Exception $e) {
                DB::rollback();
                $oke = false;
            }

            if($oke){
                return response()->json([
                    'status'=>200,
                    'msg'=>'Berhasil memperbarui Konten'
                ]);
            }else{
                return response()->json([
                    'status'=>500,
                    'msg'=>'Gagal memperbarui Konten'
                ]);
            }
        }else{
            return response()->json([
                'status'=>500,
                'msg'=>$valid->errors()->first()
            ]);
        }
    }

    public function delete($id){
        $data = Content::where('idcontent', $id)->first();
        if(!empty($data)){
            DB::beginTransaction();
            try {
                DB::table('content')->where('idcontent', $id)->update([
                    'deleted_at'=>Carbon::now('Asia/Jakarta')->toDateTimeString(),
                ]);
                DB::commit();
                $oke = true;
            } catch (\Exception $th) {
                DB::rollback();
                $oke = false;
            }

            if($oke){
                return response()->json([
                    'status'=>200,
                    'msg'=>'Berhasil menghapus konten'
                ]);
            }else{
                return response()->json([
                    'status'=>500,
                    'msg'=>'Gagal menghapus konten'
                ]);
            }
        }else{
            return response()->json([
                'status'=>500,
                'msg'=>'Kategori tidak konten'
            ]);
        }
    }

}
