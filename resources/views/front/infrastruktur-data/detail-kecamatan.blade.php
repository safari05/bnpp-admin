<!--  section  -->
<section class="parallax-section single-par list-single-section" data-scrollax-parent="true" id="sec1">
    <div class="bg par-elem" data-bg="{{@$camat->foto_kantor??asset('assets/front/images/kecamatan.jpg')}}" data-scrollax="properties: { translateY: '30%' }"></div>
    <div class="overlay"></div>
    <div class="bubble-bg"></div>
    <div class="list-single-header absolute-header fl-wrap">
        <div class="container">
            <div class="list-single-header-item">
                <div class="list-single-header-item-opt fl-wrap">
                    <div class="list-single-header-cat fl-wrap">
                        <a href="javascript:void(0);">Kecamatan</a>
                    </div>
                </div>
                <h2>KECAMATAN {{$kec->name}} <span> - {{$kec->kota->name.', '.$kec->kota->provinsi->name}}</span> </h2>
                <span class="section-separator"></span>
                <div class="clearfix"></div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="list-single-header-contacts fl-wrap">
                            <ul>
                                <li data-toggle="tooltip" data-placement="bottom" title="Lokasi Prioritas"><i class="fa fa-bullseye"></i><a href="javascript:void(0);">{{$tipelokpri['lokpri']}}</a></li>
                                <li data-toggle="tooltip" data-placement="bottom" title="Tipe Kecamatan"><i class="fa fa-book"></i><a href="javascript:void(0);">{{$tipelokpri['tipe']}}</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--  section end -->
<div class="scroll-nav-wrapper fl-wrap">
    <div class="container">
        <nav class="scroll-nav scroll-init">
            <ul>
                <li><a class="act-scrlink" href="#sarpras">Kondisi Sarana Prasarana Kecamatan</a></li>
                <li><a href="#sarpras-aset">Daftar Aset</a></li>
                <li><a href="#sarpras-mobilitas">Sarana Mobilitas</a></li>
                <li><a href="#daftar-ppkt">Daftar PPKT</a></li>
                <li><a href="#daftar-penduduk">Daftar Penduduk (Umur)</a></li>
                <li><a href="#daftar-kepeg">Daftar Kepegawaian</a></li>
            </ul>
        </nav>
    </div>
