@extends('front.layout.main')

@section('title', '| Peta Infrastruktur Perbatasan')

@push('styles')
    <link rel="stylesheet" href="{{asset('assets/vendor')}}/leaflet/leaflet.css" />
    <link rel="stylesheet" href="{{asset('assets/vendor')}}/leaflet-markercluster/MarkerCluster.Default.css"/>
    <link rel="stylesheet" href="{{asset('assets/vendor')}}/leaflet-markercluster/MarkerCluster.Default.css"/>
    <link rel="stylesheet" href="https://rawgit.com/k4r573n/leaflet-control-osm-geocoder/master/Control.OSMGeocoder.css"/>
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">
    <style>
        .map-container #map-kec,
        .map-container #map-kel{
            position: absolute;
            top:0;
            left:0;
            height: 100%;
            width:100%;
            z-index: 10;
            overflow:hidden;
        }
        .btn-success {
            color: #fff;
            background-color: #28a745;
            border-color: #28a745;
            padding: 7px 20px;
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
            left: 50%;
            z-index: 999;
            font-size: 34px;
            color: #fff;
        }
    </style>
@endpush

@section('content')
    <!--section -->
    <!--section -->
    <section class="parallax-section text-center" data-scrollax-parent="true">
        <div class="bg par-elem"  data-bg="{{asset('assets/front')}}/images/bg/map-static.png" data-scrollax="properties: { translateY: '30%' }"></div>
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
            <div class="section-title">
                <h2>Peta</h2>
                <div class="section-subtitle">Infrastruktur Perbatasan</div>
                <span class="section-separator"></span>
                <p>Pilih peta kawasan infrastruktur perbatasan yang akan ditampilkan</p>
            </div>

            <!-- features-box-container -->
            <div class="features-box-container fl-wrap row">
                <!--features-box -->
                <div class="features-box col-md-6">
                    <div class="time-line-icon">
                        <i class="fa fa-institution"></i>
                    </div>
                    <h3>Kecamatan</h3>
                    <p>Tampilkan peta infrastuktur perbatasan kawasan Kecamatan</p>
                    <a href="#peta-kecamatan" class="btn btn-success btnList">Terpilih</a>
                </div>
                <!-- features-box end  -->
                <!--features-box -->
                <div class="features-box col-md-6">
                    <div class="time-line-icon">
                        <i class="fa fa-home"></i>
                    </div>
                    <h3>Desa / Kelurahan</h3>
                    <p>Tampilkan peta infrastuktur perbatasan kawasan Desa / Kelurahan</p>
                    <a href="#peta-kelurahan" class="btn btn-success btn-outline btnList">Lihat Peta</a>
                </div>
                <!-- features-box end  -->
            </div>
            <!-- features-box-container end  -->
        </div>
    </section>
    <!-- section end -->

    <!-- section -->
    @include('front.infrastruktur-peta.peta-kecamatan')

    <!-- section -->
    @include('front.infrastruktur-peta.peta-kelurahan')
@endsection

