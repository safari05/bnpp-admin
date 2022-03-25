@extends('back.layout.main')

@push('css')
<link rel="stylesheet" href="{{asset('assets/vendor')}}/leaflet/leaflet.css"/>
<link rel="stylesheet" href="{{asset('assets/vendor')}}/leaflet-markercluster/MarkerCluster.Default.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.css" integrity="sha512-/zs32ZEJh+/EO2N1b0PEdoA10JkdC3zJ8L5FTiQu82LR9S/rOQNfQN7U59U9BC12swNeRAz3HSzIL2vpp4fv3w==" crossorigin="anonymous" />
<style>
    .d-none{
        display: none;
    }
</style>
@endpush

@section('bread')
<div class="-intro-x breadcrumb mr-auto hidden sm:flex">
    <a href="" class="">Application</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="{{route('plb.master.index')}}">Pos Lintas Batas</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="" class="breadcrumb--active">Detail</a>
</div>
@endsection

@section('content')
<div class="intro-y flex items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">
        Pos Lintas Batas
    </h2>
</div>
<div class="grid grid-cols-12 gap-6">
    <!-- BEGIN: Profile Menu -->
    <div class="col-span-12 lg:col-span-4 xxl:col-span-3 flex lg:block flex-col-reverse">
        <div class="intro-y box mt-5">
            <div class="relative flex items-center p-5">
                @include('back.plb.master.sub-title')
            </div>
            <div class="p-5 border-t border-gray-200 dark:border-dark-5">
                <a class="flex items-center" href="#wil-map"> <i data-feather="map" class="w-4 h-4 mr-2"></i> Peta Lokasi PLB </a>
                <a class="flex items-center mt-5" href="#wil-admin"> <i data-feather="edit" class="w-4 h-4 mr-2"></i> Informasi Administrasi PLB</a>
                <a class="flex items-center mt-5" href="#wil-batas"> <i data-feather="hexagon" class="w-4 h-4 mr-2"></i> Batas PLB </a>
            </div>
            <div class="p-5 border-t border-gray-200 dark:border-dark-5">
                @include('back.plb.master.sub-side')
            </div>
        </div>
    </div>
    <!-- END: Profile Menu -->
    <div class="col-span-12 lg:col-span-8 xxl:col-span-9">
        <div class="intro-y box mt-5" id="wil-batas">
            <div class="flex items-center px-5 py-3 border-b border-gray-200 dark:border-dark-5">
                <h2 class="font-medium text-base mr-auto">
                    Detail Pos Lintas Batas
                </h2>
                <div class="font-medium text-gray-700 dark:text-gray-500">
                    <a href="{{url('plb/master/edit')}}/{{$plb->idplb}}">
                        <button type="button" class="button button--sm block bg-theme-1 text-white">
                            Atur Detail
                        </button>
                    </a>
                </div>
            </div>
            <div class="p-5">

                <div class="w-full lg:w-auto mt-6 lg:mt-0 pt-4 lg:pt-0 flex-1 flex items-center justify-center px-5 border-t lg:border-t-0 border-gray-200 dark:border-dark-5">
                    <div class="text-center rounded-md w-40 py-3">
                        <div class="text-gray-600">Jenis PLB</div>
                        <div class="font-semibold text-theme-1 dark:text-theme-10 text-lg">{{(@$plb->jenis_plb==1)?'Non PLBN':'PLBN'}}</div>
                    </div>
                    <div class="text-center rounded-md w-40 py-3">
                        <div class="text-gray-600">Tipe PLB</div>
                        <div class="font-semibold text-theme-1 dark:text-theme-10 text-lg">{{(@$plb->tipe_plb)??'-'}}</div>
                    </div>
                </div>
                <div class="w-full lg:w-auto mt-6 lg:mt-0 pt-4 lg:pt-0 flex-1 flex items-center justify-center px-5 border-t lg:border-t-0 border-gray-200 dark:border-dark-5">
                    <div class="text-center rounded-md w-40 py-3">
                        <div class="text-gray-600">Alamat PLB</div>
                        <div class="font-semibold text-theme-1 dark:text-theme-10 text-lg">{{(@$plb->alamat_plb)??'-'}}</div>
                    </div>
                </div>
            </div>
        </div>
        <!-- BEGIN: Map -->
        <div class="intro-y box mt-5" id="wil-map">
            <div class="flex items-center px-5 py-3 border-b border-gray-200 dark:border-dark-5">
                <h2 class="font-medium text-base mr-auto">
                    Peta Lokasi Pos Lintas Batas
                </h2>
                <div class="font-medium text-gray-700 dark:text-gray-500">
                    <a href="{{url('plb/master/pin')}}/{{$plb->idplb}}">
                        <button type="button" class="button button--sm block bg-theme-1 text-white">
                            Atur Lokasi Pos
                        </button>
                    </a>
                </div>
            </div>
            <div class="p-5">
                <div class="mt-4">
                    <div id="map-desa" style="width: 100%; height: 600px;"></div>
                </div>
            </div>
        </div>
        <!-- END: Map -->
        <!-- BEGIN: Administrasi -->
        <div class="intro-y box mt-5" id="wil-admin">
            <div class="flex items-center px-5 py-3 border-b border-gray-200 dark:border-dark-5">
                <h2 class="font-medium text-base mr-auto">
                    Administrasi Pos Lintas Batas
                </h2>
                <div class="font-medium text-gray-700 dark:text-gray-500">
                    <a href="{{url('plb/master/edit')}}/{{$plb->idplb}}">
                        <button type="button" class="button button--sm block bg-theme-1 text-white">
                            Atur Detail
                        </button>
                    </a>
                </div>
            </div>
            <div class="p-5">
                <div class="w-full lg:w-auto mt-6 lg:mt-0 pt-4 lg:pt-0 flex-1 flex items-center justify-center px-5 border-t lg:border-t-0 border-gray-200 dark:border-dark-5">
                    <div class="text-center rounded-md w-40 py-3">
                        <div class="text-gray-600">Status Imigrasi</div>
                        <div class="font-semibold text-theme-1 dark:text-theme-10 text-lg">{{@$plb->status_imigrasi??'-'}}</div>
                    </div>
                    <div class="text-center rounded-md w-40 py-3">
                        <div class="text-gray-600">Status Karantina Kesehatan</div>
                        <div class="font-semibold text-theme-1 dark:text-theme-10 text-lg">{{@$plb->status_karantina_kesehatan??'-'}}</div>
                    </div>
                    <div class="text-center rounded-md w-40 py-3">
                        <div class="text-gray-600">Status Karantina Pertanian</div>
                        <div class="font-semibold text-theme-1 dark:text-theme-10 text-lg">{{@$plb->status_karantina_pertanian??'-'}}</div>
                    </div>
                    <div class="text-center rounded-md w-40 py-3">
                        <div class="text-gray-600">Status Karantina Perikanan</div>
                        <div class="font-semibold text-theme-1 dark:text-theme-10 text-lg">{{@$plb->status_karantina_perikanan??'-'}}</div>
                    </div>
                </div>

                <div class="w-full lg:w-auto mt-6 lg:mt-0 pt-4 lg:pt-0 flex-1 flex items-center justify-center px-5 border-t lg:border-t-0 border-gray-200 dark:border-dark-5">
                    <div class="text-center rounded-md w-40 py-3">
                        <div class="text-gray-600">Status Karantina Perikanan</div>
                        <div class="font-semibold text-theme-1 dark:text-theme-10 text-lg">{{@$plb->status_keamanan_tni??'-'}}</div>
                    </div>
                    <div class="text-center rounded-md w-40 py-3">
                        <div class="text-gray-600">Status Karantina Perikanan</div>
                        <div class="font-semibold text-theme-1 dark:text-theme-10 text-lg">{{@$plb->status_keamanan_polri??'-'}}</div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END: Administrasi -->
        <!-- BEGIN: Batas Desa -->
        <div class="intro-y box mt-5" id="wil-batas">
            <div class="flex items-center px-5 py-3 border-b border-gray-200 dark:border-dark-5">
                <h2 class="font-medium text-base mr-auto">
                    Batas Pos Lintas Batas
                </h2>
                <div class="font-medium text-gray-700 dark:text-gray-500">
                    <a href="{{url('plb/master/edit')}}/{{$plb->idplb}}">
                        <button type="button" class="button button--sm block bg-theme-1 text-white">
                            Atur Detail
                        </button>
                    </a>
                </div>
            </div>
            <div class="p-5">

                <div class="w-full lg:w-auto mt-6 lg:mt-0 pt-4 lg:pt-0 flex-1 flex items-center justify-center px-5 border-t lg:border-t-0 border-gray-200 dark:border-dark-5">
                    <div class="text-center rounded-md w-40 py-3">
                        <div class="text-gray-600">Jenis Perbatasan</div>
                        <div class="font-semibold text-theme-1 dark:text-theme-10 text-lg">{{(@$plb->jenis_perbatasan==1)?'Darat':'Laut'}}</div>
                    </div>
                </div>
                <div class="w-full lg:w-auto mt-6 lg:mt-0 pt-4 lg:pt-0 flex-1 flex items-center justify-center px-5 border-t lg:border-t-0 border-gray-200 dark:border-dark-5">
                    <div class="text-center rounded-md w-40 py-3">
                        <div class="text-gray-600">Batas Barat</div>
                        <div class="font-semibold text-theme-1 dark:text-theme-10 text-lg">{{@$plb->batas_negara_barat??'-'}}</div>
                    </div>
                    <div class="text-center rounded-md w-40 py-3">
                        <div class="text-gray-600">Batas Timur</div>
                        <div class="font-semibold text-theme-1 dark:text-theme-10 text-lg">{{@$plb->batas_negara_timur??'-'}}</div>
                    </div>
                    <div class="text-center rounded-md w-40 py-3">
                        <div class="text-gray-600">Batas Selatan</div>
                        <div class="font-semibold text-theme-1 dark:text-theme-10 text-lg">{{@$plb->batas_negara_selatan??'-'}}</div>
                    </div>
                    <div class="text-center rounded-md w-40 py-3">
                        <div class="text-gray-600">Batas Utara</div>
                        <div class="font-semibold text-theme-1 dark:text-theme-10 text-lg">{{@$plb->batas_negara_utara??'-'}}</div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END: Batas Desa -->
    </div>
