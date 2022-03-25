@extends('back.layout.main')

@push('css')
<link rel="stylesheet" href="{{asset('assets/vendor')}}/leaflet/leaflet.css"/>
<link rel="stylesheet" href="{{asset('assets/vendor')}}/leaflet-markercluster/MarkerCluster.Default.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.css" integrity="sha512-/zs32ZEJh+/EO2N1b0PEdoA10JkdC3zJ8L5FTiQu82LR9S/rOQNfQN7U59U9BC12swNeRAz3HSzIL2vpp4fv3w==" crossorigin="anonymous" />
<style>
    .d-none{
        display: none;
    }
    #map-create{
        width: inherit;
        height: 600px;
    }
    .card-coord{
        z-index: 99999;
        position: absolute;
        top: 0;
        right: 0;
        width: 20%;
    }
    .container-map{
        position: relative;
    }
</style>
@endpush

@section('bread')
<div class="-intro-x breadcrumb mr-auto hidden sm:flex">
    <a href="" class="">Application</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="{{route('kec.index')}}">Kecamatan</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="{{url('kec/aset')}}/{{$kec->id}}">Wilayah</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="" class="breadcrumb--active">{{ucwords($mode)}} Lokasi Kantor</a>
</div>
@endsection

@section('content')
<div class="intro-y flex items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">
        {{ucwords($mode)}} Lokasi Kantor Kecamatan {{ucwords(strtolower($kec->name))}}
    </h2>
</div>
<div class="grid grid-cols-12 gap-6">
    <!-- END: Profile Menu -->
    <div class="col-span-12 lg:col-span-12 xxl:col-span-12">
        <!-- BEGIN: Daftar Kepegawaian -->
        <div class="intro-y box mt-5">
            <div class="flex items-center px-5 py-3 border-b border-gray-200 dark:border-dark-5">
                <h2 class="font-medium text-base mr-auto">
                    Pilih Lokasi Kantor Kecamatan
                    <br>
                    <small>Geser pin ke lokasi kantor kecamatan</small>
                </h2>
                <div class="font-medium text-gray-700 dark:text-gray-500">
                    <button type="button" class="button button--sm block bg-theme-1 text-white" onclick="submitMap()">
                        Simpan Lokasi
                    </button>
                </div>
            </div>
            <div class="p-5">
                    <div class="grid grid-cols-12 gap-6">                        
                        <div class="col-span-12 container-map">
                            <div class="box m-2 p-2 card-coord">
                                <div class="grid grid-cols-12 gap-3">
                                    <p class="text-xl col-span-12">Koordinat</p>
                                </div>
                                <div class="grid grid-cols-12 gap-3 mt-2">
                                    <div class="col-span-10">
                                        <input type="text" name="custom-coord" id="custom-coord" class="input border w-full tooltip" title="Masukan latitude dan longitude dipisah dengan koma, contoh : 1.2912347,98.123481293" placeholder="Latitude, Longitude">
                                    </div>
                                    <div class="col-span-2">
                                        <button class="button px-2 bg-theme-9 shadow-md text-white flex items-center justify-center w-full tooltip" title="Cari Koordinat" onclick="goToCoord()">
                                            <span class="w-5 h-5 flex items-center justify-center w-full ">
                                                <i data-feather="search" class="w-4 h-4"></i> 
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="" id="map-create"></div>
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
<script src="{{asset('assets/vendor')}}/leaflet/leaflet.js"></script>
<script src="{{asset('assets/vendor')}}/leaflet-markercluster/leaflet.markercluster.js"></script>
<script>
    var table;
    var lat;
    var long;
    var specialMarker;
    var map;

    const active_lat = '{{$coord["lat"]}}';
    const active_lng = '{{$coord["lng"]}}';
    $(document).ready(function(){
        initMapKecamatan();
    })

    function initMapKecamatan(){
        let coord = [-1.938866507948674, 117.71236419677734];
        if(!isEmpty(active_lat) && !isEmpty(active_lng)){
            coord = [active_lat, active_lng];
        }
        $('#custom-coord').val(coord.join(','));

        map = L.map('map-create').setView(coord, 5);
        L.tileLayer('https://www.google.cn/maps/vt?lyrs=m&x={x}&y={y}&z={z}', {
            attribution:'&copy; Google Street',
            maxZoom: 18,
        }).addTo(map);

        specialMarker = L.marker(coord, {
            draggable:true,
        }).bindPopup('<button type="button" class="button button--sm block bg-theme-1 text-white" onclick="submitMap()">Simpan Lokasi Kantor Kecamatan</button>').addTo(map);
        specialMarker.on('dragend', function(e){
            var newpos = e.target.getLatLng();
            lat = newpos.lat;
            long = newpos.lng;
            // console.log(newpos.lat+', '+newpos.lng);
            $('#custom-coord').val(newpos.lat+','+newpos.lng);
        })

    }

    function submitMap(){
        Swal.fire({
            title: 'Yakin data sudah benar?',
            text: 'Anda akan menginput Pegawai Kecamatan dengan data tersebut. Lanjutkan?',
            showCancelButton: true,
            confirmButtonText: 'Lanjutkan',
            cancelButtonText: 'Tutup',
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                let data = {
                    '_token':'{{csrf_token()}}',
                    'id':'{{$kec->id}}',
                    'lat':lat,
                    'long':long,
                }
                $.ajax({
                    url:'{{route('kec.wil.pin.store')}}',
                    method:'post',
                    data: data,
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

    function goToCoord(){
        let custcoord = $('#custom-coord').val();
        let newlok = custcoord.split(',');
        if(newlok.length == 2){
            map.setView(newlok);
            lat = newlok[0];
            long = newlok[1];
            specialMarker.setLatLng(newlok);
        }else{
            showError('Lokasi tidak ditemukan, pastikan menulis koordinat sesuai format!')
        }
    }
</script>
@endpush
