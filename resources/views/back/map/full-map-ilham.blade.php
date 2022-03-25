@extends('back.layout.main')

@push('css')
<link rel="stylesheet" href="{{asset('assets/vendor')}}/leaflet/leaflet.css"/>
<link rel="stylesheet" href="{{asset('assets/vendor')}}/leaflet-markercluster/MarkerCluster.Default.css"/>
<link rel="stylesheet" href="{{asset('assets/vendor')}}/leaflet-geocoder/Control.OSMGeocoder.css"/>
<link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css" />

<style>
    .d-none{
        display: none;
    }
    #map-all{
        width: 100%;
        height: 950px;
        position: relative;
        top: 0;
        right: 0;
        z-index: -20;
    }
    .behind{
        z-index: 10 !important;
    }
    .select-dropdown{
        z-index: 99999 !important;
    }
    .map-scroll:before {
        position: absolute;
        left: 0;
        right: 0;
        bottom: 0;
        top: 0;
        content: '';
        background: #00000070;
        z-index: 999;
    }
    .map-scroll:after {
        content: 'Gunakan ctrl + scroll untuk zoom pada peta';
        position: absolute;
        top: 50%;
        left: 30%;
        z-index: 999;
        font-size: 34px;
        color: #fff;
    }
    .leaflet-control-geocoder a {
        background-size: 27px;
    }
    .leaflet-control-geocoder-form input[type="text"]{
        padding: 7px 15px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }
    .leaflet-control-geocoder-form input[type="submit"]{
        padding: 3px 10px;
        border: 1px solid #ccc;
        background: #ccc;
    }
    .leaflet-control-geocoder-form{
        position: relative;
        padding: 0 !important;
    }
    .leaflet-control-geocoder-form svg{
        width: 18px;
    }
    .leaflet-control-geocoder-form button{
        position: absolute;
        right: 13px;
        top: 0;
        font-size: 18px;
        height: 100%;
        background: transparent;
        border: none;
        display: inline-flex;
        justify-content: center;
        align-items: center;

    }
</style>
@endpush

@section('bread')
<div class="-intro-x breadcrumb mr-auto hidden sm:flex">
    <a href="" class="">Application</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="" class="breadcrumb--active">Peta</a>
</div>
@endsection

@section('content')

