<?php

namespace App\Http\Controllers\Back\Konten;

use App\Http\Controllers\Controller;
use App\Models\Refactored\Konten\StaticContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManagerStatic as Image; 

class KontenController extends Controller
{
    public function index(){
        return view('back.konten.static.static-list');
    }

    public function editorLatarBelakang(){
        $data['title'] = 'Latar Belakang';
        $data['target'] = 'latar';
        $data['field'] = 'latar_belakang';
        $data['konten'] = StaticContent::where('id', 1)->first()->toArray();
        return view('back.konten.static.editor', $data);
    }

    public function storeLatarBelakang(Request $request){
        $input = $request->all();
        
        $valid = Validator::make($input, [
            'konten' => 'required',
        ]);

        if (!$valid->fails()) {
            $dom_content = $this->storeContentImage('lt', $input['konten']);

            #insert target content
            DB::beginTransaction();
            try {
                DB::table('static_content')->updateOrInsert([
                    'id'=>'1',
                ], [
                    'id'=>1,
                    'latar_belakang'=>$dom_content->saveHTML(),
                ]);
                DB::commit();
                $oke = true;
            } catch (\Exception $e) {
                DB::rollback();
                $oke = false;
                dd($e);
            }

            if($oke){
                return response()->json([
                    'status'=>200,
                    'msg'=>'Berhasil menyimpan Latar Belakang'
                ]);
            }else{
                return response()->json([
                    'status'=>500,
                    'msg'=>'Gagal menyimpan Latar Belakang'
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

                $path = "upload/static/".$slug;
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

    public function editorMaksud(){
        $data['title'] = 'Maksud';
        $data['target'] = 'maksud';
        $data['field'] = 'maksud';
        $data['konten'] = StaticContent::where('id', 1)->first()->toArray();
        return view('back.konten.static.editor', $data);
    }

    public function storeMaksud(Request $request){
        $input = $request->all();

        $valid = Validator::make($input, [
            'konten' => 'required',
        ]);

        if (!$valid->fails()) {
            $dom_content = $this->storeContentImage('md', $input['konten']);

            #insert target content
            DB::beginTransaction();
            try {
                DB::table('static_content')->updateOrInsert([
                    'id'=>'1',
                ], [
                    'id'=>1,
                    'maksud'=>$dom_content->saveHTML(),
                ]);
                DB::commit();
                $oke = true;
            } catch (\Exception $e) {
                DB::rollback();
                $oke = false;
                dd($e);
            }

            if($oke){
                return response()->json([
                    'status'=>200,
                    'msg'=>'Berhasil menyimpan Maksud'
                ]);
            }else{
                return response()->json([
                    'status'=>500,
                    'msg'=>'Gagal menyimpan Maksud'
                ]);
            }
        }else{
            return response()->json([
                'status'=>500,
                'msg'=>$valid->errors()->first()
            ]);
        }
    }


    public function editorTujuan(){
        $data['title'] = 'Tujuan';
        $data['target'] = 'tujuan';
        $data['field'] = 'tujuan';
        $data['konten'] = StaticContent::where('id', 1)->first()->toArray();
        return view('back.konten.static.editor', $data);
    }

    public function storeTujuan(Request $request){
        $input = $request->all();
        
        $valid = Validator::make($input, [
            'konten' => 'required',
        ]);

        if (!$valid->fails()) {
            $dom_content = $this->storeContentImage('tj', $input['konten']);

            #insert target content
            DB::beginTransaction();
            try {
                DB::table('static_content')->updateOrInsert([
                    'id'=>'1',
                ], [
                    'id'=>1,
                    'tujuan'=>$dom_content->saveHTML(),
                ]);
                DB::commit();
                $oke = true;
            } catch (\Exception $e) {
                DB::rollback();
                $oke = false;
                dd($e);
            }

            if($oke){
                return response()->json([
                    'status'=>200,
                    'msg'=>'Berhasil menyimpan Tujuan'
                ]);
            }else{
                return response()->json([
                    'status'=>500,
                    'msg'=>'Gagal menyimpan Tujuan'
                ]);
            }
        }else{
            return response()->json([
                'status'=>500,
                'msg'=>$valid->errors()->first()
            ]);
        }
    }
}
