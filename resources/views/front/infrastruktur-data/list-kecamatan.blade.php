<!--  section   -->
<section class="gray-section no-top-padding infra-list" id="list-kecamatan">
    <div class="container">
        <div class="row">
            <!--box-widget-wrap -->
            <div class="col-md-4">
                <div class="box-widget-wrap">
                    <!--box-widget-item -->
                    <div class="box-widget-item fl-wrap">
                        <div class="box-widget-item-header">
                            <h3>Cari Kecamatan: </h3>
                        </div>
                        <div class="box-widget opening-hours">
                            <div class="box-widget-content">
                                <form class="add-comment custom-form">
                                    <div class="row mb-3">
                                        <div class="col-12 text-left">
                                            <label for="provid">Provinsi</label>
                                            <select name="provid" id="provid" class="form-control form-select2">
                                                @foreach ($provinces as $item)
                                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-12 text-left">
                                            <label for="kotaid">Kota</label>
                                            <select name="kotaid" id="kotaid" class="form-control form-select2">
                                                <option value="0">Semua Kota</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <label for="name">Nama Kecamatan</label>
                                            <input type="text" placeholder="Cari Kecamatan..." value="" class="form-control" name="name" id="name">
                                        </div>
                                    </div>
{{--                                    <div class="form-group mb-3">--}}
{{--                                        <label>Tipe Kecamatan</label>--}}
{{--                                        @foreach ($tipe as $item)--}}
{{--                                            <div class="checkbox">--}}
{{--                                                <label><input type="checkbox" class="s-check-tipe" value="{{$item->typeid}}" data-tipe="{{$item->typeid}}">{{$item->nickname}}</label>--}}
{{--                                            </div>--}}
{{--                                        @endforeach--}}
{{--                                    </div>--}}
                                    <div class="form-group mb-3">
                                        <label>Lokpri Kecamatan</label>
                                        @foreach ($lokpri as $item)
                                            <div class="checkbox">
                                                <label><input type="checkbox" class="s-check-lokpri" value="{{$item->lokpriid}}" data-tipe="{{$item->lokpriid}}">{{$item->nickname}}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                    <button class="btn big-btn color-bg flat-btn book-btn btn-cari" onclick="refreshTableKec()">Cari<i class="fa fa-angle-right"></i></button>
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
                    <div class="breadcrumbs gradient-bg  fl-wrap"><a href="{{ route('home') }}">Beranda</a><a href="{{ url('/infrastruktur-data') }}">Data & Grafik Infrastuktur Perbatasan</a><span>Kecamatan</span></div>
                    <!-- list-single-header -->
                    <div class="list-single-header list-single-header-inside fl-wrap">
                        <div class="container">
                            <table class="table table-striped table-bordered dt-responsive nowrap" id="list-content-kecamatan">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kota</th>
                                        <th>Kecamatan</th>
                                        <th>Tipe</th>
                                        <th>Lokasi Prioritas</th>
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
<!--  section  end-->
