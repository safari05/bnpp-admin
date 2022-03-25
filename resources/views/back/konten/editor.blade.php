@extends('back.layout.main')
@push('css')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<style>
    .note-modal-backdrop{
        display: none !important;
    }
</style>
@endpush

@section('bread')
<div class="-intro-x breadcrumb mr-auto hidden sm:flex">
    <a href="" class="">Application</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="{{route('dok.manage.index')}}">Konten</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="" class="breadcrumb--active">{{ucwords($mode)}}</a>
</div>
@endsection
@section('content')
<div class="intro-y flex items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">
        {{ucwords($mode)}} Konten
    </h2>
</div>
<form id="form-editor">
@csrf
@if($mode == 'edit') @method('put') @endif
    <div class="grid grid-cols-12 gap-6">
        <!-- END: Profile Menu -->
        <div class="col-span-8 lg:col-span-8 xxl:col-span-8">
            <!-- BEGIN: Daftar Kepegawaian -->
            <div class="intro-y box mt-5">
                <div class="flex items-center px-5 py-3 border-b border-gray-200 dark:border-dark-5">
                    <h2 class="font-medium text-base mr-auto">
                        Isi Konten
                    </h2>
                </div>
                <div class="p-5">
                    <div class="grid grid-cols-12 gap-6">
                        <div class="col-span-12">
                            <textarea id="summernote" name="konten">{{@$konten->content}}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END: General Statistics -->
        </div>
        <div class="col-span-4 lg:col-span-4 xxl:col-span-4">
            <!-- BEGIN: Daftar Kepegawaian -->
            <div class="intro-y box mt-5">
                <div class="flex items-center px-5 py-3 border-b border-gray-200 dark:border-dark-5">
                    <h2 class="font-medium text-base mr-auto">
                        Informasi Konten
                    </h2>
                </div>
                <div class="p-5">
                    <div class="grid grid-cols-12 gap-6">
                        <div class="col-span-12">
                            <label for="">Judul <span class="text-theme-6">*</span></label>
                            <input type="text" class="input w-full border" placeholder="Judul Konten" name="judul" id="judul" value="{{@$konten->judul}}">
                        </div>
                        <div class="col-span-12">
                            <label for="">Poster @if($mode == 'tambah')<span class="text-theme-6">*</span> @endif</label>
                            <input type="file" class="input w-full border" placeholder="Poster Konten" name="poster" id="poster">
                        </div>
                        <div class="col-span-12 mt-2">
                            <label for="">Kategori Konten <span class="text-theme-6">*</span></label>
                            <select data-search="true" class="tail-select w-full" id="kategori" placeholder="Kategori Konten" name="kategori" required>
                                @foreach ($kategoris as $item)
                                <option value="{{$item->idcategory}}" {{($mode=='edit')? ((@$konten->idkategori == $item->idcategory)? 'selected':''):''}}>{{$item->nama}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-span-12 mt-2">
                            <label for="">Publikasi <span class="text-theme-6">*</span></label>
                            <select data-search="true" class="tail-select w-full" id="status" placeholder="Status Publikasi" name="status" required>
                                <option value="0" {{($mode=='edit')? ((@$konten->status == 0)? 'selected':''):''}}>Draft</option>
                                <option value="1" {{($mode=='edit')? ((@$konten->status == 1)? 'selected':''):''}}>Publikasi</option>
                            </select>
                        </div>
                        <div class="col-span-12">
                            <div class="text-right mt-5">
                                @if($mode == 'tambah')
                                <button type="button" class="button w-24 bg-theme-1 text-white" onclick="submitKonten()">Simpan</button>
                                @else
                                <button type="button" class="button w-24 bg-theme-1 text-white" onclick="updateKonten()">Update</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END: General Statistics -->
        </div>
    </div>
</form>
@endsection
@push('js')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script>
    var table;
    $(document).ready(function(){
        initSummernote();
    })

    function initSummernote(){
        $('#summernote').summernote({
            placeholder: 'Silakan buat konten Anda disini',
            tabsize: 2,
            height: 120,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['codeview', 'help']]
            ],
            height: 650,                 // set editor height
            minHeight: null,             // set minimum height of editor
            maxHeight: null,             // set maximum height of editor
            focus: true,
            callbacks: {
                onPaste: function (e) {
                    var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
                    if(bufferText.match(/(http|https)\:\/\/(?:www\.|\/\/)instagram\.com\/p\/(.[a-zA-Z0-9_-]*)/)) {
                        urls = bufferText.match(/(http|https)\:\/\/(?:www\.|\/\/)instagram\.com\/p\/(.[a-zA-Z0-9_-]*)/g);
                            urls.forEach(function(element) {
                            $.ajax({
                                url: "https://api.instagram.com/oembed/?url=" + element,
                                success: function( data ) {
                                document.execCommand('insertHtml', null, data.html + "<br>");
                                },
                                async: false
                            });
                        })
                    }
                }
            }
        });
    }

    function submitKonten(){
        // Swal.fire({
        //     title: 'Yakin data sudah benar?',
        //     text: 'Anda akan menginput Dokumen dengan data tersebut. Lanjutkan?',
        //     showCancelButton: true,
        //     confirmButtonText: 'Lanjutkan',
        //     cancelButtonText: 'Tutup',
        // }).then((result) => {
        //     /* Read more about isConfirmed, isDenied below */
        //     if (result.isConfirmed) {
                let formData = new FormData($('#form-editor')[0]);
                $.ajax({
                    url:'{{route('konten.berita.store')}}',
                    method:'post',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success:res=>{
                        if (res.status == 200) {
                            showSuccess(res.msg, ()=>{
                                window.location.replace('{{route('konten.berita.index')}}');
                            });
                        } else {
                            showError(res.msg);
                        }
                    }
                })
        //     }
        // })
    }

    function updateKonten(){
        // Swal.fire({
        //     title: 'Yakin data sudah benar?',
        //     text: 'Anda akan menginput Dokumen dengan data tersebut. Lanjutkan?',
        //     showCancelButton: true,
        //     confirmButtonText: 'Lanjutkan',
        //     cancelButtonText: 'Tutup',
        // }).then((result) => {
        //     /* Read more about isConfirmed, isDenied below */
        //     if (result.isConfirmed) {
                let formData = new FormData($('#form-editor')[0]);
                $.ajax({
                    url:'{{url('konten/berita/update')}}/{{@$konten->idcontent}}',
                    method:'post',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success:res=>{
                        if (res.status == 200) {
                            showSuccess(res.msg, ()=>{
                                window.location.replace('{{route('konten.berita.index')}}');
                            });
                        } else {
                            showError(res.msg);
                        }
                    }
                })
        //     }
        // })
    }
</script>
@endpush
