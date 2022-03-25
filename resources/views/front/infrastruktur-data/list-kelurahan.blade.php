<!--  section   -->
<section class="gray-section no-top-padding infra-list hidden" id="list-kelurahan">
    <div class="container">
        <div class="row">
            <!--box-widget-wrap -->
            <div class="col-md-4">
                <div class="box-widget-wrap">
                    <!--box-widget-item -->
                    <div class="box-widget-item fl-wrap">
                        <div class="box-widget-item-header">
                            <h3>Cari Desa: </h3>
                        </div>
                        <div class="box-widget opening-hours">
                            <div class="box-widget-content">
                                <form class="add-comment custom-form">
                                    <div class="row mb-3">
                                        <div class="col-12 text-left">
                                            <label for="provid_kel">Provinsi</label>
                                            <select name="provid_kel" id="provid_kel" class="form-control form-select2">
                                                @foreach ($provinces as $item)
                                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-12 text-left">
                                            <label for="kotaid_kel">Kota</label>
                                            <select name="kotaid_kel" id="kotaid_kel" class="form-control form-select2">
                                                <option value="0">Semua Kota</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-12 text-left">
                                            <label for="kecid_kel">Kecamatan</label>
                                            <select name="kecid_kel" id="kecid_kel" class="form-control form-select2">
                                                <option value="0">Semua Kecamatan</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <label for="name_kel">Nama Desa</label>
                                            <input type="text" placeholder="Cari Desa..." value="" class="form-control" name="name_kel" id="name_kel">
                                        </div>
                                    </div>
                                    <button class="btn big-btn color-bg flat-btn book-btn btn-cari" onclick="refreshTableKel()">Cari<i class="fa fa-angle-right"></i></button>
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
                    <div class="breadcrumbs gradient-bg  fl-wrap"><a href="{{ route('home') }}">Beranda</a><a href="{{ url('/infrastruktur-data') }}">Data & Grafik Infrastuktur Perbatasan</a><span>Desa</span></div>
                    <!-- list-single-header -->
                    <div class="list-single-header list-single-header-inside fl-wrap">
                        <div class="container">
                            <table class="table table-striped table-bordered dt-responsive nowrap" id="list-content-kelurahan">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kota</th>
                                        <th>Kecamatan</th>
                                        <th>Desa</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
