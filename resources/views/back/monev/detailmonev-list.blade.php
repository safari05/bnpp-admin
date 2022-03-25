@extends('back.layout.main')
@push('css')
<style>
    td.details-control {
        background: url('{{asset('assets/vendor/yajra')}}/details_open.png') no-repeat center center;
        cursor: pointer;
    }
    tr.shown td.details-control {
        background: url('{{asset('assets/vendor/yajra')}}/details_close.png') no-repeat center center;
    }
</style>
@endpush

@section('bread')
<div class="-intro-x breadcrumb mr-auto hidden sm:flex">
    <a href="" class="">Application</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="{{route('monev.index')}}">Monev</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="" class="breadcrumb--active">Detail Monev</a>
</div>
@endsection
@section('content')
<div class="intro-y flex items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">
        Detail Monev
    </h2>
    <div class="font-medium text-gray-700 dark:text-gray-500">
        <a href="{{route('monev.index')}}">
            <button class="button bg-gray-400 text-gray-800 shadow-md mr-1 mb-1">Kembali</button>
        </a>
    </div>
</div>
<div class="grid grid-cols-12 gap-6">
    <!-- BEGIN: Profile Menu -->
    <div class="col-span-12 lg:col-span-4 xxl:col-span-3 flex lg:block flex-col-reverse">
        <div class="intro-y box mt-5">
            <div class="relative flex items-center p-5">
                <div class="ml-4 mr-auto">
                    <div class="font-medium text-base">Detail Monev Tahun {{$monev->tahun}}</div>
                    <div class="text-gray-600"><small>Kecamatan {{$monev->kecamatan}}</small></div>
                    <div class="text-gray-600"><small>{{$monev->kabupaten.', '.$monev->provinsi}}</small></div>
                </div>
            </div>
            <div class="p-5 border-t border-gray-200 dark:border-dark-5">
                @foreach ($detail as $key => $item)
                <a class="flex items-center mb-5" href="#poin-{{$key+1}}">{{$item->variabel->nama}}</a>
                @endforeach
            </div>
        </div>
    </div>
    <!-- END: Profile Menu -->
    <div class="col-span-12 lg:col-span-8 xxl:col-span-9">
        @foreach ($detail as $key => $item)
        <div class="intro-y box mt-5" id="poin-{{$key+1}}">
            <div class="flex items-center px-5 py-3 border-b border-gray-200 dark:border-dark-5">
                <h2 class="font-medium text-base mr-auto">
                    {{$item->variabel->nama}}
                </h2>
                <div class="font-medium text-gray-700 dark:text-gray-500">
                    Skor : {{$item->rata_rata??0}}
                </div>
            </div>
            <div class="p-5">
                <div class="grid grid-cols-12 gap-6">
                    <div class="col-span-12">
                        <table class="table">
                            @foreach ($indikator as $kay => $indi)
                                @if($indi->variabel_id == $item->variabel_id)
                                <tr>
                                    <th colspan="5" class="border">{{$indi->nama}}</th>
                                </tr>
                                {{-- START: Indikator 1 sampai 4 --}}
                                    @if(in_array($indi->id, ['1','2','3','4']))
                                    <tr>
                                        <th class="border">No</th><th class="border">Indikator Evaluasi</th><th class="border">Ketersediaan</th><th class="border">Kecukupan</th><th class="border">Kondisi</th>
                                    </tr> 
                                        @foreach ($tanya as $kuy => $tanyaan)
                                            @foreach ($tanyaan as $koy => $value)
                                            @if ($value->pertanyaan->indikator_id == $indi->id)
                                            <tr>
                                                <td class="border">{{$koy+1}}</td>
                                                <td class="border">{{$value->pertanyaan->pertanyaan}}</td>
                                                <td class="border">{!!$value->ketersediaan??'<p class=" text-theme-6">Tidak Ada</p>'!!}</td>
                                                <td class="border">{!!$value->kecukupan??'<p class=" text-theme-6">Tidak Ada</p>'!!}</td>
                                                <td class="border">{!!$value->kondisi??'<p class=" text-theme-6">Tidak Ada</p>'!!}</td>
                                            </tr>                                    
                                            @endif                                             
                                            @endforeach                               
                                        @endforeach
                                    @endif
                                {{-- END: Indikator 1 sampai 4 --}}

                                {{-- START: Indikator 5 --}}
                                    @if(in_array($indi->id, ['5']))
                                    <tr>
                                        <th class="border">No</th><th class="border">Indikator Evaluasi</th><th class="border">Jumlah Kebutuhan</th><th class="border">Keterisian</th><th class="border">Bobot Nilai</th>
                                    </tr> 
                                        @foreach ($tanya as $kuy => $tanyaan)
                                            @foreach ($tanyaan as $koy => $value)
                                            @if ($value->pertanyaan->indikator_id == $indi->id)
                                            <tr>
                                                <td class="border">{{$koy+1}}</td>
                                                <td class="border">{{$value->pertanyaan->pertanyaan}}</td>
                                                <td class="border">{!!$value->kebutuhan??'<p class=" text-theme-6">Tidak Ada</p>'!!}</td>
                                                <td class="border">{!!$value->keterisian??'<p class=" text-theme-6">Tidak Ada</p>'!!}</td>
                                                <td class="border">{!!$value->bobot_keb_ket??'<p class=" text-theme-6">Tidak Ada</p>'!!}</td>
                                            </tr>                                    
                                            @endif                                             
                                            @endforeach                               
                                        @endforeach
                                    @endif
                                {{-- END: Indikator 5 --}}

                                {{-- START: Indikator 6 --}}
                                    @if(in_array($indi->id, ['6']))
                                    <tr>
                                        <th class="border">No</th><th class="border">Indikator Evaluasi</th><th class="border">Bobot Nilai</th><th class="border">Banyaknya</th><th class="border">Jumlah Bobot Nilai</th>
                                    </tr> 
                                        @foreach ($tanya as $kuy => $tanyaan)
                                            @foreach ($tanyaan as $koy => $value)
                                            @if ($value->pertanyaan->indikator_id == $indi->id)
                                            <tr>
                                                <td class="border">{{$koy+1}}</td>
                                                <td class="border">{{$value->pertanyaan->pertanyaan}}</td>
                                                <td class="border">{!!$value->bobot_nilai_pendidikan??'<p class=" text-theme-6">Tidak Ada</p>'!!}</td>
                                                <td class="border">{!!$value->banyak_pendidikan??'<p class=" text-theme-6">Tidak Ada</p>'!!}</td>
                                                <td class="border">{!!$value->jum_bobot_nilai_pendidikan??'<p class=" text-theme-6">Tidak Ada</p>'!!}</td>
                                            </tr>                                    
                                            @endif                                             
                                            @endforeach                               
                                        @endforeach
                                    @endif
                                {{-- END: Indikator 6 --}}

                                {{-- START: Indikator 7 --}}
                                    @if(in_array($indi->id, ['7']))
                                    <tr>
                                        <th class="border">No</th><th class="border">Indikator Evaluasi</th><th class="border">Ketersediaan</th>
                                    </tr> 
                                        @foreach ($tanya as $kuy => $tanyaan)
                                            @foreach ($tanyaan as $koy => $value)
                                            @if ($value->pertanyaan->indikator_id == $indi->id)
                                            <tr>
                                                <td class="border">{{$koy+1}}</td>
                                                <td class="border">{{$value->pertanyaan->pertanyaan}}</td>
                                                <td class="border">{!!$value->ketersediaan??'<p class=" text-theme-6">Tidak Ada</p>'!!}</td>
                                            </tr>                                    
                                            @endif                                             
                                            @endforeach                               
                                        @endforeach
                                    @endif
                                {{-- END: Indikator 7 --}}

                                {{-- START: Indikator 8 --}}
                                    @if(in_array($indi->id, ['8']))
                                    <tr>
                                        <th class="border">No</th><th class="border">Indikator Evaluasi</th><th class="border">Ketersediaan</th>
                                    </tr> 
                                        @foreach ($tanya as $kuy => $tanyaan)
                                            @foreach ($tanyaan as $koy => $value)
                                            @if ($value->pertanyaan->indikator_id == $indi->id)
                                            <tr>
                                                <td class="border">{{$koy+1}}</td>
                                                <td class="border">{{$value->pertanyaan->pertanyaan}}</td>
                                                <td class="border">{!!$value->ketersediaan??'<p class=" text-theme-6">Tidak Ada</p>'!!}</td>
                                            </tr>                                    
                                            @endif                                             
                                            @endforeach                               
                                        @endforeach
                                    @endif
                                {{-- END: Indikator 8 --}}

                                {{-- START: Indikator 9 --}}
                                    @if(in_array($indi->id, ['9']))
                                    <tr>
                                        <th class="border">No</th><th class="border">Indikator Evaluasi</th><th class="border">Ketersediaan</th>
                                    </tr> 
                                        @foreach ($tanya as $kuy => $tanyaan)
                                            @foreach ($tanyaan as $koy => $value)
                                            @if ($value->pertanyaan->indikator_id == $indi->id)
                                            <tr>
                                                <td class="border">{{$koy+1}}</td>
                                                <td class="border">{{$value->pertanyaan->pertanyaan}}</td>
                                                <td class="border">{!!$value->ketersediaan??'<p class=" text-theme-6">Tidak Ada</p>'!!}</td>
                                            </tr>                                    
                                            @endif                                             
                                            @endforeach                               
                                        @endforeach
                                    @endif
                                {{-- END: Indikator 9 --}}
                                @endif
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @endforeach       
    </div>
</div>
@endsection

@push('js')
@endpush
