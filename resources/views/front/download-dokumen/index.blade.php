@extends('front.layout.main')

@section('title', '| Download Dokumen')

@push('styles')
    <style>
        .time-line-icon {
            position: relative;
            width: 70px;
            height: 70px;
            display: inline-block;
            margin-bottom: 0;
        }

        .time-line-icon i{
            font-size: 40px;
            color: #4DB7FE;
        }
        .dashboard-listing-table-image {
            width: 15%;
        }
        .dashboard-listing-table-text {
            width: 85%;
        }

    </style>
@endpush

@section('content')
    <!--section -->
    <!--section -->
    <section class="parallax-section text-center" data-scrollax-parent="true">
        <div class="bg par-elem"  data-bg="{{asset('assets/front')}}/images/bg/download.jpg" data-scrollax="properties: { translateY: '70%' }"></div>
        <div class="overlay"></div>
        <div class="container">
            <div class="section-title center-align">
                <h2><span>Download Dokumen</span></h2>
                <div class="breadcrumbs fl-wrap"><a href="{{ route('home') }}">Beranda</a><span>Download Dokumen</span></div>
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
                <h2>Dokumen Download</h2>
                <div class="section-subtitle">Daftar Dokumen</div>
                <span class="section-separator"></span>
                <p>Berikut ini adalah daftar dokumen yang dapat Anda download.</p>
            </div>
            <div class="row mb-4">
                <div class="col-12 col-md-8 offset-md-2">
                    <form action="{{ url('download-dokumen') }}" method="get">
                        <div class="form-group">
                            <input class="form-control" placeholder="Cari dokumen... Tekan enter untuk mencari" name="cari" value="{{ @request()->cari }}">
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-8 offset-md-2">
                    @if(@request()->cari)
                        <h3 class="mb-3" style="font-size: 20px; color: #50596E">Menampilkan dokumen dengan nama <b>{{ @request()->cari }}</b>. Tampilkan <a href="{{ url('download-dokumen') }}" class="text-primary">semua</a></h3>
                    @endif

                    @if($dokumen->count() == 0)
                        <div class="empty-container">
                            <img src="{{ asset('assets/front/images/empty.png') }}">
                            <h3>{!! @request()->cari ? 'Dokumen tidak ditemukan. <a href="'.url('download-dokumen').'">Tampilkan semua</a>' : 'Tidak ada dokumen' !!}</h3>
                        </div>
                    @else
                    <div class="dashboard-list-box fl-wrap">
                        @foreach($dokumen as $row)
                        <!-- dashboard-list end-->
                        <div class="dashboard-list">
                            <div class="dashboard-message">
                                <div class="dashboard-listing-table-image">
                                    <div class="time-line-icon">
                                        <?php
                                        $fileName = $row->file;
                                        $fileArr = explode('.', $fileName);
                                        $ext = strtolower(end($fileArr));
                                        $ext = @$fileExt[$ext] ? $fileExt[$ext].'-o' : 'o';
                                        ?>
                                        <i class="fa fa-file-{{ $ext }}"></i>
                                    </div>
                                </div>
                                <div class="dashboard-listing-table-text">
                                    <div class="row">
                                        <div class="col">
                                            <h4 style="padding-bottom: 10px;">{{ $row->nama }}</h4>
                                            <span class="dashboard-listing-table-address p-0"><i class="fa fa-file"></i>{{ $row->kategori->keterangan }}</span>
                                        </div>
                                        <div class="col-auto align-self-center">
                                            <ul class="dashboard-listing-table-opt fl-wrap m-0">
                                                <li><a href="{{asset('upload/dokumen/'.$row->file)}}" download>Download <i class="fa fa-download"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- dashboard-list end-->
                        @endforeach
                    </div>
                    <!-- pagination-->

                    {!! $dokumen->links('vendor.pagination.bootstrap-4')  !!}
                    @endif
                </div>
            </div>
        </div>
    </section>
    <!-- section end -->
@endsection

@push('scripts')
@endpush
