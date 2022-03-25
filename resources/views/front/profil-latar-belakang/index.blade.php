@extends('front.layout.main')

@section('title', '| Latar Belakang')

@push('styles')
    <style>
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
        .static-content span{
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
                <h2><span>Latar Belakang</span></h2>
                <div class="breadcrumbs fl-wrap"><a href="{{ route('home') }}">Beranda</a><span>Latar Belakang</span></div>
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
                <h2>Latar Belakang</h2>
                <div class="section-subtitle">deskripsi latar belakang</div>
                <span class="section-separator"></span>
                <p>Berikut ini adalah Latar Belakang berdirinya portal lembaga Badan Nasional Pengelola Perbatasan (BNPP)</p>
            </div>
            <!--about-wrap -->
            <div class="about-wrap">
                <div class="row">
                    <div class="col-md-12 static-content">
                        {!! $static_content->latar_belakang !!}
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
