@extends('front.layout.main')

@section('title', '| Beranda')

@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.css" integrity="sha512-/zs32ZEJh+/EO2N1b0PEdoA10JkdC3zJ8L5FTiQu82LR9S/rOQNfQN7U59U9BC12swNeRAz3HSzIL2vpp4fv3w==" crossorigin="anonymous" />
@endpush

@push('styles')
<style>
    .geodir-category-img > img{
        height: 200px !important;
        object-fit: cover;
    }
    .process-item{
        height: 350px !important;
    }
    .geodir-category-content a{
        text-transform: capitalize;
    }
    .geodir-category-content p{
        text-transform: capitalize;
    }
    .process-wrap ul{
        display: flex;
        justify-content: center;
    }
    .single-facts .inline-facts-wrap {
        width: 20%;
    }
</style>
@endpush

@section('content')
    <!--section -->
    <section class="scroll-con-sec hero-section text-center" data-scrollax-parent="true" id="sec1">
        <div class="bg"  data-bg="{{asset('assets/front')}}/images/bg/map-static.png" data-scrollax="properties: { translateY: '200px' }"></div>
        <div class="overlay"></div>
        <div class="hero-section-wrap fl-wrap">
            <div class="container">
                <div class="intro-item fl-wrap">
                    <h2>Data Sarana & Prasarana <br> Infrastruktur Pemerintahan Kawasan Perbatasan</h2>
                    <h3>BNPP | Badan Nasional Pengelola Perbatasan</h3>
                </div>
            </div>
        </div>
        <div class="bubble-bg"> </div>
        <div class="header-sec-link">
            <div class="container"><a href="#sec2" class="custom-scroll-link">Baca Selengkapnya</a></div>
        </div>
    </section>
    <!-- section end -->
    <!--section -->
    <section id="sec2">
        <div class="container">
            <div class="section-title">
                <h2>Berita Terbaru</h2>
                <div class="section-subtitle">Katalog Berita</div>
                <span class="section-separator"></span>
                <p>Explore some of the best tips from around the city from our partners and friends.</p>
            </div>
            @if($berita->count() == 0)
            <div class="empty-container">
                <img src="{{ asset('assets/front/images/empty.png') }}">
                <h3>Tidak ada data berita</h3>
            </div>
            @else
            <!-- portfolio start -->
            <div class="gallery-items fl-wrap mr-bot spad">
                @foreach($berita as $key => $row)
                <!-- gallery-item-->
                <div class="gallery-item {{ $key == 1 ? 'gallery-item-second' : null }}">
                    <div class="grid-item-holder">
                        <div class="listing-item-grid">
                            <div class="bg" data-bg="{{asset('upload/content/'.$row->slug.'/'.$row->poster)}}"></div>
                            <div class="listing-counter">{{ date('d M Y', strtotime($row->created_at)) }}</div>
                            <div class="listing-item-cat">
                                <h3><a href="{{ url('/berita/'.$row->slug) }}">{{ @$row->judul ?? '-'  }}</a></h3>
                                <p>{{ \Illuminate\Support\Str::limit(strip_tags($row->content), 100, ' ...') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- gallery-item end-->
                @endforeach

            </div>
            <!-- portfolio end -->
            @endif
            <a href="{{url('berita')}}" class="btn  big-btn circle-btn dec-btn  color-bg flat-btn">Lihat Semua <i class="fa fa-eye"></i></a>
        </div>
    </section>
    <!-- section end -->

    <section class="color-bg">
        <div class="shapes-bg-big"></div>
        <div class="container">
            <div class=" single-facts fl-wrap">
                <!-- inline-facts -->
                <div class="inline-facts-wrap">
                    <div class="inline-facts">
                        <div class="milestone-counter">
                            <div class="stats animaper">
                                <div class="num" data-content="0" data-num="{{ $count['provinsi'] }}">{{ $count['provinsi'] }}</div>
                            </div>
                        </div>
                        <h6>Provinsi</h6>
                    </div>
                </div>
                <!-- inline-facts end -->
                <!-- inline-facts  -->
                <div class="inline-facts-wrap">
                    <div class="inline-facts">
                        <div class="milestone-counter">
                            <div class="stats animaper">
                                <div class="num" data-content="0" data-num="{{ $count['kota'] }}">{{ $count['kota'] }}</div>
                            </div>
                        </div>
                        <h6>Kota</h6>
                    </div>
                </div>
                <!-- inline-facts end -->
                <!-- inline-facts  -->
                <div class="inline-facts-wrap">
                    <div class="inline-facts">
                        <div class="milestone-counter">
                            <div class="stats animaper">
                                <div class="num" data-content="0" data-num="{{ $count['kecamatan'] }}">{{ $count['kecamatan'] }}</div>
                            </div>
                        </div>
                        <h6>Kecamatan</h6>
                    </div>
                </div>
                <!-- inline-facts end -->
                <!-- inline-facts  -->
                <div class="inline-facts-wrap">
                    <div class="inline-facts">
                        <div class="milestone-counter">
                            <div class="stats animaper">
                                <div class="num" data-content="0" data-num="{{ $count['desa'] }}">{{ $count['desa'] }}</div>
                            </div>
                        </div>
                        <h6>Desa</h6>
                    </div>
                </div>
                <!-- inline-facts end -->
                <!-- inline-facts  -->
                <div class="inline-facts-wrap">
                    <div class="inline-facts">
                        <div class="milestone-counter">
                            <div class="stats animaper">
                                <div class="num" data-content="0" data-num="{{ $count['lokpri'] }}">{{ $count['lokpri'] }}</div>
                            </div>
                        </div>
                        <h6>Lokpri</h6>
                    </div>
                </div>
                <!-- inline-facts end -->
            </div>
        </div>
    </section>
    <!-- section end -->


    <!--section -->
    <section class="gray-section">
        <div class="container">
            <div class="section-title">
                <h2>Daftar Kecamatan</h2>
                <div class="section-subtitle">Daftar Kecamatan</div>
                <span class="section-separator"></span>
                <p>Pembangunan Infrastruktur Kecamatan Perbatasan</p>
            </div>
        </div>
        @if($kecamatan->count() == 0)
        <div class="empty-container">
            <img src="{{ asset('assets/front/images/empty.png') }}">
            <h3>Tidak ada data kecamatan</h3>
        </div>
        @else
        <!-- carousel -->
        <div class="list-carousel fl-wrap card-listing mb-5">
            <!--listing-carousel-->
            <div class="listing-carousel  fl-wrap ">
                @foreach($kecamatan as $row)
                <!--slick-slide-item-->
                <div class="slick-slide-item">
                    <!-- listing-item -->
                    <div class="listing-item">
                        <article class="geodir-category-listing fl-wrap">
                            <div class="geodir-category-img">
                                <img src="{{ (!empty($row->detail->camat->foto_kantor)) ? asset('upload/camat/kantor').'/'.$row->detail->camat->foto_kantor : asset('assets/front/images/kecamatan.jpg') }}" onerror="this.src='{{ asset('assets/front/images/broken.jpg') }}'" alt="">
                                <div class="overlay"></div>
                            </div>
                            <div class="geodir-category-content fl-wrap">
                                <h3><a href="{{url('infrastruktur-data/kecamatan/'.$row->id)}}">Kecamatan {{ strtolower($row->name) }}</a></h3>
                                <p>{{ @strtolower($row->kota->name) }}, {{ @strtolower($row->kota->provinsi->name) }}</p>
                            </div>
                        </article>
                    </div>
                    <!-- listing-item end-->
                </div>
                <!--slick-slide-item end-->
                @endforeach
            </div>
            <!--listing-carousel end-->
            <div class="swiper-button-prev sw-btn"><i class="fa fa-long-arrow-left"></i></div>
            <div class="swiper-button-next sw-btn"><i class="fa fa-long-arrow-right"></i></div>
        </div>
        <!--  carousel end-->
        @endif
        <a href="{{url('infrastruktur-data')}}" class="btn  big-btn circle-btn dec-btn  color-bg flat-btn mt-5">Lihat Semua <i class="fa fa-eye"></i></a>
    </section>
    <!-- section end -->
    <!--section -->
    <section class="gray-section">
        <div class="container">
            <div class="section-title">
                <h2>Grafik Rekapitulasi Lokasi Prioritas</h2>
                <div class="section-subtitle">Grafik Lokpri</div>
                <span class="section-separator"></span>
            </div>
        </div>
        <!-- carousel -->
        <div class="container">
            <canvas id="chart-kec" style="width:100%; height:400px;"></canvas>
        </div>
        <!--  carousel end-->
        <a href="{{url('infrastruktur-data')}}" class="btn  big-btn circle-btn dec-btn  color-bg flat-btn mt-5">Lihat Semua <i class="fa fa-eye"></i></a>
    </section>
    <!-- section end -->
    <!--section -->
    <section class="gray-section">
        <div class="container">
            <div class="section-title">
                <h2>Daftar Desa</h2>
                <div class="section-subtitle">Daftar Desa</div>
                <span class="section-separator"></span>
                <p>Pembangunan Infrasturktur Desa Perbatasan</p>
            </div>
        </div>
        @if($desa->count() == 0)
        <div class="empty-container">
            <img src="{{ asset('assets/front/images/empty.png') }}">
            <h3>Tidak ada data desa</h3>
        </div>
        @else
        <!-- carousel -->
        <div class="list-carousel fl-wrap card-listing mb-5">
            <!--listing-carousel-->
            <div class="listing-carousel  fl-wrap ">
                @foreach($desa as $row)
                <!--slick-slide-item-->
                <div class="slick-slide-item">
                    <!-- listing-item -->
                    <div class="listing-item">
                        <article class="geodir-category-listing fl-wrap">
                            <div class="geodir-category-img">
                                <img src="{{ (!empty($row->detail->kades->foto_kantor)) ? asset('upload/desa/kantor').'/'.$row->detail->kades->foto_kantor : asset('assets/front/images/desa.jpg') }}" onerror="this.src='{{ asset('assets/front/images/broken.jpg') }}'" alt="">
                                <div class="overlay"></div>
                            </div>
                            <div class="geodir-category-content fl-wrap">
                                <h3><a href="{{url('infrastruktur-data/kelurahan/'.$row->id)}}">Desa {{ strtolower($row->name) }}</a></h3>
                                <p>{{ @strtolower($row->kecamatan->name) }}, {{ @strtolower($row->kecamatan->kota->name) }}, {{ @strtolower($row->kecamatan->kota->provinsi->name) }}</p>
                            </div>
                        </article>
                    </div>
                    <!-- listing-item end-->
                </div>
                <!--slick-slide-item end-->
                @endforeach
            </div>
            <!--listing-carousel end-->
            <div class="swiper-button-prev sw-btn"><i class="fa fa-long-arrow-left"></i></div>
            <div class="swiper-button-next sw-btn"><i class="fa fa-long-arrow-right"></i></div>
        </div>
        <!--  carousel end-->
        @endif
        <a href="{{url('infrastruktur-data')}}" class="btn  big-btn circle-btn dec-btn  color-bg flat-btn mt-5">Lihat Semua <i class="fa fa-eye"></i></a>
    </section>
    <!-- section end -->

    <!--section -->
    <section>
        <div class="container">
            <div class="section-title">
                <h2>Download Dokumen</h2>
                <div class="section-subtitle">Download Dokumen</div>
                <span class="section-separator"></span>
                <p>Download dokumen - dokumen yang dapat di download secara publik</p>
            </div>
            @if($dokumen->count() == 0)
            <div class="empty-container">
                <img src="{{ asset('assets/front/images/empty.png') }}">
                <h3>Tidak ada dokumen</h3>
            </div>
            @else
            <!--process-wrap  -->
            <div class="process-wrap fl-wrap mb-3">
                <ul>
                    @foreach($dokumen as $key => $row)
                    <li>
                        <div class="process-item">
                            {{-- <span class="process-count">01 . </span> --}}
                            <?php
                                $fileName = $row->file;
                                $fileArr = explode('.', $fileName);
                                $ext = strtolower(end($fileArr));
                                $ext = @$fileExt[$ext] ? $fileExt[$ext].'-o' : 'o';
                            ?>
                            <div class="time-line-icon"><i class="fa fa-file-{{ $ext }}"></i></div>
                            <h4>{{ $row->file }}</h4>
                            <p>{{ $row->nama }}</p>
                            <br>
                            <a href="{{asset('upload/dokumen/'.$row->file)}}" download class="btn btn-info btnList text-white">Download</a>
                        </div>
                        @if(($key+1) != $dokumen->count())
                        <span class="pr-dec"></span>
                        @endif
                    </li>
                    @endforeach
                </ul>
            </div>
            <!--process-wrap   end-->
            @endif
            <a href="{{url('download-dokumen')}}" class="btn  big-btn circle-btn dec-btn  color-bg flat-btn">Lihat Semua <i class="fa fa-eye"></i></a>
        </div>
    </section>
@endsection

@push('scripts')
{{-- <script src="https://cdn.jsdelivr.net/npm/echarts@4.9.0/dist/echarts.min.js"></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js" integrity="sha512-d9xgZrVZpmmQlfonhQUvTR7lMPtO7NkZMkA0ABN3PHCbKA5nqylQ/yWlFAyY6hYgdF1Qh6nYiuADWwKB4C2WSw==" crossorigin="anonymous"></script>
<script>
    $(document).ready(function(){
        initGrafikKecamatan();
    })
    function initGrafikKecamatan(){
        var chartLokrpi;
        console.log('exec');
        $.getJSON('{{route('home.grafik')}}', res=>{
            if(res){
                chartLokrpi = new Chart('chart-kec', {
                    type: 'bar',
                    data: {
                        labels: res.data.label,
                        datasets: [
                            {
                                label: 'Lokpri',
                                data: res.data.lokpri,
                                backgroundColor: 'rgba(247, 55, 55, 0.8)',
                                borderColor: 'rgba(247, 55, 55, 1)',
                                borderWidth: 1
                            },
                            {
                                label: 'PKSN',
                                data: res.data.pksn,
                                backgroundColor: 'rgba(158, 247, 45, 0.8)',
                                borderColor: 'rgba(158, 247, 45, 1)',
                                borderWidth: 1
                            },
                            {
                                label: 'PPKT',
                                data: res.data.ppkt,
                                backgroundColor: 'rgba(247, 186, 45, 0.8)',
                                borderColor: 'rgba(247, 186, 45, 1)',
                                borderWidth: 1
                            }
                        ]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        }
                    }
                });
            }
        });
    }
</script>
@endpush
