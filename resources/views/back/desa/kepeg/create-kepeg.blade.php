@extends('back.layout.main')

@push('css')
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
    <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="{{url('desa/kepeg')}}/{{$desa->id}}">Kepegawaian</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="" class="breadcrumb--active">{{ucwords($mode)}}</a>
</div>
@endsection

@section('content')
<div class="intro-y flex items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">
        {{ucwords($mode)}} Kepegawaian Desa {{ucwords(strtolower($desa->name))}}
    </h2>
</div>
<div class="grid grid-cols-12 gap-6">
    <!-- END: Profile Menu -->
    <div class="col-span-12 lg:col-span-12 xxl:col-span-12">
        <!-- BEGIN: Daftar Kepegawaian -->
        <div class="intro-y box mt-5">
            <div class="flex items-center px-5 py-3 border-b border-gray-200 dark:border-dark-5">
                <h2 class="font-medium text-base mr-auto">
                    Informasi Kepegawaian
                </h2>
            </div>
            <div class="p-5">
                    <div class="grid grid-cols-12 gap-6">
                        <div class="col-span-12">
                            <label for="">Jenis ASN</label>
                            <select data-search="true" class="tail-select w-full" id="asn" placeholder="Jenis ASN">
                                @foreach ($asn as $item)
                                    @if($mode=='edit')
                                        @if(@$kepeg->jenis_asn == $item->jenis_asn)
                                        <option value="{{$item->jenis_asn}}">{{$item->keterangan}}</option>
                                        @endif
                                    @else
                                        <option value="{{$item->jenis_asn}}">{{$item->keterangan}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="col-span-12">
                            <label for="">Bagian Operasional</label>
                            <select data-search="true" class="tail-select w-full" id="staf">
                                @foreach ($oper as $item)
                                    @if($mode=='edit')
                                        @if(@$kepeg->operasional == $item->idoperasional)
                                        <option value="{{$item->idoperasional}}">{{$item->keterangan}}</option>
                                        @endif
                                    @else
                                        <option value="{{$item->idoperasional}}">{{$item->keterangan}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="col-span-12">
                            <label for="">Kelembagaan</label>
                            <select data-search="true" class="tail-select w-full" id="lembaga">
                                @foreach ($lembaga as $item)
                                    @if($mode=='edit')
                                        @if(@$kepeg->kelembagaan == $item->idkelembagaan)
                                        <option value="{{$item->idkelembagaan}}">{{$item->keterangan}}</option>
                                        @endif
                                    @else
                                        <option value="{{$item->idkelembagaan}}">{{$item->keterangan}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="col-span-12">
                            <label for="">Jumlah Pegawai</label>
                            <input type="numer" class="input w-full border mt-2" placeholder="Jumlah Pegawai" name="jumlah" id="jumlah" value="{{@$kepeg->jumlah}}">
                        </div>
                        <div class="col-span-12">
                            <div class="text-right mt-5">
                                @if($mode == 'add')
                                <button type="button" class="button w-24 bg-theme-1 text-white" onclick="submitPegawai()">Simpan</button>
                                @else
                                <button type="button" class="button w-24 bg-theme-1 text-white" onclick="updatePegawai()">Update</button>
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
<script>
    var table;
    $(document).ready(function(){
    })

    function submitPegawai(){
        Swal.fire({
            title: 'Yakin data sudah benar?',
            text: 'Anda akan menginput Pegawai Desa dengan data tersebut. Lanjutkan?',
            showCancelButton: true,
            confirmButtonText: 'Lanjutkan',
            cancelButtonText: 'Tutup',
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                let data = {
                    '_token':'{{csrf_token()}}',
                    'id':'{{$desa->id}}',
                    'asn':$('#asn').val(),
                    'staf':$('#staf').val(),
                    'lembaga':$('#lembaga').val(),
                    'jumlah':$('#jumlah').val(),
                }
                $.ajax({
                    url:'{{route('desa.kepeg.store')}}',
                    method:'post',
                    data: data,
                    success:res=>{
                        if (res.status == 200) {
                            showSuccess(res.msg, ()=>{
                                window.location.replace('{{url('desa/kepeg')}}/{{$desa->id}}');
                            });
                        } else {
                            showError(res.msg);
                        }
                    }
                })
            }
        })
    }

    function updatePegawai(){
        Swal.fire({
            title: 'Yakin data sudah benar?',
            text: 'Anda akan mengubah Data Pegawai Desa dengan data tersebut. Lanjutkan?',
            showCancelButton: true,
            confirmButtonText: 'Lanjutkan',
            cancelButtonText: 'Tutup',
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                let data = {
                    '_token':'{{csrf_token()}}',
                    '_method':'put',
                    'id':'{{$desa->id}}',
                    'series':'{{@$series}}',
                    'jumlah':$('#jumlah').val(),
                }
                $.ajax({
                    url:'{{route('desa.kepeg.update')}}',
                    method:'post',
                    data: data,
                    success:res=>{
                        if (res.status == 200) {
                            showSuccess(res.msg, ()=>{
                                window.location.replace('{{url('desa/kepeg')}}/{{$desa->id}}');
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
