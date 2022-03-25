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
    <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="{{route('desa.index')}}">Desa</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="" class="breadcrumb--active">Kepegawaian</a>
</div>
@endsection

@section('content')
<div class="intro-y flex items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">
        Pegawai Desa
    </h2>
</div>
<div class="grid grid-cols-12 gap-6">
    <!-- BEGIN: Profile Menu -->
    <div class="col-span-12 lg:col-span-4 xxl:col-span-3 flex lg:block flex-col-reverse">
        <div class="intro-y box mt-5">
            <div class="relative flex items-center p-5">
                @include('back.desa.sub-title')
            </div>
            <div class="p-5 border-t border-gray-200 dark:border-dark-5">
                <a class="flex items-center" href="#wil-map"> <i data-feather="map" class="w-4 h-4 mr-2"></i> Peta Lokasi Desa </a>
                <a class="flex items-center mt-5" href="#wil-admin"> <i data-feather="edit" class="w-4 h-4 mr-2"></i> Informasi Administrasi Wilayah</a>
                <a class="flex items-center mt-5" href="#wil-batas"> <i data-feather="hexagon" class="w-4 h-4 mr-2"></i> Batas Desa </a>
            </div>
            <div class="p-5 border-t border-gray-200 dark:border-dark-5">
                @include('back.desa.sub-side')
            </div>
        </div>
    </div>
    <!-- END: Profile Menu -->
    <div class="col-span-12 lg:col-span-8 xxl:col-span-9">
        <!-- BEGIN: Map -->
        <div class="intro-y box mt-5" id="wil-map">
            <div class="flex items-center px-5 py-3 border-b border-gray-200 dark:border-dark-5">
                <h2 class="font-medium text-base mr-auto">
                    Peta Lokasi Kantor Desa
                </h2>
                <div class="font-medium text-gray-700 dark:text-gray-500">
                    <a href="{{url('desa/wil')}}/{{$desa->id}}/pin">
                        <button type="button" class="button button--sm block bg-theme-1 text-white">
                            Atur Lokasi Kantor
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
                    Administrasi Wilayah
                </h2>
                <div class="font-medium text-gray-700 dark:text-gray-500">
                    <a href="{{url('desa/wil')}}/{{$desa->id}}/atur/adm">
                        <button type="button" class="button button--sm block bg-theme-1 text-white">
                            Atur Wilayah
                        </button>
                    </a>
                </div>
            </div>
            <div class="p-5">
                <div class="w-full lg:w-auto mt-6 lg:mt-0 pt-4 lg:pt-0 flex-1 flex items-center justify-center px-5 border-t lg:border-t-0 border-gray-200 dark:border-dark-5">
                    <div class="text-center rounded-md w-40 py-3">
                        <div class="text-gray-600">Ibu Kota Desa</div>
                        <div class="font-semibold text-theme-1 dark:text-theme-10 text-lg">{{@$wilayah->ibukota_desa??'-'}}</div>
                    </div>
                    <div class="text-center rounded-md w-40 py-3">
                        <div class="text-gray-600">Luas Wilayah</div>
                        <div class="font-semibold text-theme-1 dark:text-theme-10 text-lg">{{@$wilayah->luas_wilayah??'-'}} Km<sup>2</sup></div>
                    </div>
                </div>

                <div class="w-full lg:w-auto mt-6 lg:mt-0 pt-4 lg:pt-0 flex-1 flex items-center justify-center px-5 border-t lg:border-t-0 border-gray-200 dark:border-dark-5">
                    <div class="text-center rounded-md w-40 py-3">
                        <div class="text-gray-600">Jarak Ke Kecamatan</div>
                        <div class="font-semibold text-theme-1 dark:text-theme-10 text-lg">{{@$wilayah->jarak_ke_kecamatan??'-'}} Km</div>
                    </div>
                    <div class="text-center rounded-md w-40 py-3">
                        <div class="text-gray-600">Jarak Ke Kabupaten</div>
                        <div class="font-semibold text-theme-1 dark:text-theme-10 text-lg">{{@$wilayah->jarak_ke_kabupaten??'-'}} Km</div>
                    </div>
                    <div class="text-center rounded-md w-40 py-3">
                        <div class="text-gray-600">PLB</div>
                        <div class="font-semibold text-theme-1 dark:text-theme-10 text-lg">{{@$wilayah->nama_plb??'-'}}</div>
                    </div>
                    <div class="text-center rounded-md w-40 py-3">
                        <div class="text-gray-600">Status PLB</div>
                        <div class="font-semibold text-theme-1 dark:text-theme-10 text-lg">{{(@$wilayah->status_plb==1)? 'Ada':'Tidak Ada'}}</div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END: Administrasi -->
        <!-- BEGIN: Batas Desa -->
        <div class="intro-y box mt-5" id="wil-batas">
            <div class="flex items-center px-5 py-3 border-b border-gray-200 dark:border-dark-5">
                <h2 class="font-medium text-base mr-auto">
                    Batas Desa
                </h2>
                <div class="font-medium text-gray-700 dark:text-gray-500">
                    <a href="{{url('desa/wil')}}/{{$desa->id}}/atur/batas">
                        <button type="button" class="button button--sm block bg-theme-1 text-white">
                            Atur Wilayah
                        </button>
                    </a>
                </div>
            </div>
            <div class="p-5">
                <div class="w-full lg:w-auto mt-6 lg:mt-0 pt-4 lg:pt-0 flex-1 flex items-center justify-center px-5 border-t lg:border-t-0 border-gray-200 dark:border-dark-5">
                    <div class="text-center rounded-md w-40 py-3">
                        <div class="text-gray-600">Batas Barat</div>
                        <div class="font-semibold text-theme-1 dark:text-theme-10 text-lg">{{@$wilayah->batas_barat??'-'}}</div>
                    </div>
                    <div class="text-center rounded-md w-40 py-3">
                        <div class="text-gray-600">Batas Timur</div>
                        <div class="font-semibold text-theme-1 dark:text-theme-10 text-lg">{{@$wilayah->batas_timur??'-'}}</div>
                    </div>
                    <div class="text-center rounded-md w-40 py-3">
                        <div class="text-gray-600">Batas Selatan</div>
                        <div class="font-semibold text-theme-1 dark:text-theme-10 text-lg">{{@$wilayah->batas_selatan??'-'}}</div>
                    </div>
                    <div class="text-center rounded-md w-40 py-3">
                        <div class="text-gray-600">Batas Utara</div>
                        <div class="font-semibold text-theme-1 dark:text-theme-10 text-lg">{{@$wilayah->batas_utara??'-'}}</div>
                    </div>
                </div>
                <div class="w-full lg:w-auto mt-6 lg:mt-0 pt-4 lg:pt-0 flex-1 flex items-center justify-center px-5 border-t lg:border-t-0 border-gray-200 dark:border-dark-5">
                    <div class="text-center rounded-md w-40 py-3">
                        <div class="text-gray-600">Batas Negara</div>
                        <div class="font-semibold text-theme-1 dark:text-theme-10 text-lg">{{@$wilayah->batas_negara??'-'}}</div>
                    </div>
                    <div class="text-center rounded-md w-40 py-3">
                        <div class="text-gray-600">Jenis Batas Negara</div>
                        <div class="font-semibold text-theme-1 dark:text-theme-10 text-lg">{{(@$wilayah->batas_negara_jenis==1)? 'Darat':'Laut'}}</div>
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
    const active_lat = '{{$coord["lat"]}}';
    const active_lng = '{{$coord["lng"]}}';
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

            var desaicon = L.icon({
                iconUrl: '{{asset('assets/vendor/')}}/leaflet/images/marker-desa.png',
                iconAnchor: [12.5, 15],
            });
            markers.addLayer(L.marker([active_lat, active_lng], {icon:desaicon}).bindPopup('<b>DESA {{$desa->name}}</b><br />{{$desa->kecamatan->name.', '.$desa->kecamatan->kota->name.', '.$desa->kecamatan->kota->provinsi->name}}'));
            map.addLayer(markers);
        }

    }
</script>
@endpush
