@extends('front.layout.main')

@section('title', '| Grafik Infrastruktur Perbatasan')

@push('styles')
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">
    <style>
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
                <h2><span>Grafik Infrastruktur Perbatasan</span></h2>
                <div class="breadcrumbs fl-wrap"><a href="{{ route('home') }}">Beranda</a><span>Grafik Infrastruktur Perbatasan</span></div>
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
                <h2>Grafik</h2>
                <div class="section-subtitle">Infrastruktur Perbatasan</div>
                <span class="section-separator"></span>
                <p>Pilih grafik kawasan infrastruktur perbatasan yang akan ditampilkan</p>
            </div>

            <!-- features-box-container -->
            <div class="features-box-container fl-wrap row">
                <!--features-box -->
                <div class="features-box col-md-6">
                    <div class="time-line-icon">
                        <i class="fa fa-institution"></i>
                    </div>
                    <h3>Kecamatan</h3>
                    <p>Tampilkan grafik infrastuktur perbatasan kawasan Kecamatan</p>
                    <a href="#grafik-kecamatan" class="btn btn-success btnList">Terpilih</a>
                </div>
                <!-- features-box end  -->
                <!--features-box -->
                <div class="features-box col-md-6">
                    <div class="time-line-icon">
                        <i class="fa fa-home"></i>
                    </div>
                    <h3>Desa / Kelurahan</h3>
                    <p>Tampilkan grafik infrastuktur perbatasan kawasan Desa / Kelurahan</p>
                    <a href="#grafik-kelurahan" class="btn btn-success btn-outline btnList">Lihat Grafik</a>
                </div>
                <!-- features-box end  -->
            </div>
            <!-- features-box-container end  -->
        </div>
    </section>
    <!-- section end -->

    <!-- section -->
    @include('front.infrastruktur-grafik.grafik-kecamatan')

    <!-- section -->
    @include('front.infrastruktur-grafik.grafik-kelurahan')
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/echarts@4.9.0/dist/echarts.min.js"></script>
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

                if($('#chart-kel').find('canvas').length == 0){
                    initGrafikKelurahan();
                }

                setTimeout(function(){
                    $('body, html').animate({
                        'scrollTop' : ($(target).offset().top-100)+'px'
                    }, 500);
                }, 100);
            });

            initGrafikKecamatan();
        });

        function initGrafikKecamatan(){
            var myChart = echarts.init(document.getElementById('chart-kec'));

            option = {
                legend: {},
                tooltip: {},
                dataset: {
                    source: [
                        ['Aset', 'Baik', 'Rusak'],
                        ['Kursi', 25, 4],
                        ['Komputer', 7, 2],
                        ['Printer', 3, 1],
                        ['Meja', 15, 2]
                    ]
                },
                xAxis: {type: 'category'},
                yAxis: {},
                // Declare several bar series, each will be mapped
                // to a column of dataset.source by default.
                series: [
                    {type: 'bar'},
                    {type: 'bar'},
                ]
            };

            myChart.setOption(option);
        }

        function initGrafikKelurahan(){
            var myChart = echarts.init(document.getElementById('chart-kel'));

            option = {
                legend: {},
                tooltip: {},
                dataset: {
                    source: [
                        ['Aset', 'Baik', 'Rusak'],
                        ['Kursi', 25, 4],
                        ['Komputer', 7, 2],
                        ['Printer', 3, 1],
                        ['Meja', 15, 2]
                    ]
                },
                xAxis: {type: 'category'},
                yAxis: {},
                // Declare several bar series, each will be mapped
                // to a column of dataset.source by default.
                series: [
                    {type: 'bar'},
                    {type: 'bar'},
                ]
            };

            myChart.setOption(option);
        }
    </script>
@endpush
