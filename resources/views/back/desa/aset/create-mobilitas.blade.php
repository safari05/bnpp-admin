@extends('back.layout.main')

@push('css')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<style>
    .d-none{
        display: none;
    }
</style>
@endpush

@section('bread')
<div class="-intro-x breadcrumb mr-auto hidden sm:flex">
    <a href="" class="">Application</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="{{route('desa.index')}}">Desa</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="{{url('desa/aset')}}/{{$desa->id}}">Mobilitas</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="" class="breadcrumb--active">{{ucwords($mode)}}</a>
</div>
@endsection

@section('content')
<div class="intro-y flex items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">
        {{ucwords($mode)}} Mobilitas Desa {{ucwords(strtolower($desa->name))}}
    </h2>
</div>
<div class="grid grid-cols-12 gap-6">
    <!-- END: Profile Menu -->
    <div class="col-span-12 lg:col-span-12 xxl:col-span-12">
        <!-- BEGIN: Daftar Mobilitas -->
        <div class="intro-y box mt-5">
            <div class="flex items-center px-5 py-3 border-b border-gray-200 dark:border-dark-5">
                <h2 class="font-medium text-base mr-auto">
                    Informasi Mobilitas
                </h2>
            </div>
            <div class="p-5">
                    <form action="" enctype="multipart/form-data" id="form-mobil">
                        <div class="grid grid-cols-12 gap-6">
                        @csrf
                        <input type="hidden" name="id" id="id" value="{{$desa->id}}">
                        @if($mode == 'edit')
                            @method('put')
                            <input type="hidden" name="idmobilitas" id="idmobilitas" value="{{@$mobil->idmobilitas}}">
                        @endif
                        <div class="col-span-12">
                            <label for="">Nama Mobilitas</label>
                            <input type="text" class="input w-full border mt-2" placeholder="Nama Item" name="nama" id="nama" value="{{@$mobil->item->nama}}" {{$mode == 'edit'? 'readonly':''}}>
                            <small>Masukan 1 huruf inisial untuk mencari nama item</small>
                        </div>
                        <div class="col-span-12">
                            <label for="">Jumlah Item</label>
                            <input type="number" class="input w-full border mt-2" placeholder="Jumlah Item" name="jumlah"  id="jumlah" value="{{@$mobil->jumlah}}">
                        </div>
                        <div class="col-span-12">
                            <label for="">Foto Item</label>
                            <input type="file" class="input w-full border mt-2" placeholder="Foto Mobilitas" name="foto"  id="foto">
                        </div>
                        </div>
                    </form>
                    <div class="grid grid-cols-12 gap-6">
                        <div class="col-span-12">
                            <div class="text-right mt-5">
                                @if($mode == 'add')
                                <button type="button" class="button w-24 bg-theme-1 text-white" onclick="submitItem()">Simpan</button>
                                @else
                                <button type="button" class="button w-24 bg-theme-1 text-white" onclick="updateItem()">Update</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END: General Statistics -->
    </div>
</div>
@endsection
@push('js')
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    var table;
    $(document).ready(function(){
        $.getJSON('{{route('desa.mobilitas.src-auto')}}', data=>{
            $( "#nama" ).autocomplete({
                source: data
            });
        })
    })

    function submitItem(){
        Swal.fire({
            title: 'Yakin data sudah benar?',
            text: 'Anda akan menginput Mobilitas Desa dengan data tersebut. Lanjutkan?',
            showCancelButton: true,
            confirmButtonText: 'Lanjutkan',
            cancelButtonText: 'Tutup',
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                let formData = new FormData($('#form-mobil')[0]);
                $.ajax({
                    url:'{{route('desa.mobilitas.store')}}',
                    method:'post',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success:res=>{
                        if (res.status == 200) {
                            showSuccess(res.msg, ()=>{
                                window.location.replace('{{url('desa/aset')}}/{{$desa->id}}');
                            });
                        } else {
                            showError(res.msg);
                        }
                    }
                })
            }
        })
    }

    function updateItem(){
        Swal.fire({
            title: 'Yakin data sudah benar?',
            text: 'Anda akan mengubah Mobilitas Desa dengan data tersebut. Lanjutkan?',
            showCancelButton: true,
            confirmButtonText: 'Lanjutkan',
            cancelButtonText: 'Tutup',
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                let formData = new FormData($('#form-mobil')[0]);
                $.ajax({
                    url:'{{route('desa.mobilitas.update')}}',
                    method:'post',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success:res=>{
                        if (res.status == 200) {
                            showSuccess(res.msg, ()=>{
                                window.location.replace('{{url('desa/aset')}}/{{$desa->id}}');
                            });
                        } else {
                            showError(res.msg);
                        }
                    }
                })
            }
        })
    }
</script>
@endpush
