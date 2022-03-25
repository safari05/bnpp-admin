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
    <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="{{route('kec.index')}}">Kecamatan</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="{{url('kec/aset')}}/{{$kec->id}}">Aset</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="" class="breadcrumb--active">{{ucwords($mode)}}</a>
</div>
@endsection

@section('content')
<div class="intro-y flex items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">
        {{ucwords($mode)}} Aset Kecamatan {{ucwords(strtolower($kec->name))}}
    </h2>
</div>
<div class="grid grid-cols-12 gap-6">
    <!-- END: Profile Menu -->
    <div class="col-span-12 lg:col-span-12 xxl:col-span-12">
        <!-- BEGIN: Daftar Aset -->
        <div class="intro-y box mt-5">
            <div class="flex items-center px-5 py-3 border-b border-gray-200 dark:border-dark-5">
                <h2 class="font-medium text-base mr-auto">
                    Informasi Aset
                </h2>
            </div>
            <div class="p-5">
                <div class="grid grid-cols-12 gap-6">
                    <div class="col-span-12">
                        <label for="">Nama Item</label>
                        <input type="text" class="input w-full border mt-2" placeholder="Nama Item" id="nama" value="{{@$aset->item->nama}}" {{$mode == 'edit'? 'readonly':''}}>
                        <small>Masukan 1 huruf inisial untuk mencari nama item</small>
                    </div>
                    <div class="col-span-12">
                        <label for="">Jumlah Item Baik</label>
                        <input type="number" class="input w-full border mt-2" placeholder="Jumlah Item Kondisi Baik" id="baik" value="{{@$aset->jumlah_baik}}">
                    </div>
                    <div class="col-span-12">
                        <label for="">Jumlah Item Rusak</label>
                        <input type="number" class="input w-full border mt-2" placeholder="Jumlah Item Kondisi Rusak" id="rusak" value="{{@$aset->jumlah_rusak}}">
                    </div>
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
        <!-- END: General Statistics -->
    </div>
</div>
@endsection
@push('js')
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    var table;
    $(document).ready(function(){
        $.getJSON('{{route('kec.aset.src-auto')}}', data=>{
            $( "#nama" ).autocomplete({
                source: data
            });
        })
    })

    function submitItem(){
        Swal.fire({
            title: 'Yakin data sudah benar?',
            text: 'Anda akan menginput Aset Kecamatan dengan data tersebut. Lanjutkan?',
            showCancelButton: true,
            confirmButtonText: 'Lanjutkan',
            cancelButtonText: 'Tutup',
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                const data = {
                    '_token':'{{csrf_token()}}',
                    'id':'{{$kec->id}}',
                    'nama':$('#nama').val(),
                    'baik':$('#baik').val(),
                    'rusak':$('#rusak').val(),
                };

                $.post('{{route('kec.aset.store')}}', data, res=>{
                    if (res.status == 200) {
                        showSuccess(res.msg, ()=>{
                            window.location.replace('{{url('kecamatan/aset')}}/{{$kec->id}}');
                        });
                    } else {
                        showError(res.msg);
                    }
                });
            }
        })
    }

    function updateItem(){
        Swal.fire({
            title: 'Yakin data sudah benar?',
            text: 'Anda akan mengubah Aset Kecamatan dengan data tersebut. Lanjutkan?',
            showCancelButton: true,
            confirmButtonText: 'Lanjutkan',
            cancelButtonText: 'Tutup',
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                const data = {
                    '_token':'{{csrf_token()}}',
                    '_method':'put',
                    'id':'{{$kec->id}}',
                    'iditem':'{{@$aset->iditem}}',
                    'baik':$('#baik').val(),
                    'rusak':$('#rusak').val(),
                };

                $.post('{{route('kec.aset.update')}}', data, res=>{
                    if (res.status == 200) {
                        showSuccess(res.msg, ()=>{
                            window.location.replace('{{url('kecamatan/aset')}}/{{$kec->id}}');
                        });
                    } else {
                        showError(res.msg);
                    }
                });
            }
        })
    }
</script>
@endpush
