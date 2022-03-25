<!DOCTYPE HTML>
<html lang="en">
    <head>
        <!--=============== basic  ===============-->
        <meta charset="UTF-8">
        <title>Badan Nasional Pengelola Perbatasan @yield('title', '| Portal')</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <meta name="robots" content="index, follow"/>
        <meta name="keywords" content=""/>
        <meta name="description" content=""/>
        <!--=============== css  ===============-->
        <link type="text/css" rel="stylesheet" href="{{asset('assets/vendor')}}/bootstraps/css/bootstrap.min.css">
        <link type="text/css" rel="stylesheet" href="{{asset('assets/front')}}/css/reset.css">
        <link type="text/css" rel="stylesheet" href="{{asset('assets/front')}}/css/plugins.css">
        @stack('css')
        <link type="text/css" rel="stylesheet" href="{{asset('assets/front')}}/css/style.css">
        <link type="text/css" rel="stylesheet" href="{{asset('assets/front')}}/css/color.css">
        <link type="text/css" rel="stylesheet" href="{{asset('assets/front')}}/css/custom.css">
        <!--=============== favicons ===============-->
        <link rel="shortcut icon" type="image/png" href="{{ asset('/assets/front') }}/images/logo-bnpp.png">
        <style>
            .row{                
                width: 100%;
                display: -webkit-box;
                display: -webkit-flex;
                display: -ms-flexbox;
            }
        </style>
        @stack('styles')
    </head>
    <body>
        <!--loader-->
        <div class="loader-wrap">
            <div class="pin"></div>
            <div class="pulse"></div>
        </div>
        <!--loader end-->
        <!-- Main  -->
        <div id="main">
            <!-- header-->
            @include('front.layout.header')
            <!--  header end -->
            <!--  wrapper  -->
            <div id="wrapper">
                <!-- Content-->
                <div class="content">
                    @yield('content')
                </div>
                <!-- Content end -->
            </div>
            <!-- wrapper end -->
            <!--footer -->
            @include('front.layout.footer')
            <!--footer end  -->
            <a class="to-top"><i class="fa fa-angle-up"></i></a>
        </div>
        <!-- Main end -->
        <!--=============== scripts  ===============-->
        <script type="text/javascript" src="{{asset('assets/front')}}/js/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
        <script type="text/javascript" src="{{asset('assets/vendor')}}/bootstraps/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="{{asset('assets/front')}}/js/plugins.js"></script>
        <script type="text/javascript" src="{{asset('assets/front')}}/js/scripts.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
        {{-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDwJSRi0zFjDemECmFl9JtRj1FY7TiTRRo&libraries=places&callback=initAutocomplete"></script> --}}
        <script>
            $(document).ready(function(){
                $('body').tooltip({selector: '[data-toggle="tooltip"]'});

                $('.custom-scroll-link').unbind('click');
                $('.custom-scroll-link').on('click', function(e){
                    e.preventDefault();

                    var section = $(this).attr('href');
                    $('body, html').animate({
                        'scrollTop' : ($(section).offset().top-50)+'px'
                    }, 500);
                });

                @if(@session('error'))
                    Swal.fire(
                        'Gagal!',
                        '{{ session('error') }}',
                        'warning'
                    );
                @endif

                @if(@session('info'))
                    Swal.fire(
                        'Berhasil!',
                        '{{ session('info') }}',
                        'success'
                    );
                @endif
            });
        </script>
        @stack('scripts')
    </body>
</html>
