<!--  section  -->
<section class="parallax-section single-par list-single-section" data-scrollax-parent="true" id="sec1">
    <div class="bg par-elem" data-bg="{{@$kades->foto_kantor??asset('assets/front/images/desa.jpg')}}" data-scrollax="properties: { translateY: '30%' }"></div>
    <div class="overlay"></div>
    <div class="bubble-bg"></div>
    <div class="list-single-header absolute-header fl-wrap">
        <div class="container">
            <div class="list-single-header-item">
                <div class="list-single-header-item-opt fl-wrap">
                    <div class="list-single-header-cat fl-wrap">
                        <a href="javascript:void(0);">Desa</a>
                    </div>
                </div>
                <h2>DESA {{$desa->name}} <span> - {{$desa->kecamatan->name.', '.$desa->kecamatan->kota->name.', '.$desa->kecamatan->kota->provinsi->name}}</span> </h2>
                <span class="section-separator"></span>
            </div>
        </div>
    </div>
</section>
<!--  section end -->
<div class="scroll-nav-wrapper fl-wrap">
    <div class="container">
        <nav class="scroll-nav scroll-init">
            <ul>
                <li><a class="act-scrlink" href="#grafik-sarpras-aset">Grafik Aset</a></li>
                <li><a href="#grafik-sarpras-mobilitas">Grafik Sarana Mobilitas</a></li>
                <li><a href="#grafik-pondes">Grafik Potensi Desa</a></li>
                <li><a href="#grafik-penduduk">Grafik Penduduk</a></li>
                <li><a href="#grafik-kepeg">Grafik Kepegawaian</a></li>
            </ul>
        </nav>
    </div>
</div>
<!--  section  -->
<section class="gray-section no-top-padding">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="list-single-main-wrapper fl-wrap" id="grafik-sarpras-aset">
                    <div class="breadcrumbs gradient-bg fl-wrap"><a href="{{ route('home') }}">Beranda</a><a href="{{ url('/infrastruktur-data') }}">Data & Grafik Infrastruktur Perbatasan</a><span>Detail</span></div>

                    <div class="list-single-main-item fl-wrap">
                        <div class="list-single-main-item-title fl-wrap mb-2">
                            <h3>Grafik Aset</h3>
                        </div>

                        <canvas id="chart-aset" height="130"></canvas>
                    </div>
                </div>

                <span class="section-separator"></span>
                <!-- list-single-main-item end -->
                <div class="list-single-main-wrapper fl-wrap" id="grafik-sarpras-mobilitas">
                    <div class="list-single-main-item fl-wrap">
                        <div class="list-single-main-item-title fl-wrap mb-2">
                            <h3>Grafik Sarana Mobilitas</h3>
                        </div>

                        <canvas id="chart-mobil" height="130"></canvas>
                    </div>
                </div>
                <!-- list-single-main-item end -->

                <span class="section-separator"></span>
                <!-- list-single-main-item end -->
                <div class="list-single-main-wrapper fl-wrap" id="grafik-pondes">
                    <div class="list-single-main-item fl-wrap">
                        <div class="list-single-main-item-title fl-wrap mb-2">
                            <h3>Grafik Potensi Desa</h3>
                        </div>

                        <canvas id="chart-pondes" height="130"></canvas>
                    </div>
                </div>
                <!-- list-single-main-item end -->

                <span class="section-separator"></span>
                <!-- list-single-main-item end -->
                <div class="list-single-main-wrapper fl-wrap" id="grafik-penduduk">
                    <div class="list-single-main-item fl-wrap">
                        <div class="list-single-main-item-title fl-wrap mb-2">
                            <h3>Grafik Penduduk (Umur)</h3>
                        </div>

                        <canvas id="chart-penduduk-age" height="130"></canvas>
                    </div>
                </div>
                <div class="list-single-main-wrapper fl-wrap">
                    <div class="list-single-main-item fl-wrap">
                        <div class="list-single-main-item-title fl-wrap mb-2">
                            <h3>Grafik Penduduk (Gender)</h3>
                        </div>

                        <canvas id="chart-penduduk-gender" height="130"></canvas>
                    </div>
                </div>
                <!-- list-single-main-item end -->

                <span class="section-separator"></span>
                <!-- list-single-main-item end -->
                <div class="list-single-main-wrapper fl-wrap" id="grafik-kepeg">
                    <div class="list-single-main-item fl-wrap">
                        <div class="list-single-main-item-title fl-wrap mb-2">
                            <h3>Grafik Kepegawaian</h3>
                        </div>

                        <canvas id="chart-peg" height="130"></canvas>
                    </div>
                    <div class="list-single-main-wrapper fl-wrap">
                        <div class="list-single-main-item fl-wrap">
                            <div class="list-single-main-item-title fl-wrap mb-2">
                                <h3>Grafik Kepegawaian ASN</h3>
                            </div>

                            <canvas id="chart-peg-asn" height="130"></canvas>
                        </div>
                    </div>
                    <div class="list-single-main-wrapper fl-wrap">
                        <div class="list-single-main-item fl-wrap">
                            <div class="list-single-main-item-title fl-wrap mb-2">
                                <h3>Grafik Kepegawaian Lembaga</h3>
                            </div>

                            <canvas id="chart-peg-lembaga" height="130"></canvas>
                        </div>
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
                            <h3>Informasi Kades : </h3>
                        </div>
                        <div class="box-widget list-author-widget">
                            <div class="list-author-widget-header shapes-bg-small color-bg fl-wrap">
                                <img src="{{ asset('assets/front') }}/images/{{empty(@$kades->gender_kades)? 'user-male.png':((@$kades->gender_kades=='l')? 'user-male.png':'user-female.png')}}" alt="">
                            </div>
                            <div class="box-widget-content">
                                <div class="list-author-widget-text">
                                    <div class="list-author-widget-contacts border-0 p-0">
                                        <ul>
                                            <li><span><i class="fa fa-user"></i> Nama :</span> <b class="float-right">{{@$kades->nama_kades??'-'}}</b></li>
                                            <li><span><i class="fa fa-{{empty(@$kades->gender_kades)? 'male':((@$kades->gender_kades=='l')? 'male':'female')}}"></i> Jenis Kelamin :</span> <b class="float-right">{{empty(@$kades->gender_kades)? '-':((@$kades->gender_kades=='l')? 'Laki - laki':'Perempuan')}}</b></li>
                                            <li><span><i class="fa fa-graduation-cap"></i> Pendidikan :</span> <b class="float-right">{{@$kades->pendidikan_kades??'-'}}</b></li>
                                        </ul>
                                    </div>
                                </div>
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
