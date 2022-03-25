@extends('front.layout.main')

@section('title', '| Berita')

@push('styles')
@endpush

@section('content')
    <!--section -->
    <section class="parallax-section" data-scrollax-parent="true">
        <div class="bg par-elem"  data-bg="{{asset('assets/front')}}/images/bg/map-static.png" data-scrollax="properties: { translateY: '30%' }"></div>
        <div class="overlay"></div>
        <div class="container">
            <div class="section-title center-align">
                <h2><span>{{ $berita->judul }}</span></h2>
                <div class="breadcrumbs fl-wrap"><a href="{{ route('home') }}">Beranda</a><a href="{{ route('berita.index') }}">Berita</a><span>{{ $berita->judul }}</span></div>
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
                    <div class="list-single-main-wrapper fl-wrap" id="sec2">
                        <!-- article> -->
                        <article>
{{--                            <div class="list-single-main-media fl-wrap">--}}
{{--                                <div class="single-slider-wrapper fl-wrap">--}}
{{--                                    <div class="single-slider fl-wrap"  >--}}
{{--                                        <div class="slick-slide-item"><img src="{{asset('upload/content/'.$berita->poster)}}" alt=""></div>--}}
{{--                                        <div class="slick-slide-item"><img src="{{asset('assets/static-image')}}/download.jpg" alt=""></div>--}}
{{--                                    </div>--}}
{{--                                    <div class="swiper-button-prev sw-btn"><i class="fa fa-long-arrow-left"></i></div>--}}
{{--                                    <div class="swiper-button-next sw-btn"><i class="fa fa-long-arrow-right"></i></div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
                            <div class="list-single-main-media fl-wrap">
                                <a href="{{ url('/berita/'.$berita->slug) }}"><img src="{{asset('upload/content/'.$berita->slug.'/'.$berita->poster)}}" alt=""></a>
                            </div>
                            <div class="list-single-main-item fl-wrap">
                                <div class="list-single-main-item-title fl-wrap">
                                    <h3>{{ $berita->judul }}</h3>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        {!! $berita->content !!}
                                    </div>
                                </div>
                                <div class="post-opt">
                                    <ul>
                                        <li><i class="fa fa-calendar-check-o"></i> <span>{{ date('d M Y @ H:i', strtotime($berita->created_at)) }}</span></li>
                                        <li><i class="fa fa-tags"></i> <a href="{{ url('/berita?kategori='.$berita->idkategori) }}">{{ @$berita->kategori->nama ?? '-' }}</a> </li>
                                    </ul>
                                </div>
{{--                                <span class="fw-separator"></span>--}}
{{--                                <div class="list-single-main-item-title fl-wrap">--}}
{{--                                    <h3>Kata Kunci</h3>--}}
{{--                                </div>--}}
{{--                                <div class="list-single-tags tags-stylwrap blog-tags">--}}
{{--                                    <a href="{{ url('/berita') }}">COVID-19</a>--}}
{{--                                    <a href="{{ url('/berita') }}">Joko Widowo</a>--}}
{{--                                    <a href="{{ url('/berita') }}">Daya Beli</a>--}}
{{--                                </div>--}}
{{--                                <div class="share-holder hid-share">--}}
{{--                                    <div class="showshare"><span>Share </span><i class="fa fa-share"></i></div>--}}
{{--                                    <div class="share-container  isShare"></div>--}}
{{--                                </div>--}}
                                <span class="fw-separator"></span>
                                <div class="post-nav fl-wrap">
                                    @if(@$beritaPrevious)
                                    <a href="{{ url('/berita/'.$beritaPrevious->slug) }}" class="post-link prev-post-link"><i class="fa fa-angle-left"></i>Sebelumnya <span class="clearfix">{{ $beritaPrevious->judul }}</span></a>
                                    @endif
                                    @if(@$beritaNext)
                                    <a href="{{ url('/berita/'.$beritaNext->slug) }}" class="post-link next-post-link"><i class="fa fa-angle-right"></i>Selanjutnya<span class="clearfix">{{ $beritaNext->judul }}</span></a>
                                    @endif
                                </div>
                            </div>
                        </article>
                        <!-- article end -->
{{--                        <span class="section-separator"></span>--}}
{{--                        <!-- list-single-main-item -->--}}
{{--                        <div class="list-single-main-item fl-wrap" id="sec4">--}}
{{--                            <div class="list-single-main-item-title fl-wrap">--}}
{{--                                <h3>Comments -  <span> 3 </span></h3>--}}
{{--                            </div>--}}
{{--                            <div class="reviews-comments-wrap">--}}
{{--                                <!-- reviews-comments-item -->--}}
{{--                                <div class="reviews-comments-item">--}}
{{--                                    <div class="review-comments-avatar">--}}
{{--                                        <img src="{{ asset('assets/front') }}/images/avatar/1.jpg" alt="">--}}
{{--                                    </div>--}}
{{--                                    <div class="reviews-comments-item-text">--}}
{{--                                        <a href="#" class="new-dashboard-item">Reply</a>--}}
{{--                                        <h4><a href="#">Jessie Manrty</a></h4>--}}
{{--                                        <div class="clearfix"></div>--}}
{{--                                        <p>" Commodo est luctus eget. Proin in nunc laoreet justo volutpat blandit enim. Sem felis, ullamcorper vel aliquam non, varius eget justo. Duis quis nunc tellus sollicitudin mauris. "</p>--}}
{{--                                        <span class="reviews-comments-item-date"><i class="fa fa-calendar-check-o"></i>27 May 2018</span>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <!--reviews-comments-item end-->--}}
{{--                                <!-- reviews-comments-item -->--}}
{{--                                <div class="reviews-comments-item reply-comment-item ">--}}
{{--                                    <div class="review-comments-avatar">--}}
{{--                                        <img src="{{ asset('assets/front') }}/images/avatar/1.jpg" alt="">--}}
{{--                                    </div>--}}
{{--                                    <div class="reviews-comments-item-text">--}}
{{--                                        <a href="#" class="new-dashboard-item">Reply</a>--}}
{{--                                        <h4><a href="#">Mark Rose</a></h4>--}}
{{--                                        <div class="clearfix"></div>--}}
{{--                                        <p>" Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. "</p>--}}
{{--                                        <span class="reviews-comments-item-date"><i class="fa fa-calendar-check-o"></i>12 April 2018</span>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <!--reviews-comments-item end-->--}}
{{--                                <!-- reviews-comments-item -->--}}
{{--                                <div class="reviews-comments-item">--}}
{{--                                    <div class="review-comments-avatar">--}}
{{--                                        <img src="{{ asset('assets/front') }}/images/avatar/1.jpg" alt="">--}}
{{--                                    </div>--}}
{{--                                    <div class="reviews-comments-item-text">--}}
{{--                                        <a href="#" class="new-dashboard-item">Reply</a>--}}
{{--                                        <h4><a href="#">Adam Koncy</a></h4>--}}
{{--                                        <div class="clearfix"></div>--}}
{{--                                        <p>" Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc posuere convallis purus non cursus. Cras metus neque, gravida sodales massa ut. "</p>--}}
{{--                                        <span class="reviews-comments-item-date"><i class="fa fa-calendar-check-o"></i>03 December 2017</span>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <!--reviews-comments-item end-->--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <!-- list-single-main-item end -->--}}
{{--                        <!-- list-single-main-item -->--}}
{{--                        <div class="list-single-main-item fl-wrap" id="sec5">--}}
{{--                            <div class="list-single-main-item-title fl-wrap">--}}
{{--                                <h3>Add Comment</h3>--}}
{{--                            </div>--}}
{{--                            <!-- Add Review Box -->--}}
{{--                            <div id="add-review" class="add-review-box">--}}
{{--                                <!-- Review Comment -->--}}
{{--                                <form id="add-comment" class="add-comment custom-form">--}}
{{--                                    <fieldset>--}}
{{--                                        <div class="row">--}}
{{--                                            <div class="col-md-6">--}}
{{--                                                <label><i class="fa fa-user-o"></i></label>--}}
{{--                                                <input type="text" placeholder="Your Name *" value=""/>--}}
{{--                                            </div>--}}
{{--                                            <div class="col-md-6">--}}
{{--                                                <label><i class="fa fa-envelope-o"></i>  </label>--}}
{{--                                                <input type="text" placeholder="Email Address*" value=""/>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <textarea cols="40" rows="3" placeholder="Your Review:"></textarea>--}}
{{--                                    </fieldset>--}}
{{--                                    <button class="btn  big-btn  color-bg flat-btn">Submit Comment <i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>--}}
{{--                                </form>--}}
{{--                            </div>--}}
{{--                            <!-- Add Review Box / End -->--}}
{{--                        </div>--}}
{{--                        <!-- list-single-main-item end -->--}}
                    </div>
                </div>
                <!--box-widget-wrap -->
                <div class="col-md-4">
                    @include('front.berita.sidebar')
                </div>
                <!--box-widget-wrap end -->
            </div>
        </div>
    </section>
    <!--section end -->
@endsection

@push('scripts')
@endpush
