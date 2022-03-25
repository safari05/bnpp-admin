@extends('front.layout.main')

@section('title', '| Peta Infrastruktur Perbatasan')

@push('css')
    <link rel="stylesheet" href="{{asset('assets/vendor')}}/leaflet/leaflet.css" />
    <link rel="stylesheet" href="{{asset('assets/vendor')}}/leaflet-markercluster/MarkerCluster.Default.css"/>
    <link rel="stylesheet" href="{{asset('assets/vendor')}}/leaflet-markercluster/MarkerCluster.Default.css"/>
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css" />
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{asset('css')}}/skeleton.css"/>
    <script src="{{asset('js')}}/swal-custom.js"></script>
@endpush

@push('styles')
    <style>
        body{
            text-align: left;
        }
        .map-container #map{
            position: absolute;
            top:0;
            left:0;
            height: 100%;
            width:100%;
            z-index: 10;
            overflow:hidden;
        }
        .fw-map {
            height: 700px;
        }
        .btn-outline {
            color: #28a745;
            background: transparent;
            border: 1px solid #28a745;
        }
        .features-box{
            text-align: left;
        }

        .features-box .time-line-icon{
            text-align: center;
        }
        .features-box h3 {
            padding-bottom: 0;
        }
        .form-control {
            display: block;
            width: 100%;
            height: calc(2.25rem + 2px);
            padding: .375rem .75rem !important;
            font-size: 1rem !important;
            line-height: 1.5 !important;
            color: #495057 !important;
            background-color: #fff !important;
            background-clip: padding-box !important;
            border: 1px solid #ced4da !important;
            border-radius: .25rem !important;
            transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
            margin: 0 !important;
        }
        .custom-form label{
            margin-bottom: 5px;
        }
        .list-single-header{
            margin-top: -5px;
        }
        .col-list-wrap {
            width: 30%;
        }
        .map-container.column-map {
            width: 80%;
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
            left: 35%;
            z-index: 999;
            font-size: 34px;
            color: #fff;
        }

        .floating-card {
            top: 130px;
            left: 0;
            position: absolute;
            width: 450px;
            z-index: 99;
            overflow-y: auto;
            height: 100%;
        }

        /* Let's get this party started */
        .floating-card::-webkit-scrollbar {
            width: 5px;
        }

        /* Track */
        .floating-card::-webkit-scrollbar-track {
            -webkit-box-shadow: inset 0 0 6px #f5f5f5;
            -webkit-border-radius: 10px;
            border-radius: 10px;
        }

        /* Handle */
        .floating-card::-webkit-scrollbar-thumb {
            -webkit-border-radius: 10px;
            border-radius: 10px;
            background: #ccc;
            -webkit-box-shadow: inset 0 0 6px #ccc;
        }
        .floating-card::-webkit-scrollbar-thumb:window-inactive {
            background: #ccc;
        }

        .floating-way {
            top: 0;
            left: 0;
            position: absolute;
            width: 400px;
            z-index: 99;
        }

        .box {
            box-shadow: 0 3px 20px #0000000b;
            --bg-opacity: 1;
            background-color: #fff;
            background-color: rgba(255,255,255,var(--bg-opacity));
            border-radius: .375rem;
            position: relative;
            text-align: left;
        }

        .box h3{
            font-size: 24px;
            margin-bottom: 10px;
        }
        .btn-toggle i{
            font-size: 20px;
        }

        .btn.deactive{
            color: #212529;
            background-color: #f8f9fa;
            border-color: #f8f9fa;
        }

        .btn.deactive i{
            color: #212529 !important;
        }
        .tooltip.in{
            z-index: 999;
        }
        .checkbox label:hover{
            cursor: pointer;
        }
        .checkbox label{
            display: flex;
            align-items: center;
            font-size: 16px;
        }
        .checkbox input{
            margin-right: 7px;
        }
        .leaflet-popup-content h3{
            font-size: 20px;
            margin-bottom: 10px;
        }
    </style>
@endpush

