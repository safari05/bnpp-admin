<div class="peta-kecamatan infra-list" id="peta-kecamatan">
    <!-- Map -->
    <div class="map-container column-map right-pos-map">
        <div id="map-kec"></div>
{{--        <ul class="mapnavigation">--}}
{{--            <li><a href="#" class="prevmap-nav">Prev</a></li>--}}
{{--            <li><a href="#" class="nextmap-nav">Next</a></li>--}}
{{--        </ul>--}}
{{--        <div class="scrollContorl mapnavbtn" title="Enable Scrolling"><span><i class="fa fa-lock"></i></span></div>--}}
    </div>
    <!-- Map end -->
    <!--col-list-wrap -->
    <div class="col-list-wrap left-list">
        <div class="listsearch-options fl-wrap" id="lisfw" >
            <div class="container">
                <div class="listsearch-header fl-wrap border-0">
                    <h3>Menampilkan Peta : <span>Kecamatan</span></h3>
                </div>
                <div class="box-widget opening-hours">
                    <div class="box-widget-content">
                        <form class="add-comment custom-form">
                            <div class="row mb-3">
                                <div class="col-12 text-left">
                                    <label for="prov_kec">Provinsi</label>
                                    <select name="prov_kec" id="prov_kec" class="form-control">
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12 text-left">
                                    <label for="kota_kec">Kota</label>
                                    <select name="kota_kec" id="kota_kec" class="form-control">
                                        <option value="0">Semua Kota</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12">
                                    <label for="q_kec">Nama Kecamatan</label>
                                    <input type="text" placeholder="Nama Kecamatan" value="" class="form-control" id="q_kec">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12 text-left">
                                    <label for="tipe_kec">Tipe</label>
                                    <select name="tipe_kec" id="tipe_kec" class="form-control">
                                        <option value="1">Kec. Perbatasan</option>
                                        <option value="2">Kec. Perbatasan PKSN</option>
                                        <option value="3">Kec. Lokpri</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3 d-none" id="optlokpri_kec">
                                <div class="col-12">
                                    <label>Jenis Lokpri</label>
                                    <br>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input lok-check" id="lokpri_kec1" type="checkbox" value="1">
                                        <label class="form-check-label" for="lokpri_kec1">Kec. Lokpri</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input lok-check" type="checkbox" id="lokpri_kec2" value="2">
                                        <label class="form-check-label" for="lokpri_kec2">Sebagai PKSN</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input lok-check" type="checkbox" id="lokpri_kec3" value="3">
                                        <label class="form-check-label" for="lokpri_kec1">Memiliki PPKT</label>
                                    </div>
                                </div>
                            </div>
                            <button class="btn big-btn color-bg flat-btn book-btn btn-cari">Cari<i class="fa fa-angle-right"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{--    <!-- section -->--}}
{{--    <section class="gray-bg no-pading no-top-padding">--}}
{{--        <div class="col-list-wrap fh-col-list-wrap  left-list">--}}
{{--            <div class="container">--}}
{{--                <div class="row mb-4">--}}
{{--                    <div class="col-12">--}}
{{--                        <div class="card">--}}
{{--                            <div class="card-content p-3">--}}
{{--                                <div class="row">--}}
{{--                                    <div class="col-12">--}}
{{--                                        <div class="listsearch-header fl-wrap">--}}
{{--                                            <h3>Cari Kecamatan</h3>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="row mt-2">--}}
{{--                                    <div class="col-6 text-left">--}}
{{--                                        <label for="prov">Provinsi</label>--}}
{{--                                        <select name="prov" id="prov" class="form-control">--}}
{{--                                        </select>--}}
{{--                                    </div>--}}
{{--                                    <div class="col-6 text-left">--}}
{{--                                        <label for="kota">Kota</label>--}}
{{--                                        <select name="kota" id="kota" class="form-control">--}}
{{--                                            <option value="0">Semua Kota</option>--}}
{{--                                        </select>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="row mt-2">--}}
{{--                                    <div class="col-12">--}}
{{--                                        <input type="text" placeholder="Nama Kecamatan" value="" class="form-control" id="q">--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="row mt-2">--}}
{{--                                    <div class="col-6 text-left">--}}
{{--                                        <label for="tipe">Tipe</label>--}}
{{--                                        <select name="tipe" id="tipe" class="form-control">--}}
{{--                                            <option value="1">Kec. Perbatasan</option>--}}
{{--                                            <option value="2">Kec. Perbatasan PKSN</option>--}}
{{--                                            <option value="3">Kec. Lokpri</option>--}}
{{--                                        </select>--}}
{{--                                    </div>--}}
{{--                                    <div class="col-6 d-none" id="optlokpri">--}}
{{--                                        <label for="tipe">Jenis Lokpri</label>--}}
{{--                                        <br>--}}
{{--                                        <div class="form-check form-check-inline">--}}
{{--                                            <input class="form-check-input lok-check" type="checkbox" value="1">--}}
{{--                                            <label class="form-check-label" for="inlineCheckbox1">Kec. Lokpri</label>--}}
{{--                                        </div>--}}
{{--                                        <div class="form-check form-check-inline">--}}
{{--                                            <input class="form-check-input lok-check" type="checkbox" id="inlineCheckbox2" value="2">--}}
{{--                                            <label class="form-check-label" for="inlineCheckbox2">Sebagai PKSN</label>--}}
{{--                                        </div>--}}
{{--                                        <div class="form-check form-check-inline">--}}
{{--                                            <input class="form-check-input lok-check" type="checkbox" id="inlineCheckbox3" value="3">--}}
{{--                                            <label class="form-check-label" for="inlineCheckbox3">Memiliki PPKT</label>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="row mt-4">--}}
{{--                                    <div class="col-3"></div>--}}
{{--                                    <div class="col-6">--}}
{{--                                        <button class="btn btn-success btn-sm btn-block btn-custom btn-cari">Cari</button>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </section>--}}
