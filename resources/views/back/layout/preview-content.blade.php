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
        <link type="text/css" rel="stylesheet" href="{{asset('assets/front')}}/css/style.css">
        <link type="text/css" rel="stylesheet" href="{{asset('assets/front')}}/css/color.css">
        <link type="text/css" rel="stylesheet" href="{{asset('assets/front')}}/css/custom.css">
        <!--=============== favicons ===============-->
        <link rel="shortcut icon" type="image/png" href="{{ asset('/assets/front') }}/images/logo-bnpp.png">

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
            {{-- @include('front.layout.header') --}}
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
            {{-- @include('front.layout.footer') --}}
            <!--footer end  -->
            <!--register form -->
            {{-- <div class="main-register-wrap modal">
                <div class="main-overlay"></div>
                <div class="main-register-holder">
                    <div class="main-register fl-wrap">
                        <div class="close-reg"><i class="fa fa-times"></i></div>
                        <h3>Masuk ke <span><strong>BNPP</strong></span></h3>
                        <div id="tabs-container"> --}}
{{--                            <ul class="tabs-menu">--}}
{{--                                <li class="current"><a href="#tab-1">Masuk</a></li>--}}
{{--                                <li><a href="#tab-2">Register</a></li>--}}
{{--                            </ul>--}}
                            {{-- <div class="tab">
                                <div id="tab-1" class="tab-content">
                                    <div class="custom-form">
                                        <form method="post"  name="registerform">
                                            <label>Username <span class="text-danger">*</span> </label>
                                            <input name="email" type="text" onClick="this.select()" value="" required>
                                            <label >Password <span class="text-danger">*</span> </label>
                                            <input name="password" type="password" onClick="this.select()" value="" required>
                                            <button type="submit"  class="log-submit-btn"><span>Log In</span></button>
                                            <div class="clearfix"></div> --}}
{{--                                            <div class="filter-tags">--}}
{{--                                                <input id="check-a" type="checkbox" name="check">--}}
{{--                                                <label for="check-a">Remember me</label>--}}
{{--                                            </div>--}}
                                        {{-- </form>
                                        <div class="lost_password">
                                            <a href="#">Lupa Password?</a>
                                        </div>
                                    </div>
                                </div> --}}
{{--                                <div class="tab">--}}
{{--                                    <div id="tab-2" class="tab-content">--}}
{{--                                        <div class="custom-form">--}}
{{--                                            <form method="post"   name="registerform" class="main-register-form" id="main-register-form2">--}}
{{--                                                <label >First Name * </label>--}}
{{--                                                <input name="name" type="text"   onClick="this.select()" value="">--}}
{{--                                                <label>Second Name *</label>--}}
{{--                                                <input name="name2" type="text"  onClick="this.select()" value="">--}}
{{--                                                <label>Email Address *</label>--}}
{{--                                                <input name="email" type="text"  onClick="this.select()" value="">--}}
{{--                                                <label >Password *</label>--}}
{{--                                                <input name="password" type="password"   onClick="this.select()" value="" >--}}
{{--                                                <button type="submit"     class="log-submit-btn"  ><span>Register</span></button>--}}
{{--                                            </form>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--register form end -->
            <a class="to-top"><i class="fa fa-angle-up"></i></a>
        </div>
        <!-- Main end -->
        <!--=============== scripts  ===============-->
        <script type="text/javascript" src="{{asset('assets/front')}}/js/jquery.min.js"></script>
        <script type="text/javascript" src="{{asset('assets/vendor')}}/bootstraps/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="{{asset('assets/front')}}/js/plugins.js"></script>
        <script type="text/javascript" src="{{asset('assets/front')}}/js/scripts.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
        {{-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDwJSRi0zFjDemECmFl9JtRj1FY7TiTRRo&libraries=places&callback=initAutocomplete"></script> --}}
        <script>
            $(document).ready(function(){
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
