@extends('front.layout.main')

@section('title', '| Maksud dan Tujuan')

@push('styles')
    <style>
        .about-wrap h3{
            color: #334e6f;
            text-align: left;
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 16px;
        }
        .static-content{
            font-family: Quicksand, sans-serif !important;
        }
        .static-content p{
            font-family: Quicksand, sans-serif !important;
            margin: 0 !important;
            font-size: 13px !important;
            color: #878C9F;
        }
        .static-content p b{
            color: #334e6f !important;
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
                <h2><span>Maksud dan Tujuan</span></h2>
                <div class="breadcrumbs fl-wrap"><a href="{{ route('home') }}">Beranda</a><span>Maksud dan Tujuan</span></div>
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
                <h2>Maksud dan Tujuan</h2>
                <div class="section-subtitle">deskripsi maksud dan tujuan</div>
                <span class="section-separator"></span>
                <p>Berikut ini adalah Maksud dan Tujuan berdirinya portal lembaga Badan Nasional Pengelola Perbatasan (BNPP)</p>
            </div>
            <!--about-wrap -->
            <div class="about-wrap">
                <div class="row">
                    <div class="col-md-12 static-content">
                        <h3>Maksud</h3>
                        {!! $static_content->maksud !!}
                    </div>
                </div>
                <span class="fw-separator"></span>
                <div class="row">
                    <div class="col-md-12 static-content">
                        <h3>Tujuan</h3>
                        {!! $static_content->tujuan !!}
                    </div>
                </div>
            </div>
{{--            <!-- about-wrap end  -->--}}
{{--            <span class="fw-separator"></span>--}}
{{--            <!-- features-box-container -->--}}
{{--            <div class="features-box-container fl-wrap row">--}}
{{--                <!--features-box -->--}}
{{--                <div class="features-box col-md-4">--}}
{{--                    <div class="time-line-icon">--}}
{{--                        <i class="fa fa-medkit"></i>--}}
{{--                    </div>--}}
{{--                    <h3>24 Hours Support</h3>--}}
{{--                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas in pulvinar neque. Nulla finibus lobortis pulvinar. Donec a consectetur nulla.  </p>--}}
{{--                </div>--}}
{{--                <!-- features-box end  -->--}}
{{--                <!--features-box -->--}}
{{--                <div class="features-box col-md-4">--}}
{{--                    <div class="time-line-icon">--}}
{{--                        <i class="fa fa-cogs"></i>--}}
{{--                    </div>--}}
{{--                    <h3>Admin Panel</h3>--}}
{{--                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas in pulvinar neque. Nulla finibus lobortis pulvinar. Donec a consectetur nulla.  </p>--}}
{{--                </div>--}}
{{--                <!-- features-box end  -->--}}
{{--                <!--features-box -->--}}
{{--                <div class="features-box col-md-4">--}}
{{--                    <div class="time-line-icon">--}}
{{--                        <i class="fa fa-television"></i>--}}
{{--                    </div>--}}
{{--                    <h3>Mobile Friendly</h3>--}}
{{--                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas in pulvinar neque. Nulla finibus lobortis pulvinar. Donec a consectetur nulla.  </p>--}}
{{--                </div>--}}
{{--                <!-- features-box end  -->--}}
{{--            </div>--}}
{{--            <!-- features-box-container end  -->--}}
        </div>
    </section>
    <!-- section end -->
@endsection

@push('scripts')
@endpush