@push('scripts')
    <script src="{{asset('assets/vendor')}}/leaflet/leaflet.js"></script>
    <script src="{{asset('assets/vendor')}}/leaflet-markercluster/leaflet.markercluster.js"></script>
    <script src="https://rawgit.com/k4r573n/leaflet-control-osm-geocoder/master/Control.OSMGeocoder.js"></script>

    <script>
        $(document).ready(function(){
            $('.btnList').on('click', function(e){
                e.preventDefault();
                var target = $(this).attr('href');

                $('.btnList').addClass('btn-outline');
                $('.btnList').text('Lihat Data');
                $(this).removeClass('btn-outline');
                $(this).text('Terpilih');

                $('.infra-list').addClass('hidden');
                $(target).removeClass('hidden');

                // setTimeout(function(){
                //     $('body, html').animate({
                //         'scrollTop' : ($(target).offset().top-100)+'px'
                //     }, 500);
                // }, 100);
                if(!$('#map-kel').hasClass('leaflet-container')){
                    initMapKelurahan();
                }
            });

            initMapKecamatan();
        });

        function initMapKecamatan(){
            var map = L.map('map-kec').setView([-1.938866507948674, 117.71236419677734], 5);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution:'Map data © <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY- SA</a>',
                maxZoom: 18
            }).addTo(map);

            let specialMarker = L.marker([-6.938866507948674, 107.71236419677734], {
                draggable:true,
            }).addTo(map);

            specialMarker.on('dragend', function(e){
                var chagedPos = e.target.getLatLng();
                this.bindPopup(chagedPos.toString()).openPopup();
            })
            var group1 = L.markerClusterGroup();

            group1.addLayer(L.marker([-6.938866507948674, 107.71236419677734]).bindPopup('<b>Kecamatan Bojongsoang</b><br /><a href="{{ url('/infrastruktur-data/kecamatan/1') }}">Lihat detail</a>'));
            group1.addLayer(L.marker([-6.938866507948673, 107.71436419677735]).bindPopup('<b>Kecamatan Cibiru</b><br /><a href="{{ url('/infrastruktur-data/kecamatan/1') }}">Lihat detail</a>'));
            group1.addLayer(L.marker([1.515936, 109.665527]).bindPopup('<b>Kecamatan Rancaekek</b><br /><a href="{{ url('/infrastruktur-data/kecamatan/1') }}">Lihat detail</a>'));
            group1.addLayer(L.marker([0.928304, 111.088257]).bindPopup('<b>Kecamatan Jakarta</b><br /><a href="{{ url('/infrastruktur-data/kecamatan/1') }}">Lihat detail</a>'));
            group1.addLayer(L.marker([0.911827, 110.34668]).bindPopup('<b>Kecamatan Solokan Jeruk</b><br /><a href="{{ url('/infrastruktur-data/kecamatan/1') }}">Lihat detail</a>'));
            group1.addLayer(L.marker([4.793631, 108.020089]).bindPopup('<b>Kecamatan Hani Mun</b><br /><a href="{{ url('/infrastruktur-data/kecamatan/1') }}">Lihat detail</a>'));
            map.addLayer(group1);

            var osmGeocoder = new L.Control.OSMGeocoder();
            map.addControl(osmGeocoder);

            //disable default scroll
            map.scrollWheelZoom.disable();

            $("#map-kec").bind('mousewheel DOMMouseScroll', function (event) {
                event.stopPropagation();
                if (event.ctrlKey == true) {
                    event.preventDefault();
                    map.scrollWheelZoom.enable();
                    $('#map-kec').removeClass('map-scroll');
                    setTimeout(function(){
                        map.scrollWheelZoom.disable();
                    }, 1000);
                } else {
                    map.scrollWheelZoom.disable();
                    $('#map-kec').addClass('map-scroll');
                }

            });

            $(window).bind('mousewheel DOMMouseScroll', function (event) {
                $('#map-kec').removeClass('map-scroll');
            })
        }

        function initMapKelurahan(){
            var map = L.map('map-kel').setView([-1.938866507948674, 117.71236419677734], 5);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution:'Map data © <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY- SA</a>',
                maxZoom: 18
            }).addTo(map);

            let specialMarker = L.marker([-6.938866507948674, 107.71236419677734], {
                draggable:true,
            }).addTo(map);

            specialMarker.on('dragend', function(e){
                var chagedPos = e.target.getLatLng();
                this.bindPopup(chagedPos.toString()).openPopup();
            })
            var group1 = L.markerClusterGroup();

            group1.addLayer(L.marker([-6.938866507948674, 107.71236419677734]).bindPopup('<b>Desa Buahbatu</b><br /><a href="{{ url('/infrastruktur-data/kecamatan/1') }}">Lihat detail</a>'));
            group1.addLayer(L.marker([-6.938866507948673, 107.71436419677735]).bindPopup('<b>Kelurahan Kiaracondong</b><br /><a href="{{ url('/infrastruktur-data/kecamatan/1') }}">Lihat detail</a>'));
            group1.addLayer(L.marker([1.515936, 109.665527]).bindPopup('<b>Kelurahan Bojong Koneng</b><br /><a href="{{ url('/infrastruktur-data/kecamatan/1') }}">Lihat detail</a>'));
            group1.addLayer(L.marker([0.928304, 111.088257]).bindPopup('<b>Kelurahan Lingkar Nagreg</b><br /><a href="{{ url('/infrastruktur-data/kecamatan/1') }}">Lihat detail</a>'));
            group1.addLayer(L.marker([0.911827, 110.34668]).bindPopup('<b>Desa Banjaran</b><br /><a href="{{ url('/infrastruktur-data/kecamatan/1') }}">Lihat detail</a>'));
            group1.addLayer(L.marker([4.793631, 108.020089]).bindPopup('<b>Desa Majalaya</b><br /><a href="{{ url('/infrastruktur-data/kecamatan/1') }}">Lihat detail</a>'));
            map.addLayer(group1);

            var osmGeocoder = new L.Control.OSMGeocoder();
            map.addControl(osmGeocoder);

            //disable default scroll
            map.scrollWheelZoom.disable();

            $("#map-kel").bind('mousewheel DOMMouseScroll', function (event) {
                event.stopPropagation();
                if (event.ctrlKey == true) {
                    event.preventDefault();
                    map.scrollWheelZoom.enable();
                    $('#map-kel').removeClass('map-scroll');
                    setTimeout(function(){
                        map.scrollWheelZoom.disable();
                    }, 1000);
                } else {
                    map.scrollWheelZoom.disable();
                    $('#map-kel').addClass('map-scroll');
                }

            });

            $(window).bind('mousewheel DOMMouseScroll', function (event) {
                $('#map-kel').removeClass('map-scroll');
            })
        }
    </script>
@endpush
