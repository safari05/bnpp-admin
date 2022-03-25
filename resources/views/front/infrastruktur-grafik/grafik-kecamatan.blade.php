<!--  section   -->
<section class="gray-section no-top-padding infra-list" id="grafik-kecamatan">
    <div class="container">
        <div class="row">
            <!--box-widget-wrap -->
            <div class="col-md-4">
                <div class="box-widget-wrap">
                    <!--box-widget-item -->
                    <div class="box-widget-item fl-wrap">
                        <div class="box-widget-item-header">
                            <h3>Filter Grafik Kecamatan: </h3>
                        </div>
                        <div class="box-widget opening-hours">
                            <div class="box-widget-content">
                                <form class="add-comment custom-form">
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <label for="dari_tanggal">Dari Tanggal</label>
                                            <input type="text" placeholder="DD/MM/YYYY" value="" class="form-control" id="dari_tanggal">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <label for="sampai_tanggal">Sampai Tanggal</label>
                                            <input type="text" placeholder="DD/MM/YYYY" value="" class="form-control" id="sampai_tanggal">
                                        </div>
                                    </div>
                                    <button class="btn big-btn color-bg flat-btn book-btn btn-cari">Filter<i class="fa fa-angle-right"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!--box-widget-item end -->
                </div>
            </div>
            <!--box-widget-wrap end -->
            <div class="col-md-8">
                <!-- list-single-main-wrapper -->
                <div class="list-single-main-wrapper fl-wrap" id="sec2">
                    <div class="breadcrumbs gradient-bg  fl-wrap"><a href="{{ route('home') }}">Beranda</a><a href="{{ url('/infrastruktur-grafik') }}">Grafik Infrastuktur Perbatasan</a><span>Kecamatan</span></div>
                    <!-- list-single-header -->
                    <div class="list-single-header list-single-header-inside fl-wrap">
                        <div class="container">
                            <div id="chart-kec" style="width:100%; height:400px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--  section  end-->
