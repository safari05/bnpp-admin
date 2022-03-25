@extends('front.layout.main')

@section('title', '| Berita')

@push('styles')
    <style>
        .gradient-bg, .listing-geodir-category, .list-single-header-cat a, .box-widget-item .list-single-tags a:hover, .nav-holder nav li a:before {
            color: #fff;
        }
    </style>
@endpush

@section('content')
    <!--section -->
    <section class="parallax-section" data-scrollax-parent="true">
        <div class="bg par-elem"  data-bg="{{asset('assets/front')}}/images/bg/news.jpg" data-scrollax="properties: { translateY: '0%' }"></div>
        <div class="overlay"></div>
        <div class="container">
            <div class="section-title center-align">
                <h2><span>Berita</span></h2>
                <div class="breadcrumbs fl-wrap"><a href="{{ route('home') }}">Beranda</a><span>Berita</span></div>
                <span class="section-separator"></span>
            </div>
        </div>
        <div class="header-sec-link">
            <div class="container"><a href="#sec1" class="custom-scroll-link">Baca Selengkapnya</a></div>
        </div>
    </section>
    <!-- section end -->
    <!--section -->
    <section class="gray-section" id="sec1">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    @if($berita->count() == 0)
                        <div class="empty-container">
                            <img src="{{ asset('assets/front/images/empty.png') }}">
                            <h3>{{ @request()->cari ? 'Berita tidak ditemukan' : 'Tidak ada berita' }}</h3>
                        </div>
                    @else
                    <div class="list-single-main-wrapper fl-wrap" id="sec2">
                        @foreach($berita as $key => $row)
                        <!-- article> -->
                        <article>
                            <div class="list-single-main-media fl-wrap">
                                <a href="{{ url('/berita/'.$row->slug) }}"><img src="{{asset('upload/content/'.$row->slug.'/'.$row->poster)}}" onerror="this.src='{{ asset('assets/front/images/broken.jpg') }}'" alt=""></a>
                            </div>
                            <div class="list-single-main-item fl-wrap">
                                <div class="list-single-main-item-title fl-wrap">
                                    <h3><a href="{{ url('/berita/'.$row->slug) }}">{{ @$row->judul ?? '-'  }}</a></h3>
                                </div>
                                <p>{{ \Illuminate\Support\Str::limit(strip_tags($row->content), 100, ' ...') }}</p>
                                <div class="post-opt">
                                    <ul>
                                        <li><i class="fa fa-calendar-check-o"></i> <span>{{ date('d M Y @ H:i', strtotime($row->created_at)) }}</span></li>
                                        <li><i class="fa fa-tags"></i> <a href="{{ url('/berita?kategori='.$row->idkategori) }}">{{ @$row->kategori->nama ?? '-' }}</a> </li>
                                    </ul>
                                </div>
{{--                                <span class="fw-separator"></span>--}}
{{--                                <div class="list-single-main-item-title fl-wrap">--}}
{{--                                    <h3>Kata Kunci</h3>--}}
{{--                                </div>--}}
{{--                                <div class="list-single-tags tags-stylwrap blog-tags">--}}
{{--                                    <a href="{{ url('/berita') }}">COVID-19</a>--}}
{{--                                    <a href="{{ url('/berita') }}">Joko Widodo</a>--}}
{{--                                    <a href="{{ url('/berita') }}">Daya Beli</a>--}}
{{--                                </div>--}}
                                <span class="fw-separator"></span>
                                <a href="{{ url('/berita/'.$row->slug) }}" class="btn transparent-btn float-btn">Selengkapnya<i class="fa fa-eye"></i></a>
                            </div>
                        </article>
                        <!-- article end -->

                        @if(($key+1) != $berita->count())
                            <span class="section-separator"></span>
                        @endif
                        @endforeach

                        {!! $berita->links('vendor.pagination.bootstrap-4')  !!}
                    </div>
                    @endif
                </div>

                <!--box-widget-wrap -->
                <div class="col-md-4">
                    @include('front.berita.sidebar')
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
@endpush