<div class="intro-y items-center">
    <div class="" id="map-all"></div>
    <div class="floating-card">
        <div class="box m-2 p-3">
            <p class="text-xl">Pencarian</p>
            <div class="grid grid-cols-12 gap-3 mt-2">
                <div class="col-span-6">
                    <label for="">Provinsi</label>    
                    <select class="col-span-3 border mr-2 w-full tail-select" data-search="true" name="provid" id="provid">
                        {{-- <option value="0">Semua Provinsi</option> --}}
                        @foreach ($provinces as $item)
                            <option value="{{$item->id}}">{{$item->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-span-6">
                    <label for="">Kota</label>
                    <select class="input input--lg col-span-3 border mr-2 w-full" data-search="true" name="kotaid" id="kotaid">
                    </select>
                </div>
                <div class="col-span-12 text-center">
                    {{-- class selected button : bg-gray-200 text-gray-600 --}}
                    <button class="button px-2 mr-1 mb-2 bg-theme-1 text-white tooltip shadow-md mr-1 mb-2 btn-filter" title="Kecamatan" onclick="toogleFilter('kec')" id="filkec">                      
                        <span class="w-5 h-5 flex items-center justify-center"> 
                            <i data-feather="codesandbox" class="w-4 h-4"></i>
                        </span> 
                    </button>
                    <button class="button px-2 mr-1 mb-2 bg-theme-9 text-white tooltip shadow-md mr-1 mb-2 btn-filter" title="Desa" onclick="toogleFilter('desa')" id="fildesa">                      
                        <span class="w-5 h-5 flex items-center justify-center"> 
                            <i data-feather="codepen" class="w-4 h-4"></i>
                        </span> 
                    </button>
                    <button class="button px-2 mr-1 mb-2 bg-theme-6 text-white tooltip shadow-md mr-1 mb-2 btn-filter" title="Pos Lintas Batas" onclick="toogleFilter('plb')" id="filplb">                      
                        <span class="w-5 h-5 flex items-center justify-center"> 
                            <i data-feather="truck" class="w-4 h-4"></i>
                        </span> 
                    </button>
                </div>
                <div class="col-span-12">
                    <div class="w-full border-t border-gray-200 dark:border-dark-5 border-dashed"></div>
                </div>                
            </div>            
            <div class="grid grid-cols-12 gap-3 mt-2 filter-row d-none" id="filter-kec">
                <div class="col-span-12 mt-2"><h3 class="text-medium truncate mr-5">Lokpri Kecamatan</h3></div>
                <div class="flex flex-col sm:flex-row col-span-12">
                    @foreach ($tipe as $item)
                    <div class="flex items-center text-gray-700 mr-2">
                        <input type="checkbox" class="input border mr-2 s-check-tipe" value="{{$item->typeid}}" data-tipe="{{$item->typeid}}">
                        <label class="cursor-pointer select-none">{{$item->nickname}}</label>
                    </div>
                    <div class="col-span-2 self-end">
                        <button class="button w-24 bg-theme-1 text-white w-full" onclick="refreshMap()">Terapkan</button>
                    </div>
                    @endforeach
                </div>
                <div class="col-span-12">
                    <label for="">Kecamatan</label>
                    <select class="input input--lg col-span-3 border mr-2 w-full" name="kecid" id="kecid">
                        <option value="0">Semua Kecamatan</option>
                    </select>
                </div>
            </div>  
            <div class="grid grid-cols-12 gap-3 mt-2 filter-row d-none" id="filter-desa">
                <div class="col-span-12">
                    <label for="">Kecamatan</label>
                    <select class="input input--lg col-span-3 border mr-2 w-full" name="keciddesa" id="keciddesa">
                        <option value="0">Semua Kecamatan</option>
                    </select>
                </div>
                <div class="col-span-12">
                    <label for="">Desa</label>
                    <select class="input input--lg col-span-3 border mr-2 w-full" name="desaid" id="desaid">
                        <option value="0">Semua Desa</option>
                    </select>
                </div>
            </div>
            <div class="grid grid-cols-12 gap-3 mt-2 filter-row d-none" id="filter-plb">
                <div class="col-span-12">
                    <label for="">Kecamatan</label>
                    <select class="input input--lg col-span-3 border mr-2 w-full" name="kecidplb" id="kecidplb">
                        <option value="0">Semua Kecamatan</option>
                    </select>
                </div>
                <div class="col-span-12">
                    <label for="">Jenis PLB</label>
                    <select class="input input--lg col-span-3 border mr-2 w-full" name="jenisplb" id="jenisplb">
                        <option value="1">Non PLBN</option>
                        <option value="2">PLBN</option>
                    </select>
                </div>
                <div class="col-span-12">
                    <label for="">Nama PLB</label>
                    <select class="input input--lg col-span-3 border mr-2 w-full" name="plbid" id="plbid">
                    </select>
                </div>
            </div>
            <div class="grid grid-cols-12 gap-3 mt-2" id="filter-desa">
                <div class="col-span-12">
                    <button class="button w-24 w-full shadow-md mr-1 mb-2 bg-gray-200 text-gray-600" onclick="locatePin()">Cari</button>
                </div>
            </div>
        </div>
        <div class="box m-2 p-3 d-none" id="box-tempat">
            <p class="text-xl">Informasi Tempat</p>
            <div class="grid grid-cols-12 gap-3 mt-2">
                <div class="col-span-12 info-tempat d-none" id="info-kec">
                    <table class="table">
                        <tr>
                            <th class="w-30">Nama Kecamatan</th>
                            <td class="name">Kecamatan Teupah Selatan</td>
                        </tr>
                        <tr>
                            <th class="w-30">Lokasi</th>
                            <td class="lokasi">Kabupaten Simeulue, Aceh</td>
                        </tr>
                        <tr>
                            <th class="w-30">Tipe Kecamatan</th>
                            <td class="tipe">778, 562, 231</td>
                        </tr>
                        <tr>
                            <th class="w-30">Status Lokpri</th>
                            <td class="lokpri">Lokpri, PKSN, PPKT</td>
                        </tr>
                    </table>
                </div>
                <div class="col-span-12 info-tempat d-none" id="info-desa">
                    <table class="table">
                        <tr>
                            <th class="w-30">Nama Desa</th>
                            <td class="name">Desa Latiung</td>
                        </tr>
                        <tr>
                            <th class="w-30">Kecamatan</th>
                            <td class="kecamatan">Kecamatan Simeulue Selatan</td>
                        </tr>
                        <tr>
                            <th class="w-30">Lokasi</th>
                            <td class="lokasi">Kabupaten Simeulue, Aceh</td>
                        </tr>
                    </table>
                </div>
                <div class="col-span-12 info-tempat d-none" id="info-plb">
                    <table class="table">
                        <tr>
                            <th class="w-30">Nama Pos</th>
                            <td class="name">Pos Lintas Batas Tanjung Puniang</td>
                        </tr>
                        <tr>
                            <th class="w-30">Desa</th>
                            <td class="desa">Desa Latiung</td>
                        </tr>
                        <tr>
                            <th class="w-30">Kecamatan</th>
                            <td class="kecamatan">Kecamatan Simeulue Selatan</td>
                        </tr>
                        <tr>
                            <th class="w-30">Lokasi</th>
                            <td class="lokasi">Kabupaten Simeulue, Aceh</td>
                        </tr>
                        <tr>
                            <th class="w-30">Tipe Pos</th>
                            <td class="tipe">NON - PLBN</td>
                        </tr>
                    </table>
                </div>
                <div class="col-span-12">
                    <div class="w-full border-t border-gray-200 dark:border-dark-5 border-dashed"></div>
                </div>                
            </div> 
            <div class="grid grid-cols-12 gap-3 mt-2">
                <div class="col-span-6">
                    <button class="button w-24 w-full shadow-md mr-1 mb-2 bg-theme-1 text-white">Navigasi</button>
                </div>
                <div class="col-span-6">
                    <button class="button w-24 w-full shadow-md mr-1 mb-2 bg-theme-9 text-white" id="goto-detail">Detail</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script src="{{asset('assets/vendor')}}/leaflet/leaflet.js"></script>
<script src="{{asset('assets/vendor')}}/leaflet-markercluster/leaflet.markercluster.js"></script>
<script src="{{asset('assets/vendor')}}/leaflet-geocoder/Control.OSMGeocoder.js"></script>
<script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>
<script>
    var map;
    var cluster;
    var startPoin = {};
    var routing;
    var allCoord = [];
    $(document).ready(function(){
        initMap();
        
        /** Filter */
        initKota(11);
        $('#provid').on('change', function(){
            initKota($(this).val());
        })

        $('#kotaid').on('change', function(){
            initKec($(this).val(), '#kecid');
            initKec($(this).val(), '#keciddesa');
            initKec($(this).val(), '#kecidplb');
        })

        $('#keciddesa').on('change', function(){
            initDesa($(this).val());
        })
        $('#kecidplb').on('change', function(){
            initDesa($(this).val());
            initPLB($(this).val(), $('#desaid').val());
        })
        $('#jenisplb').on('change', function(){
            initPLB($('#kecidplb').val());
        })
        $('body').on('click', '.s-check-tipe', function(){
            initKec($('#kotaid').val());
        });
        $('body').on('click', '.s-check-lokpri', function(){
            initKec($('#kotaid').val());
        });
        /** End Filter */
    })

    /** Filter */
    var selected = '';
    function toogleFilter(tipe){
        document.querySelectorAll('.btn-filter').forEach(element=>{
            element.classList.remove('bg-gray-200');
            element.classList.remove('text-gray-600');
            if(element.id == 'fildesa') element.classList.add('bg-theme-9');  element.classList.add('text-white');
            if(element.id == 'filplb') element.classList.add('bg-theme-6'); element.classList.add('text-white');
            if(element.id == 'filkec') element.classList.add('bg-theme-1'); element.classList.add('text-white');
        });
        document.querySelectorAll('.filter-row').forEach(element=>{
            element.classList.add('d-none');
        });

        selected = tipe;
        if(tipe == 'kec'){
            $('#filkec').removeClass('bg-theme-1 text-white').addClass('bg-gray-200 text-gray-600');
            $('#filter-kec').removeClass('d-none');
            initKec($('#kotaid').val(), '#kecid');
        }else if(tipe == 'desa'){
            $('#fildesa').removeClass('bg-theme-9 text-white').addClass('bg-gray-200 text-gray-600');
            $('#filter-desa').removeClass('d-none');
            initKec($('#kotaid').val(), '#keciddesa');
        }else if(tipe == 'plb'){        
            $('#filplb').removeClass('bg-theme-6 text-white').addClass('bg-gray-200 text-gray-600');
            $('#filter-plb').removeClass('d-none');
            initKec($('#kotaid').val(), '#kecidplb');
        }
    }

    function initKota(prov = 0){
        $.getJSON('{{route('opt.kota')}}?provid='+prov,
            res=>{
                $('#kotaid').empty();
                if(res && prov > 0){
                    res.forEach(element => {
                        let opt = '<option value="'+element.id+'">'+element.name+'</option>';
                        $('#kotaid').append(opt);
                    });
                }

                let first = (res[0])? res[0].id:0;

                if(selected == 'kec') initKec(first, '#kecid');
                if(selected == 'desa') initKec(first, '#kecidplb');
                if(selected == 'plb') initKec(first, '#keciddesa');
            },
        )
    }

    function initKec(kota = 0, target = '#kecid'){
        let stipe = '';
        let tipecheck = document.querySelectorAll('.s-check-tipe');
        tipecheck.forEach(element => {
            if($(element).prop('checked')){
                if(isEmpty(stipe)) stipe = $(element).val();
                else stipe += ','+$(element).val();
            }
        });

        let slokpri = '';
        let lokpricheck = document.querySelectorAll('.s-check-lokpri');
        lokpricheck.forEach(element => {
            if($(element).prop('checked')){
                if(isEmpty(slokpri)) slokpri = $(element).val();
                else slokpri += ','+$(element).val();
            }
        });
        
        $.getJSON('{{route('opt.kec')}}?kotaid='+kota+'&lokpri='+slokpri+'&tipe='+stipe,
            res=>{
                $(target).html('');
                if(res && kota > 0){
                    res.forEach(element => {
                        let opt = '<option value="'+element.id+'">'+element.name+'</option>';
                        $(target).append(opt);
                    });
                }

                let first = (res[0])? res[0].id:0;
                if(target == '#keciddesa') initDesa(first);
                if(target == '#kecidplb') initPLB(first);
            },
        )
    }

    function initDesa(kec = 0){
        $.getJSON('{{route('opt.desa')}}?kecid='+kec,
            res=>{
                $('#desaid').html('');
                if(res && kec > 0){
                    res.forEach(element => {
                        let opt = '<option value="'+element.id+'">'+element.name+'</option>';
                        $('#desaid').append(opt);
                    });
                }
            },
        )
    }

    function initPLB(kec = 0){
        var tipe = $("#jenisplb").val();
        $.getJSON('{{route('opt.plb')}}?kecid='+kec+'&tipe='+tipe,
            res=>{
                $('#plbid').html('');
                if(res && kec > 0){
                    res.forEach(element => {
                        let opt = '<option value="'+element.idplb+'">'+element.nama_plb+'</option>';
                        $('#plbid').append(opt);
                    });
                }
            },
        )
    }
    /** End Filter */


    function refreshMap(){
        cluster.clearLayers();
        initPin();
    }

    function initPin(){
        cluster = L.markerClusterGroup();

        setLokasiKecamatan();

        map.addLayer(cluster);
    }

    function initMap(){
        let coord = [-1.938866507948674, 110.71236419677734];

        map = L.map('map-all').setView(coord, 5);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution:'Map data © <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY- SA</a>',
            maxZoom: 18,
        }).addTo(map);
        map.zoomControl.remove();

        L.control.zoom({
            position:'bottomright',
        }).addTo(map);
        initPin();


        routing = L.Routing.control({
            waypoints: [
                {
                    title: 'Kecamatan Bla',
                    lat: 5.8524188720788315,
                    lng: 95.2709713418438,
                },
                {
                    title: 'Pos Lintas Batas',
                    lat: 5.853400779454059,
                    lng: 95.26088456830776,
                },
            ],
            position: 'bottomleft'
            // router: L.Routing.mapbox('pk.eyJ1IjoiYm5wcGRldiIsImEiOiJja2d2bnBmamMwMjUyMnFwaTd3OW85NTVwIn0.45IzYx9JwYFFRLbXW0mg8Q')
        }).addTo(map);

        map.on('click',function(e){
            lat = e.latlng.lat;
            lon = e.latlng.lng;
            if (startPoin != undefined) {
                map.removeLayer(startPoin);
            };
            startPoin = L.marker([lat,lon]).bindPopup('<button class="button button--sm bg-theme-6 mt-1 text-white w-full" onclick="hapusStart()">Hapus marker</button>').addTo(map);
        })

        var options = {
            collapsed: false, /* Whether its collapsed or not */
            position: 'topright', /* The position of the control */
            text: 'cari', /* The text of the submit button */
            placeholder: 'Cari suatu tempat...', /* The text of the search input placeholder */
        };
        var osmGeocoder = new L.Control.OSMGeocoder(options);
        map.addControl(osmGeocoder);

        //disable default scroll
        map.scrollWheelZoom.disable();

        $("#map-all").bind('mousewheel DOMMouseScroll', function (event) {
            event.stopPropagation();
            if (event.ctrlKey == true) {
                event.preventDefault();
                map.scrollWheelZoom.enable();
                $('#map-all').removeClass('map-scroll');
                setTimeout(function(){
                    map.scrollWheelZoom.disable();
                }, 1000);
            } else {
                map.scrollWheelZoom.disable();
                $('#map-all').addClass('map-scroll');
            }

        });

        $(window).bind('mousewheel DOMMouseScroll', function (event) {
            $('#map-all').removeClass('map-scroll');
        });

        var form = $('.leaflet-control-geocoder-form');
        form.find('input[value="cari"]').remove();
        form.append('<button type="submit"><i data-feather="search"></i></button>');
        feather.replace();
    }

    // function hapusStart(){
    //     if (startPoin != undefined) {
    //         map.removeLayer(startPoin);
    //     };
    // }

    // function setTujuan(lat, long){
    //     let startCoord = [startPoin.getLatLng().lat, startPoin.getLatLng().lng];
    //     let waypoints = [
    //         L.latLng(startCoord),
    //         L.latLng(lat, long)
    //     ];
    //     console.log(waypoints);
    //     routing.setWaypoints(waypoints);
    // }

    /** Set Map Pin **/
    function setLokasiKecamatan(){
        $.getJSON('{{route('dash.map.coord.kec')}}', res=>{
            if(res.status==200){
                res.data.forEach(element => {
                    let temp = element;
                    temp['tipe']='kec';
                    
                    allCoord.push(temp);

                    cluster.addLayer(L.marker([element.lat, element.long]).bindPopup('<b>'+element.name+'</b><br />'+element.lokasi+'<br/>'+
                        '<a href="{{url('kecamatan/detail')}}/'+element.id+'"><button class="button button--sm bg-theme-1 mt-1 text-white w-full">Detail</button></a>'+
                        '<button class="button button--sm bg-theme-9 mt-1 text-white w-full" onclick="setTujuan('+element.lat+', '+element.long+')">Atur sebagai Tujuan</button>'));
                });
            }
        }).done(()=>{
            setLokasiDesa();
        });
    }

    function setLokasiDesa(){
        let desaicon = L.icon({
            iconUrl: '{{asset('assets/vendor/')}}/leaflet/images/marker-desa.png',
            iconAnchor: [12.5, 10],
        });
        $.getJSON('{{route('dash.map.coord.desa')}}', res=>{
            if(res.status==200){
                res.data.forEach(element => {
                    let temp = element;
                    temp['tipe']='desa';
                    
                    allCoord.push(temp);

                    cluster.addLayer(L.marker([element.lat, element.long], {icon:desaicon}).bindPopup('<b>'+element.name+'</b><br />'+element.lokasi+'<br/>'+
                        '<a href="{{url('desa/detail')}}/'+element.id+'"><button class="button button--sm bg-theme-1 mt-1 text-white w-full">Detail</button></a>'+
                        '<button class="button button--sm bg-theme-9 mt-1 text-white w-full" onclick="setTujuan('+element.lat+', '+element.long+')">Atur sebagai Tujuan</button>'));
                });
            }
        }).done(()=>{
            setLokasiPlb();
        });
    }

    function setLokasiPlb(){
        var plbicon = L.icon({
            iconUrl: '{{asset('assets/vendor/')}}/leaflet/images/marker-plb.png',
            iconAnchor: [12.5, 10],
        });
        $.getJSON('{{route('dash.map.coord.plb')}}', res=>{
            if(res.status==200){
                res.data.forEach(element => {
                    let temp = element;
                    temp['tipe']='plb';
                    
                    allCoord.push(temp);

                    cluster.addLayer(L.marker([element.lat, element.long], {icon:plbicon}).bindPopup('<b>'+element.name+'</b><br />'+element.lokasi+'<br/>'+
                        '<a href="{{url('plb/detail')}}/'+element.id+'"><button class="button button--sm bg-theme-1 mt-1 text-white w-full">Detail</button></a>'+
                        '<button class="button button--sm bg-theme-9 mt-1 text-white w-full" onclick="setTujuan('+element.lat+', '+element.long+')">Atur sebagai Tujuan</button>'));
                });
            }
        }).done(()=>{
            console.log(allCoord);
        });
    }
    /** End Set Map Pin */

    function locatePin(){
        let lokasi = [];
        lokasi = cariLokasi(selected);
        console.log(lokasi);
        //View map jadi ke koordinat lokasi
        if(lokasi != null && lokasi != undefined && lokasi){
            map.setView([lokasi.lat, lokasi.long], 16);
        }
    }

    function cariLokasi(tipe = null){
        if(tipe != null){
            let id = 0;
            if(tipe == 'kec') id = $('#kecid').val();
            else if(tipe == 'desa') id = $('#desaid').val();
            else if(tipe == 'plb') id = $('#plbid').val();
            const found = allCoord.find(item=>{
                return item.tipe == selected && item.id == id;
            })

            document.querySelectorAll('.info-tempat').forEach(element=>{
                element.classList.add('d-none');
            });
            $('#box-tempat').addClass('d-none');

            if(found != null && found != undefined && found){
                getDetailTempat(tipe, id);
                $('#box-tempat').removeClass('d-none');
            }else{
                showError('Informasi Tempat tidak ditemukan');
            }
            return found;
        }
    }
    
    function getDetailTempat(tipe, id){
        $.getJSON('{{url('dash/map/pin')}}/'+tipe+'/'+id, res=>{
            if(res.status == 200){

                if(tipe == 'kec'){
                    $('#info-kec .name').html(res.data.name);
                    $('#info-kec .lokasi').html(res.data.lokasi);
                    $('#info-kec .lokpri').html(res.data.lokpri);
                    $('#info-kec .tipe').html(res.data.tipe);
                    $('#info-kec').removeClass('d-none');                    
                }else if(tipe == 'desa'){
                    $('#info-desa .name').html(res.data.name);
                    $('#info-desa .lokasi').html(res.data.lokasi);
                    $('#info-desa .kecamatan').html(res.data.kecamatan);
                    $('#info-desa').removeClass('d-none');
                }else if(tipe == 'plb'){
                    $('#info-plb .name').html(res.data.name);
                    $('#info-plb .lokasi').html(res.data.lokasi);
                    $('#info-plb .desa').html(res.data.desa);
                    $('#info-plb .kecamatan').html(res.data.kecamatan);
                    $('#info-plb .tipe').html(res.data.tipe);
                    $('#info-plb').removeClass('d-none');
                }
                $('#goto-detail').off('click');
                $('#goto-detail').on('click', function(){
                    window.location.href = res.data.detailurl;
                });
            }else{
                showError(res.msg);
            }
        });
    }
</script>
@endpush
