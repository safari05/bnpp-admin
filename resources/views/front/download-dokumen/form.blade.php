@extends('front.layout.main')

@section('title', '| Pengajuan Dokumen')

@push('styles')
@endpush

@section('content')
    <!--section -->
    <!--section -->
    <section class="parallax-section text-center" data-scrollax-parent="true">
        <div class="bg par-elem"  data-bg="{{asset('assets/front')}}/images/bg/map-static.png" data-scrollax="properties: { translateY: '30%' }"></div>
        <div class="overlay"></div>
        <div class="container">
            <div class="section-title center-align">
                <h2><span>Pengajuan Dokumen</span></h2>
                <div class="breadcrumbs fl-wrap"><a href="{{ route('home') }}">Beranda</a><span>Pengajuan Dokumen</span></div>
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
                <h2>Pengajuan Dokumen</h2>
                <div class="section-subtitle">Melakukan Pengajuan</div>
                <span class="section-separator"></span>
                <p>Ajukan pengadaan dokumen untuk keperluan Anda </p>
            </div>
            <div class="row">
                <div class="col-12 col-md-8 offset-md-2">
                    <div class="list-single-main-wrapper fl-wrap" id="sec2">
                        <!-- list-single-main-item -->
                        <div class="list-single-main-item fl-wrap" id="sec5">
                            <!-- Add Review Box -->
                            <div id="add-review" class="add-review-box">
                                <!-- Review Comment -->
                                <form class="add-comment custom-form">
                                    <fieldset>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label><i class="fa fa-user-o"></i></label>
                                                <input type="text" placeholder="Nama Anda *" value="">
                                            </div>
                                            <div class="col-md-6">
                                                <label><i class="fa fa-envelope-o"></i>  </label>
                                                <input type="text" placeholder="Alamat Email *" value="">
                                            </div>
                                        </div>
                                        <textarea cols="40" rows="3" placeholder="Silahkan deskripsikan dokumen yang Anda ajukan..."></textarea>
                                    </fieldset>
                                    <button class="btn  big-btn  color-bg flat-btn">Kirim Pengajuan <i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>
                                </form>
                            </div>
                            <!-- Add Review Box / End -->
                        </div>
                        <!-- list-single-main-item end -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- section end -->
@endsection

@push('scripts')
@endpush
