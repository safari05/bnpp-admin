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
    <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="{{route('kec.index')}}">Kecamatan</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="{{route('kec.index')}}">Kependudukan</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="{{url('kec/aset')}}/{{$kec->id}}">Umur</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="" class="breadcrumb--active">{{ucwords($mode)}}</a>
</div>
@endsection

@section('content')
<div class="intro-y flex items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">
        {{ucwords($mode)}} Detail Umur Kependudukan Kecamatan {{ucwords(strtolower($kec->name))}}
    </h2>
</div>
<div class="grid grid-cols-12 gap-6">
    <!-- END: Profile Menu -->
    <div class="col-span-12 lg:col-span-12 xxl:col-span-12">
        <!-- BEGIN: Daftar Kepegawaian -->
        <div class="intro-y box mt-5">
            <div class="flex items-center px-5 py-3 border-b border-gray-200 dark:border-dark-5">
                <h2 class="font-medium text-base mr-auto">
                    Informasi Kependudukan
                </h2>
            </div>
            <div class="p-5">
                    <div class="grid grid-cols-12 gap-6">
                        <div class="col-span-12">
                            <label for="">Umur Penduduk</label>
                            {{-- @dd($ages) --}}
                            <select data-search="true" class="tail-select w-full" name="umur" id="umur">
                                @foreach ($ages as $item)
                                <option value="{{$item->idjenis}}">{{$item->nama}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-span-12">
                            <label for="">Jumlah Penduduk</label>
                            <input type="numer" class="input w-full border mt-2" placeholder="Jumlah Penduduk" name="jumlah" id="jumlah" value="{{@$penduduk->jumlah}}">
                        </div>
                        <div class="col-span-12">
                            <div class="text-right mt-5">
                                @if ($mode == 'add')
                                <button type="button" class="button w-24 bg-theme-1 text-white" onclick="submitPenduduk()">Simpan</button>
                                @else
                                <button type="button" class="button w-24 bg-theme-1 text-white" onclick="updatePenduduk()">Update</button>
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

    function submitPenduduk(){
        Swal.fire({
            title: 'Yakin data sudah benar?',
            text: 'Anda akan menginput Jumlah Penduduk Kecamatan berdasarkan Umur. Lanjutkan?',
            showCancelButton: true,
            confirmButtonText: 'Lanjutkan',
            cancelButtonText: 'Tutup',
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                let data = {
                    '_token':'{{csrf_token()}}',
                    'id':'{{$kec->id}}',
                    'idjenis':$('#umur').val(),
                    'jumlah':$('#jumlah').val(),
                }
                $.ajax({
                    url:'{{route('kec.sipil.store.ages')}}',
                    method:'post',
                    data: data,
                    success:res=>{
                        if (res.status == 200) {
                            showSuccess(res.msg, ()=>{
                                window.location.replace('{{url('kecamatan/sipil')}}/{{$kec->id}}');
                            });
                        } else {
                            showError(res.msg);
                        }
                    }
                })
            }
        })
    }

    function updatePenduduk(){
        Swal.fire({
            title: 'Yakin data sudah benar?',
            text: 'Anda akan mengubah Jumlah Penduduk Kecamatan berdasarkan Umur. Lanjutkan?',
            showCancelButton: true,
            confirmButtonText: 'Lanjutkan',
            cancelButtonText: 'Tutup',
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                let data = {
                    '_token':'{{csrf_token()}}',
                    '_method':'put',
                    'id':'{{$kec->id}}',
                    'idjenis':'{{@$penduduk->idjenis}}',
                    'jumlah':$('#jumlah').val(),
                }
                $.ajax({
                    url:'{{route('kec.sipil.update.ages')}}',
                    method:'post',
                    data: data,
                    success:res=>{
                        if (res.status == 200) {
                            showSuccess(res.msg, ()=>{
                                window.location.replace('{{url('kecamatan/sipil')}}/{{$kec->id}}');
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
