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
    <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="{{url('desa/aset')}}/{{$desa->id}}">Wilayah</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="" class="breadcrumb--active">Tambah PPKT</a>
</div>
@endsection

@section('content')
<div class="intro-y flex items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">
        Tambah PPKT Desa {{ucwords(strtolower($desa->name))}}
    </h2>
</div>
<div class="grid grid-cols-12 gap-6">
    <!-- END: Profile Menu -->
    <div class="col-span-12 lg:col-span-12 xxl:col-span-12">
        <!-- BEGIN: Daftar Mobilitas -->
        <div class="intro-y box mt-5">
            <div class="flex items-center px-5 py-3 border-b border-gray-200 dark:border-dark-5">
                <h2 class="font-medium text-base mr-auto">
                    Informasi Pulau Pulau Kecil Terluar
                </h2>
            </div>
            <div class="p-5">
                <form action="grid grid-cols-12 gap-6" id="form-input">
                    <input type="hidden" name="id" value="{{$desa->id}}">
                    @csrf
                    <div class="col-span-12">
                        <label for="">Nama Pulau</label>
                        <input type="text" class="input w-full border mt-2" placeholder="Nama Pulau" name="nama" id="nama">
                    </div>
                    <div class="col-span-12 mt-2">
                        <label for="">Jenis PPKT</label>
                        <select class="input w-full border mt-2" placeholder="Jenis PPKT" name="jenis" id="jenis">
                            <option value="1">Berpenduduk</option>
                            <option value="2">Tidak Berpenduduk</option>
                        </select>
                    </div>
                </form>
                <div class="grid grid-cols-12 gap-6">
                    <div class="col-span-12">
                        <div class="text-right mt-5">
                            <button type="button" class="button w-24 bg-theme-1 text-white" onclick="submitItem()">Simpan</button>
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
    })

    function submitItem(){
        Swal.fire({
            title: 'Yakin data sudah benar?',
            text: 'Anda akan menginput Data Pulau Pulau Kecil Terluar Desa. Lanjutkan?',
            showCancelButton: true,
            confirmButtonText: 'Lanjutkan',
            cancelButtonText: 'Tutup',
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                let formData = new FormData($('#form-input')[0]);
                $.ajax({
                    url:'{{route('desa.wil.ppkt.store')}}',
                    method:'post',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success:res=>{
                        if (res.status == 200) {
                            showSuccess(res.msg, ()=>{
                                window.location.replace('{{url('desa/wil')}}/{{$desa->id}}');
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