</div>
<!--  section  -->
<section class="gray-section no-top-padding">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="list-single-main-wrapper fl-wrap" id="sarpras">
                    <div class="breadcrumbs gradient-bg fl-wrap"><a href="{{ route('home') }}">Beranda</a><a href="{{ url('/infrastruktur-data') }}">Data Infrastruktur Perbatasan</a><span>Detail</span></div>

                    <!-- list-single-main-item -->
                    <div class="list-single-main-item fl-wrap">
                        <div class="list-single-main-item-title fl-wrap m-0">
                            <h3>Kantor Kecamatan</h3>
                        </div>
                        @if(@$camat->status_kantor == 1)
                        <div class="list-single-main-media fl-wrap mt-4 mb-0">
                            <img src="{{@$camat->foto_kantor??asset('assets/front/images/kecamatan.jpg')}}" onerror="this.src='{{ asset('assets/front/images/broken.jpg') }}'" class="respimg" alt="">
                        </div>
                        <div class="reviews-comments-wrap">
                            <!-- reviews-comments-item -->
                            <div class="reviews-comments-item p-0">
                                <div class="reviews-comments-item-text p-0">
                                    <h4 class="p-0"><b>Lokasi</b></h4>
                                    <div class="clearfix"></div>
                                    <span class="reviews-comments-item-date"><i class="fa fa-map-pin"></i> {{@$camat->alamat_kantor??'-'}}</span>
                                </div>
                            </div>
                            <!--reviews-comments-item end-->
                        </div>
                        @endif
                    </div>
                    <!-- list-single-main-item -->

                    <div class="list-single-facts fl-wrap gradient-bg mt-0">
                        <!-- inline-facts -->
                        <div class="inline-facts-wrap">
                            <div class="inline-facts">
                                <i class="fa fa-check"></i>
                                <div class="milestone-counter">
                                    <div class="stats animaper">
                                        <h3>{{@$camat->sta_kan??'-'}}</h3>
                                    </div>
                                </div>
                                <h6>Status Ketersediaan</h6>
                            </div>
                        </div>
                        <!-- inline-facts end -->
                        <!-- inline-facts  -->
                        <div class="inline-facts-wrap">
                            <div class="inline-facts">
                                <i class="fa fa-thumbs-o-up"></i>
                                <div class="milestone-counter">
                                    <div class="stats animaper">
                                        <h3>{{@$camat->kon_kan??'-'}}</h3>
                                    </div>
                                </div>
                                <h6>Kondisi</h6>
                            </div>
                        </div>
                        <!-- inline-facts end -->
                        <!-- inline-facts  -->
                        <div class="inline-facts-wrap">
                            <div class="inline-facts">
                                <i class="fa fa-book"></i>
                                <div class="milestone-counter">
                                    <div class="stats animaper">
                                        <h3>{{@$camat->regulasi??'-'}}</h3>
                                    </div>
                                </div>
                                <h6>Regulasi</h6>
                            </div>
                        </div>
                        <!-- inline-facts end -->
                    </div>
                </div>
                <span class="section-separator"></span>
                <div class="list-single-main-item fl-wrap">
                    <div class="list-single-main-item-title fl-wrap m-0">
                        <h3>Balai Pertemuan Umum</h3>
                    </div>
                    @if(@$camat->kondisi_balai)
                        <div class="list-single-main-media fl-wrap mt-4 mb-0">
                            <img src="{{@$camat->foto_balai??asset('assets/front/images/kecamatan.jpg')}}" onerror="this.src='{{ asset('assets/front/images/broken.jpg') }}'" class="respimg" alt="">
                        </div>
                    @endif
                </div>
                <div class="list-single-facts fl-wrap gradient-bg mt-0 justify-content-center d-flex">
                    <!-- inline-facts -->
                    <div class="inline-facts-wrap">
                        <div class="inline-facts">
                            <i class="fa fa-{{@$camat->sta_bal=='Ada' ? 'check' : 'close'}}"></i>
                            <div class="milestone-counter">
                                <div class="stats animaper">
                                    <h3>{{@$camat->sta_bal??'-'}}</h3>
                                </div>
                            </div>
                            <h6>Status Ketersediaan</h6>
                        </div>
                    </div>
                    <!-- inline-facts end -->
                    <!-- inline-facts  -->
                    <div class="inline-facts-wrap">
                        <div class="inline-facts">
                            <i class="fa fa-thumbs-o-{{@$camat->kon_bal=='Baik' ? 'up' : 'down'}}"></i>
                            <div class="milestone-counter">
                                <div class="stats animaper">
                                    <h3>{{@$camat->kon_bal??'-'}}</h3>
                                </div>
                            </div>
                            <h6>Kondisi</h6>
                        </div>
                    </div>
                    <!-- inline-facts end -->
                </div>

                <span class="section-separator"></span>
                <!-- list-single-main-item end -->
                <div class="list-single-main-wrapper fl-wrap" id="sarpras-aset">
                    <div class="list-single-main-item fl-wrap">
                        <div class="list-single-main-item-title fl-wrap">
                            <h3>Daftar Aset</h3>
                        </div>
                        <table class="table mt-2" id="list-aset">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Aset</th>
                                <th>Jumlah Baik</th>
                                <th>Jumlah Rusak</th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
                <!-- list-single-main-item end -->

                <span class="section-separator"></span>
                <!-- list-single-main-item end -->
                <div class="list-single-main-wrapper fl-wrap" id="sarpras-mobilitas">
                    <div class="list-single-main-item fl-wrap">
                        <div class="list-single-main-item-title fl-wrap">
                            <h3>Sarana Mobilitas</h3>
                        </div>
                        <table class="table mt-2" id="list-mobil">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama mobilitas</th>
                                <th>Jumlah</th>
                                <th>Foto</th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
                <!-- list-single-main-item end -->

                <span class="section-separator"></span>
                <!-- list-single-main-item end -->
                <div class="list-single-main-wrapper fl-wrap" id="daftar-ppkt">
                    <div class="list-single-main-item fl-wrap">
                        <div class="list-single-main-item-title fl-wrap">
                            <h3>Daftar Pulau Pulau Kecil Terluar (PPKT)</h3>
                        </div>
                        <table class="table mt-2" id="list-ppkt">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama PPKT</th>
                                <th>Jenis</th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
                <!-- list-single-main-item end -->

                <span class="section-separator"></span>
                <!-- list-single-main-item end -->
                <div class="list-single-main-wrapper fl-wrap" id="daftar-penduduk">
                    <div class="list-single-main-item fl-wrap">
                        <div class="list-single-main-item-title fl-wrap">
                            <h3>Daftar Penduduk (Umur)</h3>
                        </div>
                        <table class="table mt-2" id="list-sipil">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Keterangan</th>
                                <th>Jumlah</th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
                <!-- list-single-main-item end -->

                <span class="section-separator"></span>
                <!-- list-single-main-item end -->
                <div class="list-single-main-wrapper fl-wrap" id="daftar-kepeg">
                    <div class="list-single-main-item fl-wrap">
                        <div class="list-single-main-item-title fl-wrap">
                            <h3>Daftar Kepegawaian</h3>
                        </div>
                        <table class="table mt-2" id="list-kepeg">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Jenis ASN</th>
                                <th>Staf Bagian</th>
                                <th>Kelembagaan</th>
                                <th>Jumlah</th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
                <!-- list-single-main-item end -->
            </div>
            <!--box-widget-wrap -->
            <div class="col-md-4">
                <div class="box-widget-wrap">
                    <!--box-widget-item -->
                    <div class="box-widget-item fl-wrap">
                        <div class="box-widget-item-header">
                            <h3>Informasi Camat : </h3>
                        </div>
                        <div class="box-widget list-author-widget">
                            <div class="list-author-widget-header shapes-bg-small color-bg fl-wrap">
                                <img src="{{ asset('assets/front') }}/images/{{empty(@$camat->gender_camat)? 'user-male.png':((@$camat->gender_camat=='l')? 'user-male.png':'user-female.png')}}" alt="">
                            </div>
                            <div class="box-widget-content">
                                <div class="list-author-widget-text">
                                    <div class="list-author-widget-contacts border-0 p-0">
                                        <ul>
                                            <li><span><i class="fa fa-user"></i> Nama :</span> <b class="float-right">{{@$camat->nama_camat??'-'}}</b></li>
                                            <li><span><i class="fa fa-{{empty(@$camat->gender_camat)? 'male':((@$camat->gender_camat=='l')? 'male':'female')}}"></i> Jenis Kelamin :</span> <b class="float-right">{{empty(@$camat->gender_camat)? '-':((@$camat->gender_camat=='l')? 'Laki - laki':'Perempuan')}}</b></li>
                                            <li><span><i class="fa fa-graduation-cap"></i> Pendidikan :</span> <b class="float-right">{{@$camat->pendidikan_camat??'-'}}</b></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--box-widget-item end -->
                    <!--box-widget-item -->
                    <div class="box-widget-item fl-wrap">
                        <div class="box-widget-item-header">
                            <h3>Administrasi Wilayah : </h3>
                        </div>
                        <div class="box-widget opening-hours">
                            <div class="box-widget-content">
                                <ul>
                                    <li><span class="opening-hours-day">Ibu Kota Kecamatan </span><span class="opening-hours-time">{{@$wilayah->ibukota_kecamatan??'-'}}</span></li>
                                    <li><span class="opening-hours-day">Luas Wilayah </span><span class="opening-hours-time">{{@$wilayah->luas_wilayah??'-'}} Km<sup>2</sup></span></li>
                                    <li><span class="opening-hours-day">Jarak ke Kota </span><span class="opening-hours-time">{{@$wilayah->jarak_ke_kota??'-'}} Km</span></li>
                                    <li><span class="opening-hours-day">Jarak ke Provinsi </span><span class="opening-hours-time">{{@$wilayah->jarak_ke_provinsi??'-'}} Km</span></li>
                                    <li><span class="opening-hours-day">Jumlah Desa </span><span class="opening-hours-time">{{@$wilayah->jumlah_desa??'-'}}</span></li>
                                    <li><span class="opening-hours-day">Jumlah Kelurahan </span><span class="opening-hours-time">{{@$wilayah->jumlah_kelurahan??'-'}}</span></li>
                                    <li><span class="opening-hours-day">Jumlah Pulau </span><span class="opening-hours-time">{{@$wilayah->jumlah_pulau??'-'}}</span></li>
                                    <li><span class="opening-hours-day">PLB </span><span class="opening-hours-time">{{@$wilayah->nama_plb??'-'}}</span></li>
                                    <li class="border-0 m-0"><span class="opening-hours-day">Status PLB </span><span class="opening-hours-time">{{(@$wilayah->status_plb==1)? 'Ada':'Tidak Ada'}}</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!--box-widget-item end -->
                    <!--box-widget-item -->
                    <div class="box-widget-item fl-wrap">
                        <div class="box-widget-item-header">
                            <h3>Batas Kecamatan : </h3>
                        </div>
                        <div class="box-widget opening-hours">
                            <div class="box-widget-content">
                                <ul>
                                    <li><span class="opening-hours-day">Batas Barat </span><span class="opening-hours-time">{{@$wilayah->batas_barat??'-'}}</span></li>
                                    <li><span class="opening-hours-day">Batas Timur </span><span class="opening-hours-time">{{@$wilayah->batas_timur??'-'}}</span></li>
                                    <li><span class="opening-hours-day">Batas Selatan </span><span class="opening-hours-time">{{@$wilayah->batas_selatan??'-'}}</span></li>
                                    <li><span class="opening-hours-day">Batas Utara </span><span class="opening-hours-time">{{@$wilayah->batas_utara??'-'}}</span></li>
                                    <li><span class="opening-hours-day">Batas Negara </span><span class="opening-hours-time">{{@$wilayah->batas_negara??'-'}}</span></li>
                                    <li class="border-0 m-0"><span class="opening-hours-day">Jenis Batas Negara </span><span class="opening-hours-time">{{(@$wilayah->batas_negara_jenis==1)? 'Darat':'Laut'}}</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!--box-widget-item end -->
                    <!--box-widget-item -->
                    <div class="box-widget-item fl-wrap">
                        <div class="box-widget-item-header">
                            <h3>Detail Penduduk : </h3>
                        </div>
                        <div class="box-widget opening-hours">
                            <div class="box-widget-content">
                                <ul>
                                    <li><span class="opening-hours-day">Jumlah Penduduk </span><span class="opening-hours-time">{{@$penduduk['total']??'-'}}</span></li>
                                    <li><span class="opening-hours-day">Jumlah KK </span><span class="opening-hours-time">{{@$penduduk['kk']??'-'}}</span></li>
                                    <li><span class="opening-hours-day">Penduduk Pria </span><span class="opening-hours-time">{{@$penduduk['pria']??'-'}}</span></li>
                                    <li class="border-0 m-0"><span class="opening-hours-day">Penduduk Wanita </span><span class="opening-hours-time">{{@$penduduk['wanita']??'-'}}</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!--box-widget-item end -->
                </div>
            </div>
            <!--box-widget-wrap end -->
        </div>
    </div>
</section>
<!--  section end -->
<div class="limit-box fl-wrap"></div>
