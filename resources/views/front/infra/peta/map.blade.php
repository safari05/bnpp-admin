@extends('front.layout.main')

@push('styles')
<link rel="stylesheet" href="{{asset('assets/vendor')}}/leaflet/leaflet.css" />
<link rel="stylesheet" href="{{asset('assets/vendor')}}/leaflet-markercluster/MarkerCluster.Default.css"/>
<style>
    .map-container #map-kec{
        position: absolute;
        top:0;
        left:0;
        height: 100%;
        width:100%;
        z-index: 10;
        overflow:hidden;
    }
</style>
@endpush

@section('content')
<!-- Map -->
<div class="map-container fw-map">
    <div id="map-kec"></div>
    <ul class="mapnavigation">
        <li><a href="#" class="prevmap-nav">Prev</a></li>
        <li><a href="#" class="nextmap-nav">Next</a></li>
    </ul>
    <div class="scrollContorl mapnavbtn" title="Enable Scrolling"><span><i class="fa fa-lock"></i></span></div>
</div>
<!-- Map end -->
<!-- section -->
<section class="gray-bg no-pading no-top-padding">
    <div class="col-list-wrap fh-col-list-wrap  left-list">
        <div class="container">

            <div class="row mb-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-content p-3">
                            <div class="row">
                                <div class="col-12">
                                    <div class="listsearch-header fl-wrap">
                                        <h3>Cari Kecamatan</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-6 text-left">
                                    <label for="prov">Provinsi</label>
                                    <select name="prov" id="prov" class="form-control">
                                    </select>
                                </div>
                                <div class="col-6 text-left">
                                    <label for="kota">Kota</label>
                                    <select name="kota" id="kota" class="form-control">
                                        <option value="0">Semua Kota</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-12">
                                    <input type="text" placeholder="Nama Kecamatan" value="" class="form-control" id="q">
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-6 text-left">
                                    <label for="tipe">Tipe</label>
                                    <select name="tipe" id="tipe" class="form-control">
                                        <option value="1">Kec. Perbatasan</option>
                                        <option value="2">Kec. Perbatasan PKSN</option>
                                        <option value="3">Kec. Lokpri</option>
                                    </select>
                                </div>
                                <div class="col-6 d-none" id="optlokpri">
                                    <label for="tipe">Jenis Lokpri</label>
                                    <br>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input lok-check" type="checkbox" value="1">
                                        <label class="form-check-label" for="inlineCheckbox1">Kec. Lokpri</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input lok-check" type="checkbox" id="inlineCheckbox2" value="2">
                                        <label class="form-check-label" for="inlineCheckbox2">Sebagai PKSN</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input lok-check" type="checkbox" id="inlineCheckbox3" value="3">
                                        <label class="form-check-label" for="inlineCheckbox3">Memiliki PPKT</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-3"></div>
                                <div class="col-6">
                                    <button class="btn btn-success btn-sm btn-block btn-custom btn-cari">Cari</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="row">
                <div class="col-md-8">
                    <div class="listsearch-header fl-wrap">
                        <h3>Results For : <span>Food and Drink</span></h3>
                        <div class="listing-view-layout">
                            <ul>
                                <li><a class="grid active" href="#"><i class="fa fa-th-large"></i></a></li>
                                <li><a class="list" href="#"><i class="fa fa-list-ul"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <!-- list-main-wrap-->
                    <div class="list-main-wrap fl-wrap card-listing">
                        <!-- listing-item -->
                        <div class="listing-item">
                            <article class="geodir-category-listing fl-wrap">
                                <div class="geodir-category-img">
                                    <img src="images/all/1.jpg" alt="">
                                    <div class="overlay"></div>
                                    <div class="list-post-counter"><span>4</span><i class="fa fa-heart"></i></div>
                                </div>
                                <div class="geodir-category-content fl-wrap">
                                    <a class="listing-geodir-category" href="listing.html">Restourants</a>
                                    <div class="listing-avatar"><a href="author-single.html"><img src="images/avatar/1.jpg" alt=""></a>
                                        <span class="avatar-tooltip">Added By  <strong>Lisa Smith</strong></span>
                                    </div>
                                    <h3><a href="listing-single.html">Luxury Restourant</a></h3>
                                    <p>Sed interdum metus at nisi tempor laoreet. Integer gravida orci a justo sodales, sed lobortis est placerat.</p>
                                    <div class="geodir-category-options fl-wrap">
                                        <div class="listing-rating card-popup-rainingvis" data-starrating2="5">
                                            <span>(7 reviews)</span>
                                        </div>
                                        <div class="geodir-category-location"><a href="#0" class="map-item scroll-top-map"><i class="fa fa-map-marker" aria-hidden="true"></i> 27th Brooklyn New York, NY 10065</a></div>
                                    </div>
                                </div>
                            </article>
                        </div>
                        <!-- listing-item end-->
                        <!-- listing-item -->
                        <div class="listing-item">
                            <article class="geodir-category-listing fl-wrap">
                                <div class="geodir-category-img">
                                    <img src="images/all/1.jpg" alt="">
                                    <div class="overlay"></div>
                                    <div class="list-post-counter"><span>15</span><i class="fa fa-heart"></i></div>
                                </div>
                                <div class="geodir-category-content fl-wrap">
                                    <a class="listing-geodir-category" href="listing.html">Event</a>
                                    <div class="listing-avatar"><a href="author-single.html"><img src="images/avatar/1.jpg" alt=""></a>
                                        <span class="avatar-tooltip">Added By  <strong>Mark Rose</strong></span>
                                    </div>
                                    <h3><a href="listing-single.html">Event In City Mol</a></h3>
                                    <p>Morbi suscipit erat in diam bibendum rutrum in nisl. Aliquam et purus ante.</p>
                                    <div class="geodir-category-options fl-wrap">
                                        <div class="listing-rating card-popup-rainingvis" data-starrating2="4">
                                            <span>(17 reviews)</span>
                                        </div>
                                        <div class="geodir-category-location"><a href="#1" class="map-item scroll-top-map"><i class="fa fa-map-marker" aria-hidden="true"></i> 27th Brooklyn New York, NY 10065</a></div>
                                    </div>
                                </div>
                            </article>
                        </div>
                        <!-- listing-item end-->
                        <div class="clearfix"></div>
                        <!-- listing-item -->
                        <div class="listing-item">
                            <article class="geodir-category-listing fl-wrap">
                                <div class="geodir-category-img">
                                    <img src="images/all/1.jpg" alt="">
                                    <div class="overlay"></div>
                                    <div class="list-post-counter"><span>553</span><i class="fa fa-heart"></i></div>
                                </div>
                                <div class="geodir-category-content fl-wrap">
                                    <a class="listing-geodir-category" href="listing.html">Restourants</a>
                                    <div class="listing-avatar"><a href="author-single.html"><img src="images/avatar/1.jpg" alt=""></a>
                                        <span class="avatar-tooltip">Added By  <strong>Adam Koncy</strong></span>
                                    </div>
                                    <h3><a href="listing-single.html">Luxury Restourant</a></h3>
                                    <p>Sed non neque elit. Sed ut imperdie.</p>
                                    <div class="geodir-category-options fl-wrap">
                                        <div class="listing-rating card-popup-rainingvis" data-starrating2="5">
                                            <span>(7 reviews)</span>
                                        </div>
                                        <div class="geodir-category-location"><a href="#2" class="map-item scroll-top-map"><i class="fa fa-map-marker" aria-hidden="true"></i> 27th Brooklyn New York, NY 10065</a></div>
                                    </div>
                                </div>
                            </article>
                        </div>
                        <!-- listing-item end-->
                        <!-- listing-item -->
                        <div class="listing-item">
                            <article class="geodir-category-listing fl-wrap">
                                <div class="geodir-category-img">
                                    <img src="images/all/1.jpg" alt="">
                                    <div class="overlay"></div>
                                    <div class="list-post-counter"><span>47</span><i class="fa fa-heart"></i></div>
                                </div>
                                <div class="geodir-category-content fl-wrap">
                                    <a class="listing-geodir-category" href="listing.html">Fitness</a>
                                    <div class="listing-avatar"><a href="author-single.html"><img src="images/avatar/1.jpg" alt=""></a>
                                        <span class="avatar-tooltip">Added By  <strong>Alisa Noory</strong></span>
                                    </div>
                                    <h3><a href="listing-single.html">Gym in the Center</a></h3>
                                    <p>Mauris in erat justo. Nullam ac urna eu. </p>
                                    <div class="geodir-category-options fl-wrap">
                                        <div class="listing-rating card-popup-rainingvis" data-starrating2="5">
                                            <span>(23 reviews)</span>
                                        </div>
                                        <div class="geodir-category-location"><a href="#3" class="map-item scroll-top-map"><i class="fa fa-map-marker" aria-hidden="true"></i> 27th Brooklyn New York, NY 10065</a></div>
                                    </div>
                                </div>
                            </article>
                        </div>
                        <!-- listing-item end-->
                        <div class="clearfix"></div>
                        <!-- listing-item -->
                        <div class="listing-item">
                            <article class="geodir-category-listing fl-wrap">
                                <div class="geodir-category-img">
                                    <img src="images/all/1.jpg" alt="">
                                    <div class="overlay"></div>
                                    <div class="list-post-counter"><span>3</span><i class="fa fa-heart"></i></div>
                                </div>
                                <div class="geodir-category-content fl-wrap">
                                    <a class="listing-geodir-category" href="listing.html">Shops</a>
                                    <div class="listing-avatar"><a href="author-single.html"><img src="images/avatar/1.jpg" alt=""></a>
                                        <span class="avatar-tooltip">Added By  <strong>Nasty Wood</strong></span>
                                    </div>
                                    <h3><a href="listing-single.html">Shop in Boutique Zone</a></h3>
                                    <p>Morbiaccumsan ipsum velit tincidunt . </p>
                                    <div class="geodir-category-options fl-wrap">
                                        <div class="listing-rating card-popup-rainingvis" data-starrating2="4">
                                            <span>(6 reviews)</span>
                                        </div>
                                        <div class="geodir-category-location"><a href="#4" class="map-item scroll-top-map"><i class="fa fa-map-marker" aria-hidden="true"></i> 27th Brooklyn New York, NY 10065</a></div>
                                    </div>
                                </div>
                            </article>
                        </div>
                        <!-- listing-item end-->
                        <!-- listing-item -->
                        <div class="listing-item">
                            <article class="geodir-category-listing fl-wrap">
                                <div class="geodir-category-img">
                                    <img src="images/all/1.jpg" alt="">
                                    <div class="overlay"></div>
                                    <div class="list-post-counter"><span>35</span><i class="fa fa-heart"></i></div>
                                </div>
                                <div class="geodir-category-content fl-wrap">
                                    <a class="listing-geodir-category" href="listing.html">Hotels</a>
                                    <div class="listing-avatar"><a href="author-single.html"><img src="images/avatar/1.jpg" alt=""></a>
                                        <span class="avatar-tooltip">Added By  <strong>Kliff Antony</strong></span>
                                    </div>
                                    <h3><a href="listing-single.html">Luxary Hotel</a></h3>
                                    <p>Lorem ipsum gravida nibh vel velit.</p>
                                    <div class="geodir-category-options fl-wrap">
                                        <div class="listing-rating card-popup-rainingvis" data-starrating2="5">
                                            <span>(11 reviews)</span>
                                        </div>
                                        <div class="geodir-category-location"><a href="#5" class="map-item scroll-top-map"><i class="fa fa-map-marker" aria-hidden="true"></i> 27th Brooklyn New York, NY 10065</a></div>
                                    </div>
                                </div>
                            </article>
                        </div>
                        <!-- listing-item end-->
                        <!-- pagination-->
                        <div class="pagination">
                            <a href="#" class="prevposts-link"><i class="fa fa-caret-left"></i></a>
                            <a href="#" class="blog-page transition">1</a>
                            <a href="#" class="blog-page current-page transition">2</a>
                            <a href="#" class="blog-page transition">3</a>
                            <a href="#" class="blog-page transition">4</a>
                            <a href="#" class="nextposts-link"><i class="fa fa-caret-right"></i></a>
                        </div>
                    </div>
                    <!-- list-main-wrap end-->
                </div>
                <!-- sidebar filters -->
                <div class="col-md-4">
                    <div class="fl-wrap">
                        <!-- listsearch-input-wrap  -->
                        <div class="listsearch-input-wrap fl-wrap">
                            <div class="listsearch-input-item">
                                <i class="mbri-key single-i"></i>
                                <input type="text" placeholder="Keywords?" value=""/>
                            </div>
                            <div class="listsearch-input-item">
                                <select data-placeholder="Location" class="chosen-select" >
                                    <option>All Locations</option>
                                    <option>Bronx</option>
                                    <option>Brooklyn</option>
                                    <option>Manhattan</option>
                                    <option>Queens</option>
                                    <option>Staten Island</option>
                                </select>
                            </div>
                            <div class="listsearch-input-item">
                                <select data-placeholder="All Categories" class="chosen-select" >
                                    <option>All Categories</option>
                                    <option>Shops</option>
                                    <option>Hotels</option>
                                    <option>Restaurants</option>
                                    <option>Fitness</option>
                                    <option>Events</option>
                                </select>
                            </div>
                            <div class="listsearch-input-text" id="autocomplete-container">
                                <label><i class="mbri-map-pin"></i> Enter Addres </label>
                                <input type="text" placeholder="Destination , Area , Street" id="autocomplete-input" class="qodef-archive-places-search" value=""/>
                                <a  href="#"  class="loc-act qodef-archive-current-location"><i class="fa fa-dot-circle-o"></i></a>
                            </div>
                            <div class="distance-input fl-wrap">
                                <div class="distance-title"> Radius around selected destination <span></span> km</div>
                                <div class="distance-radius-wrap fl-wrap">
                                    <input class="distance-radius rangeslider--horizontal" type="range" min="1" max="100" step="1" value="1" data-title="Radius around selected destination">
                                </div>
                            </div>
                            <!-- Checkboxes -->
                            <div class=" fl-wrap filter-tags">
                                <h4>Filter by Tags</h4>
                                <div class="filter-tags-wrap">
                                    <input id="check-a" type="checkbox" name="check">
                                    <label for="check-a">Elevator in building</label>
                                </div>
                                <div class="filter-tags-wrap">
                                    <input id="check-b" type="checkbox" name="check">
                                    <label for="check-b">Friendly workspace</label>
                                </div>
                                <div class="filter-tags-wrap">
                                    <input id="check-c" type="checkbox" name="check">
                                    <label for="check-c">Instant Book</label>
                                </div>
                                <div class="filter-tags-wrap">
                                    <input id="check-d" type="checkbox" name="check">
                                    <label for="check-d">Wireless Internet</label>
                                </div>
                            </div>
                            <!-- hidden-listing-filter end -->
                            <button class="button fs-map-btn">Update</button>
                        </div>
                        <!-- listsearch-input-wrap end -->
                    </div>
                </div>
                <!-- sidebar filters end -->
            </div> --}}
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script src="{{asset('assets/vendor')}}/leaflet/leaflet.js"></script>
<script src="{{asset('assets/vendor')}}/leaflet-markercluster/leaflet.markercluster.js"></script>

