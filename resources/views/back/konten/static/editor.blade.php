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
    <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="{{route('dok.manage.index')}}">Static Konten</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="" class="breadcrumb--active">{{ucwords($title)}}</a>
</div>
@endsection
@section('content')
<div class="intro-y flex items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">
        Atur {{ucwords($title)}}
    </h2>
</div>
<form id="form-editor">
    @csrf
    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12 lg:col-span-12 xxl:col-span-12">
            <div class="intro-y box mt-5 w-full">
                <div class="flex items-center px-5 py-3 border-b border-gray-200 dark:border-dark-5">
                    <h2 class="font-medium text-base mr-auto">
                        Isi Konten
                    </h2>
                    <div class="text-right mt-5">
                        <button type="button" class="button w-24 bg-theme-1 text-white" onclick="submitKonten()">Simpan</button>
                    </div>
                </div>
                <div class="p-5">
                    <div class="grid grid-cols-12 gap-6">
                        <div class="col-span-12">
                            <textarea id="summernote" name="konten">{{@$konten[$field]}}</textarea>
                        </div>
                    </div>
                </div>
            </div>
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
                    url:'{{url('konten/static/store')}}/{{$target}}',
                    method:'post',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success:res=>{
                        if (res.status == 200) {
                            showSuccess(res.msg, ()=>{
                                window.location.replace('{{route('konten.static.index')}}');
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