</div>
@endsection
@push('js')
<script src="{{asset('assets/vendor')}}/leaflet/leaflet.js"></script>
<script src="{{asset('assets/vendor')}}/leaflet-markercluster/leaflet.markercluster.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js" integrity="sha512-d9xgZrVZpmmQlfonhQUvTR7lMPtO7NkZMkA0ABN3PHCbKA5nqylQ/yWlFAyY6hYgdF1Qh6nYiuADWwKB4C2WSw==" crossorigin="anonymous"></script>
<script>
    var table;
    const active_lat = '{{$coord['lat']}}';
    const active_lng = '{{$coord['lng']}}';
    const desa_lat = '{{$desacoord['lat']}}';
    const desa_lng = '{{$desacoord['lng']}}';
    const kec_lat = '{{$keccoord['lat']}}';
    const kec_lng = '{{$keccoord['lng']}}';
    $(document).ready(function(){
        initMapDesa();
    })

    function initMapDesa(){
        var map = L.map('map-desa').setView([active_lat, active_lng], 5);
        L.tileLayer('https://www.google.cn/maps/vt?lyrs=m&x={x}&y={y}&z={z}', {
            attribution:'&copy; Google Street',
            maxZoom: 18,
        }).addTo(map);

        if(!isEmpty(active_lat) && !isEmpty(active_lng)){
            var markers = L.markerClusterGroup();
            var plbicon = L.icon({
                iconUrl: '{{asset('assets/vendor/')}}/leaflet/images/marker-plb.png',
                iconAnchor: [12.5, 15],
            });
            var desaicon = L.icon({
                iconUrl: '{{asset('assets/vendor/')}}/leaflet/images/marker-desa.png',
                iconAnchor: [12.5, 15],
            });
            markers.addLayer(L.marker([active_lat, active_lng], {icon:plbicon}).bindPopup('<b>{{$plb->nama_plb}}</b><br />{{$plb->kecamatan->name.', '.$plb->kecamatan->kota->name.', '.$plb->kecamatan->kota->provinsi->name}}'));
            markers.addLayer(L.marker([desa_lat, desa_lng], {icon:desaicon}).bindPopup('<b>Kantor Desa {{$plb->desa->name}}</b><br />{{$plb->kecamatan->name.', '.$plb->kecamatan->kota->name.', '.$plb->kecamatan->kota->provinsi->name}}'));
            markers.addLayer(L.marker([kec_lat, kec_lng]).bindPopup('<b>Kantor Kecamatan {{$plb->kecamatan->name}}</b><br />{{$plb->kecamatan->kota->name.', '.$plb->kecamatan->kota->provinsi->name}}'));
            map.addLayer(markers);
        }

    }
</script>
@endpush