<script>
    $(document).ready(function(){
        initMapKecamatan();
    });



    function initMapKecamatan(){
        var map = L.map('map-kec').setView([-1.938866507948674, 117.71236419677734], 5);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution:'Map data © <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY- SA</a>',
            maxZoom: 18
        }).addTo(map);

        let specialMarker = L.marker([-6.938866507948674, 107.71236419677734], {
            draggable:true,
        }).addTo(map);

        specialMarker.on('dragend', function(e){
            var chagedPos = e.target.getLatLng();
            this.bindPopup(chagedPos.toString()).openPopup();
        })
        var group1 = L.markerClusterGroup();
        group1.addLayer(L.marker([-6.938866507948674, 107.71236419677734]).bindPopup('<b>Hello world!</b><br />I am a popup.'));
        group1.addLayer(L.marker([-6.938866507948673, 107.71436419677735]).bindPopup('<b>Hello world!</b><br />I am a popup Marker 2.'));
        group1.addLayer(L.marker([1.515936, 109.665527]).bindPopup('<b>Hello world!</b><br />I am a popup.'));
        group1.addLayer(L.marker([0.928304, 111.088257]).bindPopup('<b>Hello world!</b><br />I am a popup Marker 2.'));
        group1.addLayer(L.marker([0.911827, 110.34668]).bindPopup('<b>Hello world!</b><br />I am a popup Marker 2.'));
        group1.addLayer(L.marker([4.793631, 108.020089]).bindPopup('<b>Hello world!</b><br />I am a popup Marker 2.'));
        map.addLayer(group1);


    }
</script>
@endpush
