@extends('back.layout.main')

@push('css')
<style>
    .d-none{
        display: none;
    }
    .label-th{
        max-width: 180px;
        width: 180px
    }
</style>
@endpush

@section('bread')
<div class="-intro-x breadcrumb mr-auto hidden sm:flex">
    <a href="" class="">Application</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="{{route('plb.log.index')}}">Log Pos Lintas Batas</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="" class="breadcrumb--active">Detail</a>
</div>
@endsection

@section('content')
<div class="intro-y flex items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">
        Detail Log Pos Lintas Batas
    </h2>
</div>
<div class="grid grid-cols-12 gap-6">
    <!-- BEGIN: Profile Menu -->
    <div class="col-span-12 lg:col-span-4 xxl:col-span-3 flex lg:block flex-col-reverse">
        <div class="intro-y box mt-5">
            <div class="relative flex items-center p-5">
                @include('back.plb.log.sub-title')
            </div>
            <div class="p-5 border-t border-gray-200 dark:border-dark-5">
                <a class="flex items-center" href="#info-pos"> <i data-feather="home" class="w-4 h-4 mr-2"></i> Informasi Lintas </a>
                <a class="flex items-center mt-5" href="#info-pel"> <i data-feather="map" class="w-4 h-4 mr-2"></i> Informasi Pelintas </a>
                <a class="flex items-center mt-5" href="#info-barang"> <i data-feather="box" class="w-4 h-4 mr-2"></i> Informasi Muatan Barang</a>
                <a class="flex items-center mt-5" href="#info-orang"> <i data-feather="smile" class="w-4 h-4 mr-2"></i> Informasi Muatan Orang </a>
            </div>
        </div>
    </div>
    <!-- END: Profile Menu -->
    <div class="col-span-12 lg:col-span-8 xxl:col-span-9">
        <div class="intro-y box mt-5" id="info-pos">
            <div class="flex items-center px-5 py-3 border-b border-gray-200 dark:border-dark-5">
                <h2 class="font-medium text-base mr-auto">
                    Detail Informasi Pelintas
                </h2>
                {{-- <div class="font-medium text-gray-700 dark:text-gray-500">
                    <a href="{{url('plb/master/edit')}}/{{$plb->idplb}}">
                        <button type="button" class="button button--sm block bg-theme-1 text-white">
                            Atur Detail
                        </button>
                    </a>
                </div> --}}
            </div>
            <div class="p-5">
                <div class="grid grid-cols-12 gap-6">
                    <div class="col-span-12">
                        <table class="table w-full">
                            <tr>
                                <th class="label-th">Nama Pos Lintas</th>
                                <td>{{$lintas->plb->nama_plb}}</td>
                            </tr>
                            <tr>
                                <th class="label-th">Jenis Pos Lintas</th>
                                <td>{{($lintas->plb->jenis_plb==1)? 'NON PLBN':'PLBN'}}</td>
                            </tr>
                            <tr>
                                <th class="label-th">Lokasi Pos Lintas</th>
                                <td>{{ucwords(strtolower('Desa '. @$lintas->plb->desa->name.', Kecamatan '. @$lintas->plb->kecamatan->name.', '. @$lintas->plb->kecamatan->kota->name.', Provinsi '. @$lintas->plb->kecamatan->kota->provinsi->name))}}</td>
                            </tr>
                            <tr>
                                <th class="label-th">Tanggal Lintas</th>
                                <td>{{\Carbon\Carbon::parse($lintas->tanggal_lintas)->locale('id')->translatedFormat('d F Y')}}</td>
                            </tr>
                            <tr>
                                <th class="label-th">Waktu Lintas</th>
                                <td>{{$lintas->jam_lintas}} ({{$lintas->zona_waktu??'WIB'}})</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="intro-y box mt-5" id="info-pelin">
            <div class="flex items-center px-5 py-3 border-b border-gray-200 dark:border-dark-5">
                <h2 class="font-medium text-base mr-auto">
                    Detail Informasi Pelintas
                </h2>
                {{-- <div class="font-medium text-gray-700 dark:text-gray-500">
                    <a href="{{url('plb/master/edit')}}/{{$plb->idplb}}">
                        <button type="button" class="button button--sm block bg-theme-1 text-white">
                            Atur Detail
                        </button>
                    </a>
                </div> --}}
            </div>
            <div class="p-5">
                <div class="grid grid-cols-12 gap-6">
                    <div class="col-span-12">
                        <table class="table w-full">
                            <tr>
                                <th class="label-th">Nama Pelintas</th>
                                <td>{{$lintas->nama_pelintas}}</td>
                            </tr>
                            <tr>
                                <th class="label-th">Jenis Identitas</th>
                                <td>{{@$lintas->jenis_identitas}}</td>
                            </tr>
                            <tr>
                                <th class="label-th">Nomor Identitas</th>
                                <td>{{@$lintas->nomor_identitas}}</td>
                            </tr>
                            <tr>
                                <th class="label-th">Gender Pelintas</th>
                                <td>{{@$lintas->gender_pelintas=='l'? 'Laki-laki':'Perempuan'}}</td>
                            </tr>
                            <tr>
                                <th class="label-th">Tipe Penduduk Pelintas</th>
                                <td>{{@$lintas->tipe_penduduk_pelintas=='1'?'Warga Negara Indonesia': 'Warga Negara Asing'}}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="intro-y box mt-5" id="info-barang">
            <div class="flex items-center px-5 py-3 border-b border-gray-200 dark:border-dark-5">
                <h2 class="font-medium text-base mr-auto">
                    Detail Informasi Muatan Barang
                </h2>
            </div>
            <div class="p-5">
                <div class="grid grid-cols-12 gap-6">
                    <div class="col-span-12">
                        <table class="table w-full">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Jenis Barang</th>
                                    <th>Nama Barang</th>
                                    <th>Jumlah</th>
                                    <th>Satuan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($lintas->barang) > 0)
                                @foreach ($lintas->barang as $key => $item)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$item->jenis->nama}}</td>
                                    <td>{{$item->nama_barang}}</td>
                                    <td>{{$item->jumlah_barang}}</td>
                                    <td>{{$item->satuan_jumlah_barang}}</td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="5" class="text-center"><strong>Tidak Ada Muatan Barang</strong></td>
                                </tr>
                                @endif

                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="intro-y box mt-5" id="info-orang">
            <div class="flex items-center px-5 py-3 border-b border-gray-200 dark:border-dark-5">
                <h2 class="font-medium text-base mr-auto">
                    Detail Informasi Muatan Orang
                </h2>
            </div>
            <div class="p-5">
                <div class="grid grid-cols-12 gap-6">
                    <div class="col-span-12">
                        <table class="table w-full">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Jumlah Orang</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($lintas->orang) > 0)
                                @foreach ($lintas->orang as $key => $item)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$item->jumlah_orang}}</td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="2" class="text-center"><strong>Tidak Ada Muatan Orang</strong></td>
                                </tr>
                                @endif

                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script>
</script>
@endpush