@section('content')
    <!--section -->
    <!--section -->
    <section class="parallax-section text-center" data-scrollax-parent="true">
        <div class="bg par-elem"  data-bg="{{asset('assets/front')}}/images/bg/infrastruktur.jpg" data-scrollax="properties: { translateY: '30%' }"></div>
        <div class="overlay"></div>
        <div class="container">
            <div class="section-title center-align">
                <h2><span>Peta Infrastruktur Perbatasan</span></h2>
                <div class="breadcrumbs fl-wrap"><a href="{{ route('home') }}">Beranda</a><span>Peta Infrastruktur Perbatasan</span></div>
                <span class="section-separator"></span>
            </div>
        </div>
        <div class="header-sec-link">
            <div class="container"><a href="#sec1" class="custom-scroll-link">Baca Selengkapnya</a></div>
        </div>
    </section>
    <!-- section end -->

    <!--section -->
    <section  id="sec1">
        <div class="container">
            <div class="section-title p-0">
                <h2>Peta</h2>
                <div class="section-subtitle">Infrastruktur Perbatasan</div>
                <span class="section-separator"></span>
                <p>Berikut adalah peta sebaran kawasan infrastruktur perbatasan</p>
            </div>
        </div>
    </section>
    <!-- section end -->

    <!-- Map -->
    <div class="map-container fw-map text-left">
        <div id="map"></div>
        <div class="floating-card">
            <div class="box m-2 p-3">
                <h3><b>Pencarian <span id="judul">Kecamatan</span></b></h3>
                <div class="row">
                    <div class="col-12">
                        <div class="form-row mb-3">
                            <div class="col-6">
                                <label for="provid">Provinsi</label>
                                <select class="form-control form-select2" name="provid" id="provid">
                                    {{-- <option value="0">Semua Provinsi</option> --}}
                                    @foreach ($provinces as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-6">
                                <label for="kotaid">Kota</label>
                                <select class="form-control form-select2" name="kotaid" id="kotaid">
                                </select>
                            </div>
                        </div>
                        <div class="form-row mb-3">
                            <div class="col-4">
                                <button class="btn-toggle btn btn-primary btn-block" data-toggle="tooltip" data-placement="bottom" title="Kecamatan" onclick="toogleFilter('kec')" id="filkec">
                                    <i class="fa fa-building-o text-white"></i>
                                </button>
                            </div>
                            <div class="col-4">
                                <button class="btn-toggle btn deactive btn-success btn-block" data-toggle="tooltip" data-placement="bottom" title="Desa" onclick="toogleFilter('desa')" id="fildesa">
                                    <i class="fa fa-home text-white"></i>
                                </button>
                            </div>
                            <div class="col-4">
                                <button class="btn-toggle btn deactive btn-danger btn-block" data-toggle="tooltip" data-placement="bottom" title="Pos Lintas Batas" onclick="toogleFilter('plb')" id="filplb">
                                    <i class="fa fa-truck text-white"></i>
                                </button>
                            </div>
                        </div>
                        <div class="filter-row" id="filter-kec">
                            <div class="form-group">
                                <label for="kotaid">Kecamatan</label>
                                <select class="form-control form-select2" name="kecid" id="kecid">
                                    <option value="0">Semua Kecamatan</option>
                                </select>
                            </div>
{{--                            <div class="form-group mb-3">--}}
{{--                                <label>Tipe Kecamatan</label>--}}
{{--                                @foreach ($tipe as $item)--}}
{{--                                    <div class="checkbox">--}}
{{--                                        <label><input type="checkbox" class="s-check-tipe" value="{{$item->typeid}}" data-tipe="{{$item->typeid}}">{{$item->nickname}}</label>--}}
{{--                                    </div>--}}
{{--                                @endforeach--}}
{{--                            </div>--}}
                            <div class="form-group mb-3">
                                <label>Lokpri Kecamatan</label>
                                @foreach ($lokpri as $item)
                                    <div class="checkbox">
                                        <label><input type="checkbox" class="s-check-lokpri" value="{{$item->lokpriid}}" data-tipe="{{$item->lokpriid}}">{{$item->nickname}}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="filter-row d-none" id="filter-desa">
                            <div class="form-group">
                                <label for="kotaid">Kecamatan</label>
                                <select class="form-control form-select2" name="keciddesa" id="keciddesa">
                                    <option value="0">Semua Kecamatan</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="kotaid">Desa</label>
                                <select class="form-control form-select2" name="desaid" id="desaid">
                                    <option value="0">Semua Desa</option>
                                </select>
                            </div>
                        </div>
                        <div class="filter-row d-none" id="filter-plb">
                            <div class="form-group">
                                <label for="kotaid">Kecamatan</label>
                                <select class="form-control form-select2" name="kecidplb" id="kecidplb">
                                    <option value="0">Semua Kecamatan</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="jenisplb">Jenis PLB</label>
                                <select class="form-control form-select2" name="jenisplb" id="jenisplb">
                                    <option value="1">Non PLBN</option>
                                    <option value="2">PLBN</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="jenisplb">Nama PLB</label>
                                <select class="form-control form-select2" name="plbid" id="plbid">
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <button class="btn big-btn color-bg flat-btn book-btn btn-cari" onclick="locatePin()">Cari<i class="fa fa-angle-right"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box m-2 p-3 d-none" id="box-tempat">
                <h3><b>Informasi Tempat</b></h3>
                <div class="row">
                    <div class="col-12 info-tempat d-none" id="info-kec">
                        <table class="table">
                            <tr>
                                <th class="info-row-title">Nama Kecamatan</th>
                                <td class="name">Kecamatan Teupah Selatan</td>
                            </tr>
                            <tr>
                                <th class="info-row-title">Lokasi</th>
                                <td class="lokasi">Kabupaten Simeulue, Aceh</td>
                            </tr>
                            <tr>
                                <th class="info-row-title">Tipe Kecamatan</th>
                                <td class="tipe">778, 562, 231</td>
                            </tr>
                            <tr>
                                <th class="info-row-title">Status Lokpri</th>
                                <td class="lokpri">Lokpri, PKSN, PPKT</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-12 info-tempat d-none" id="info-desa">
                        <table class="table">
                            <tr>
                                <th class="info-row-title">Nama Desa</th>
                                <td class="name">Desa Latiung</td>
                            </tr>
                            <tr>
                                <th class="info-row-title">Kecamatan</th>
                                <td class="kecamatan">Kecamatan Simeulue Selatan</td>
                            </tr>
                            <tr>
                                <th class="info-row-title">Lokasi</th>
                                <td class="lokasi">Kabupaten Simeulue, Aceh</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-12 info-tempat d-none" id="info-plb">
                        <table class="table">
                            <tr>
                                <th class="info-row-title">Nama Pos</th>
                                <td class="name">Pos Lintas Batas Tanjung Puniang</td>
                            </tr>
                            <tr>
                                <th class="info-row-title">Desa</th>
                                <td class="desa">Desa Latiung</td>
                            </tr>
                            <tr>
                                <th class="info-row-title">Kecamatan</th>
                                <td class="kecamatan">Kecamatan Simeulue Selatan</td>
                            </tr>
                            <tr>
                                <th class="info-row-title">Lokasi</th>
                                <td class="lokasi">Kabupaten Simeulue, Aceh</td>
                            </tr>
                            <tr>
                                <th class="info-row-title">Tipe Pos</th>
                                <td class="tipe">NON - PLBN</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-12">
                        <div class="form-row">
                            <div class="col-4">
                                <button class="btn btn-primary btn-block" data-toggle="tooltip" data-placement="bottom" title="Atur sebagai titik awal" id="btnOrigin"><i class="fa fa-map-pin text-white"></i></button>
                            </div>
                            <div class="col-4">
                                <button class="btn btn-warning btn-block" data-toggle="tooltip" data-placement="bottom" title="Atur sebagai tujuan" id="btnGoal"><i class="fa fa-flag text-white"></i></button>
                            </div>
                            <div class="col-4">
                                <button class="btn btn-success btn-block" data-toggle="tooltip" data-placement="bottom" title="Lihat detail" id="goto-detail"><i class="fa fa-eye text-white"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="floating-way">
            <div class="box m-2 p-3">
                <div class="row mb-3">
                    <div class="col">
                        <h3><b>Navigasi</b></h3>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="bottom" title="Bersihkan Rute" onclick="clearRoute()"><i class="fa fa-close text-white"></i></button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="form-row">
                            <div class="col-5">
                                <input type="text" name="asal" id="way-asal" class="form-control" placeholder="Asal">
                                <input type="hidden" id='lat-origin'>
                                <input type="hidden" id='long-origin'>
                            </div>
                            <div class="col-5">
                                <input type="text" name="tujuan" id="way-tujuan" class="form-control" placeholder="Tujuan">
                                <input type="hidden" id='lat-goal'>
                                <input type="hidden" id='long-goal'>
                            </div>
                            <div class="col-2">
                                <button class="btn btn-primary btn-sm btn-block" style="height: 100%;" data-toggle="tooltip" data-placement="bottom" title="Cari Rute" onclick="createRoute()"><i class="fa fa-paper-plane-o text-white"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
{{--        <ul class="mapnavigation">--}}
{{--            <li><a href="#" class="prevmap-nav">Prev</a></li>--}}
{{--            <li><a href="#" class="nextmap-nav">Next</a></li>--}}
{{--        </ul>--}}
{{--        <div class="scrollContorl mapnavbtn" title="Enable Scrolling"><span><i class="fa fa-lock"></i></span></div>--}}
    </div>
    <!-- Map end -->
@endsection

@push('scripts')
    <script src="{{asset('assets/vendor')}}/leaflet/leaflet.js"></script>
    <script src="{{asset('assets/vendor')}}/leaflet-markercluster/leaflet.markercluster.js"></script>
    <script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

    <script>
        var map;
        var cluster;
        var startPoin = {};
        var routing;
        var allCoord = [];

        $(document).ready(function(){
            $('.fw-map').css({
                // height: (screen.height)+'px'
                height: '1200px'
            })
            initMap();

            /** Component **/
            $('.form-select2').select2();
            $('[data-toggle="tooltip"]').tooltip();
            toogleFilter('kec');
            /** End Component **/

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
        });
        /** Filter */
        var selected = '';
        function toogleFilter(tipe){
            document.querySelectorAll('.btn-toggle').forEach(element=>{
                element.classList.add('deactive');
            });
            document.querySelectorAll('.filter-row').forEach(element=>{
                element.classList.add('d-none');
            });

            selected = tipe;
            if(tipe == 'kec'){
                $('#judul').text('Kecamatan');
                $('#filkec').removeClass('deactive');
                $('#filter-kec').removeClass('d-none');
                initKec($('#kotaid').val(), '#kecid');
            }else if(tipe == 'desa'){
                $('#judul').text('Desa');
                $('#fildesa').removeClass('deactive');
                $('#filter-desa').removeClass('d-none');
                initKec($('#kotaid').val(), '#keciddesa');
            }else if(tipe == 'plb'){
                $('#judul').text('Pos Lintas Batas');
                $('#filplb').removeClass('deactive');
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
                    if(stipe == '') stipe = $(element).val();
                    else stipe += ','+$(element).val();
                }
            });

            let slokpri = '';
            let lokpricheck = document.querySelectorAll('.s-check-lokpri');
            lokpricheck.forEach(element => {
                if($(element).prop('checked')){
                    if(slokpri == '') slokpri = $(element).val();
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

            /** START: Init Map */
            map = L.map('map').setView(coord, 5);
            L.tileLayer('https://www.google.cn/maps/vt?lyrs=m&x={x}&y={y}&z={z}', {
                attribution:'&copy; Google Street',
                maxZoom: 18,
            }).addTo(map);
            map.zoomControl.remove();

            L.control.zoom({
                position:'bottomright',
            }).addTo(map);
            /** END: Init Map */

            initPin();

            initMapRoute();

            /** START: Disabled zoom scroll */
            map.scrollWheelZoom.disable();

            $("#map").bind('mousewheel DOMMouseScroll', function (event) {
                event.stopPropagation();
                if (event.ctrlKey == true) {
                    event.preventDefault();
                    map.scrollWheelZoom.enable();
                    $('#map').removeClass('map-scroll');
                    setTimeout(function(){
                        map.scrollWheelZoom.disable();
                    }, 1000);
                } else {
                    map.scrollWheelZoom.disable();
                    $('#map').addClass('map-scroll');
                }

            });

            $(window).bind('mousewheel DOMMouseScroll', function (event) {
                $('#map').removeClass('map-scroll');
            })
            /** END: Disable zoom scroll */

        }

        /** START : Set Map Pin **/
        function setLokasiKecamatan(){
            $.getJSON('{{route('map.coord.kec')}}', res=>{
                if(res.status==200){
                    res.data.forEach(element => {
                        let temp = element;
                        temp['tipe']='kec';

                        allCoord.push(temp);

                        cluster.addLayer(
                            L.marker([element.lat, element.long]).
                            bindPopup('<h3><b>'+element.name+'</b></h3>'+element.lokasi+'<br/>'+
                                '<a href="{{url('infrastruktur-data/kecamatan')}}/'+element.id+'"><button class="btn btn-success btn-sm btn-block mt-3 text-white ">Detail</button></a>'
                            ).on('click', function(e){
                                selected = temp['tipe'];
                                cariLokasi(selected, element.id);
                            })
                        );
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
            $.getJSON('{{route('map.coord.desa')}}', res=>{
                if(res.status==200){
                    res.data.forEach(element => {
                        let temp = element;
                        temp['tipe']='desa';

                        allCoord.push(temp);

                        cluster.addLayer(
                            L.marker([element.lat, element.long], {icon:desaicon})
                                .bindPopup('<h3><b>'+element.name+'</b></h3>'+element.lokasi+'<br/>'+
                                    '<a href="{{url('infrastruktur-data/kelurahan')}}/'+element.id+'"><button class="btn btn-success btn-sm btn-block mt-3 text-white ">Detail</button></a>'
                                ).on('click', function(e){
                                selected = temp['tipe'];
                                cariLokasi(selected, element.id);
                            })
                        );
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
            $.getJSON('{{route('map.coord.plb')}}', res=>{
                if(res.status==200){
                    res.data.forEach(element => {
                        let temp = element;
                        temp['tipe']='plb';

                        allCoord.push(temp);

                        cluster.addLayer(
                            L.marker([element.lat, element.long], {icon:plbicon})
                                .bindPopup('<h3><b>'+element.name+'</b></h3>'+element.lokasi
                                ).on('click', function(e){
                                selected = temp['tipe'];
                                cariLokasi(selected, element.id);
                            })
                        );
                    });
                }
            }).done(()=>{
                console.log('Success load all Pin');
            });
        }
        /** END : Set Map Pin */

        /** START : Cari Lokasi */
        function locatePin(){
            let lokasi = [];
            lokasi = cariLokasi(selected);
            // console.log(lokasi);
            //View map jadi ke koordinat lokasi
            if(lokasi != null && lokasi != undefined && lokasi){
                map.setView([lokasi.lat, lokasi.long], 16);
            }
        }

        function cariLokasi(tipe = null, id = 0){
            if(tipe != null){
                if(tipe == 'kec' && id == 0) id = $('#kecid').val();
                else if(tipe == 'desa' && id == 0) id = $('#desaid').val();
                else if(tipe == 'plb' && id == 0) id = $('#plbid').val();
                const found = allCoord.find(item=>{
                    return item.tipe == selected && item.id == id;
                })

                document.querySelectorAll('.info-tempat').forEach(element=>{
                    element.classList.add('d-none');
                });
                $('#box-tempat').addClass('d-none');

                if(found != null && found != undefined && found){
                    getDetailTempat(tipe, id);
                    prepareNavigation(found);
                    $('#box-tempat').removeClass('d-none');
                }else{
                    showError('Informasi Tempat tidak ditemukan');
                }
                return found;
            }
        }

        function startLoading(tipe){
            if(tipe == 'kec'){
                $('#info-kec .name').html("<div class='card-loading'><div class='line'></div></div>");
                $('#info-kec .lokasi').html("<div class='card-loading'><div class='line'></div></div>");
                $('#info-kec .lokpri').html("<div class='card-loading'><div class='line'></div></div>");
                $('#info-kec .tipe').html("<div class='card-loading'><div class='line'></div></div>");
                $('#info-kec').removeClass('d-none');
            }else if(tipe == 'desa'){
                $('#info-desa .name').html("<div class='card-loading'><div class='line'></div></div>");
                $('#info-desa .lokasi').html("<div class='card-loading'><div class='line'></div></div>");
                $('#info-desa .kecamatan').html("<div class='card-loading'><div class='line'></div></div>");
                $('#info-desa').removeClass('d-none');
            }else if(tipe == 'plb'){
                $('#info-plb .name').html("<div class='card-loading'><div class='line'></div></div>");
                $('#info-plb .lokasi').html("<div class='card-loading'><div class='line'></div></div>");
                $('#info-plb .desa').html("<div class='card-loading'><div class='line'></div></div>");
                $('#info-plb .kecamatan').html("<div class='card-loading'><div class='line'></div></div>");
                $('#info-plb .tipe').html("<div class='card-loading'><div class='line'></div></div>");
                $('#info-plb').removeClass('d-none');
            }
        }

        function getDetailTempat(tipe, id){
            startLoading(tipe);
            $.getJSON('{{url('api/map/pin')}}/'+tipe+'/'+id, res=>{
                if(res.status == 200){

                    if(tipe == 'kec'){
                        $('#info-kec .name').html(res.data.name);
                        $('#info-kec .lokasi').html(res.data.lokasi);
                        $('#info-kec .lokpri').html(res.data.lokpri);
                        $('#info-kec .tipe').html(res.data.tipe);
                    }else if(tipe == 'desa'){
                        $('#info-desa .name').html(res.data.name);
                        $('#info-desa .lokasi').html(res.data.lokasi);
                        $('#info-desa .kecamatan').html(res.data.kecamatan);
                    }else if(tipe == 'plb'){
                        $('#info-plb .name').html(res.data.name);
                        $('#info-plb .lokasi').html(res.data.lokasi);
                        $('#info-plb .desa').html(res.data.desa);
                        $('#info-plb .kecamatan').html(res.data.kecamatan);
                        $('#info-plb .tipe').html(res.data.tipe);
                    }

                    /** START : Button Listener */
                    if(tipe != 'plb') {
                        $('#goto-detail').removeClass('d-none');
                        $('#goto-detail').unbind('click');
                        $('#goto-detail').on('click', function () {
                            window.location.href = res.data.detailurl;
                        });
                    }else{
                        $('#goto-detail').addClass('d-none');
                    }
                    /** END : Button Listener */
                }else{
                    showError(res.msg);
                }
            });
        }
        /** END :  Cari Lokasi */

        /** START: Navigation */
        function prepareNavigation(found){
            /** START : Button Listener */
            $('#btnOrigin').unbind('click');
            $('#btnOrigin').on('click', function(){
                setOrigin(found.lat, found.long, found.name);
            });

            $('#btnGoal').unbind('click');
            $('#btnGoal').on('click', function(){
                setGoal(found.lat, found.long, found.name);
            });
            /** END : Button Listener */
        }

        function setOrigin(lat, long, name = null){
            $('#way-asal').val(name);
            $('#lat-origin').val(lat);
            $('#long-origin').val(long);
        }

        function setGoal(lat, long, name = null){
            $('#way-tujuan').val(name);
            $('#lat-goal').val(lat);
            $('#long-goal').val(long);
        }

        function initMapRoute(){
            if(routing == null || routing == undefined || !routing){
                routing = L.Routing.control({
                    router: L.Routing.mapbox('pk.eyJ1IjoiYm5wcGRldiIsImEiOiJja2d2bnBmamMwMjUyMnFwaTd3OW85NTVwIn0.45IzYx9JwYFFRLbXW0mg8Q'),
                    createMarker: function() {
                        return null;
                    }
                }).addTo(map);
            }
        }

        function createRoute(){
            let origin = [$('#lat-origin').val(), $('#long-origin').val()];
            let goal = [$('#lat-goal').val(), $('#long-goal').val()];

            routing.setWaypoints([
                L.latLng(origin),
                L.latLng(goal)
            ]);

            // $('.leaflet-routing-container').addClass('box p-2');
        }

        function clearRoute(){
            $('#way-asal').val('');
            $('#lat-origin').val('');
            $('#long-origin').val('');
            $('#way-tujuan').val('');
            $('#lat-goal').val('');
            $('#long-goal').val('');
            routing.setWaypoints(null);
        }
        /** END: Navigation */
    </script>
@endpush
