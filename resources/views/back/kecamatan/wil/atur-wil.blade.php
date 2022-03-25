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
    <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="{{url('kec/aset')}}/{{$kec->id}}">Wilayah</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="" class="breadcrumb--active">{{ucwords($mode)}} Wilayah</a>
</div>
@endsection

@section('content')
<div class="intro-y flex items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">
        {{ucwords($mode)}} Wilayah Kecamatan {{ucwords(strtolower($kec->name))}}
    </h2>
</div>
<div class="grid grid-cols-12 gap-6">
    <!-- END: Profile Menu -->
    <div class="col-span-12 lg:col-span-12 xxl:col-span-12">
        <!-- BEGIN: Daftar Mobilitas -->
        <div class="intro-y box mt-5">
            <div class="flex items-center px-5 py-3 border-b border-gray-200 dark:border-dark-5">
                <h2 class="font-medium text-base mr-auto">
                    Informasi Wilayah Kecamatan
                </h2>
            </div>
            <div class="p-5">
                <form action="grid grid-cols-12 gap-6" id="form-input">
                    <input type="hidden" name="tipe" value="{{$tipe}}">
                    <input type="hidden" name="id" value="{{$kec->id}}">
                    @csrf
                    @if($tipe == 'adm')
                    <div class="col-span-12">
                        <label for="">Ibukota Kecamatan</label>
                        <input type="text" class="input w-full border mt-2" placeholder="Ibukota Kecamatan" name="ibukota" id="ibukota" value="{{@$wilayah->ibukota_kecamatan}}">
                    </div>
                    <div class="col-span-12">
                        <label for="">Luas Wilayah Kecamatan (Km<sup>2</sup>)</label>
                        <input type="number" class="input w-full border mt-2" placeholder="Luas Wilayah" name="luas" id="luas" value="{{@$wilayah->luas_wilayah}}">
                    </div>
                    <div class="col-span-6 mt-2">
                        <label for="">Jarak ke Provinsi (Km)</label>
                        <input type="number" class="input w-full border mt-2" placeholder="Jarak Ke Provinsi" name="jarakprov" id="jarakprov" value="{{@$wilayah->jarak_ke_provinsi}}">
                    </div>
                    <div class="col-span-6 mt-2">
                        <label for="">Jarak Ke Kota (Km)</label>
                        <input type="number" class="input w-full border mt-2" placeholder="Jarak Ke Kota" name="jarakkot" id="jarakkot" value="{{@$wilayah->jarak_ke_kota}}">
                    </div>
                    <div class="col-span-4">
                        <label for="">Jumlah Desa</label>
                        <input type="number" class="input w-full border mt-2" placeholder="Jumlah Desa" name="desa" id="desa" value="{{@$wilayah->jumlah_desa}}">
                    </div>
                    <div class="col-span-4">
                        <label for="">Jumlah Kelurahan</label>
                        <input type="number" class="input w-full border mt-2" placeholder="Jumlah Kelurahan" name="kelurahan" id="kelurahan" value="{{@$wilayah->jumlah_kelurahan}}">
                    </div>
                    <div class="col-span-4">
                        <label for="">Jumlah Pulau</label>
                        <input type="number" class="input w-full border mt-2" placeholder="Jumlah Pulau" name="pulau" id="pulau" value="{{@$wilayah->jumlah_pulau}}">
                    </div>
                    <div class="col-span-12 mt-5">
                        <div class="w-full flex justify-center border-t border-gray-200 dark:border-dark-5">
                            <div class="bg-white dark:bg-dark-3 px-5 -mt-3 text-gray-600">Informasi PLB</div>
                        </div>
                    </div>
                    <div class="col-span-12 mt-2">
                        <label for="">Status PLB</label>
                        <select class="input w-full border mt-2" placeholder="Status PLB" name="status_plb" id="status_plb">
                            <option value="0" {{@$wilayah->status_plb == 0? 'selected':''}}>Tidak Tersedia</option>
                            <option value="1" {{@$wilayah->status_plb == 1? 'selected':''}}>Tersedia</option>
                        </select>
                    </div>
                    <div class="col-span-12 mt-2" id="status-holder">
                        <label for="">PLB</label>
                        <input type="text" class="input w-full border mt-2" placeholder="Nama PLB" name="plb" id="plb" value="{{@$wilayah->nama_plb}}">
                        <small>Kosongkan jika tidak tersedia</small>
                    </div>
                    @endif

                    @if($tipe == 'batas')
                    <div class="col-span-6">
                        <label for="">Batas Barat</label>
                        <input type="text" class="input w-full border mt-2" placeholder="Batas Barat" name="barat" id="barat" value="{{@$wilayah->batas_barat}}">
                    </div>
                    <div class="col-span-6">
                        <label for="">Batas Timur</label>
                        <input type="text" class="input w-full border mt-2" placeholder="Batas Timur" name="timur" id="timur" value="{{@$wilayah->batas_timur}}">
                    </div>
                    <div class="col-span-6">
                        <label for="">Batas Utara</label>
                        <input type="text" class="input w-full border mt-2" placeholder="Batas Utara" name="utara" id="utara" value="{{@$wilayah->batas_utara}}">
                    </div>
                    <div class="col-span-6">
                        <label for="">Batas Selatan</label>
                        <input type="text" class="input w-full border mt-2" placeholder="Batas Selatan" name="selatan" id="selatan" value="{{@$wilayah->batas_selatan}}">
                    </div>
                    <div class="col-span-12 mt-5">
                        <div class="w-full flex justify-center border-t border-gray-200 dark:border-dark-5 ">
                            <div class="bg-white dark:bg-dark-3 px-5 -mt-3 text-gray-600">Perbatasan Negara</div>
                        </div>
                    </div>
                    <div class="col-span-6">
                        <label for="">Jenis Batas Negara</label>
                        <select class="input w-full border mt-2" placeholder="Jenis Batas Negara" name="jenis_negara" id="jenis_negara">
                            <option value="0" {{@$wilayah->batas_negara_jenis == 0? 'selected':''}}>Tidak Tersedia</option>
                            <option value="1" {{@$wilayah->batas_negara_jenis == 1? 'selected':''}}>Darat</option>
                            <option value="2" {{@$wilayah->batas_negara_jenis == 2? 'selected':''}}>Laut</option>
                        </select>
                    </div>
                    <div class="col-span-6" id="negara-holder">
                        <label for="">Batas Negara</label>
                        <input type="text" class="input w-full border mt-2" placeholder="Batas Negara" name="negara" id="negara" value="{{@$wilayah->batas_negara}}">
                        <small>Kosongkan jika tidak ada</small>
                    </div>
                </form>
                @endif
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
            text: 'Anda akan menginput data Wilayah Kecamatan. Lanjutkan?',
            showCancelButton: true,
            confirmButtonText: 'Lanjutkan',
            cancelButtonText: 'Tutup',
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                let formData = new FormData($('#form-input')[0]);
                $.ajax({
                    url:'{{route('kec.wil.atur.store')}}',
                    method:'post',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success:res=>{
                        if (res.status == 200) {
                            showSuccess(res.msg, ()=>{
                                window.location.replace('{{url('kecamatan/wil')}}/{{$kec->id}}');
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
