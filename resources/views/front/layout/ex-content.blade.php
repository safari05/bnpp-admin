@extends('front.layout.main')

@push('styles')

@endpush

@section('content')
<!--section -->
<section class="scroll-con-sec hero-section" data-scrollax-parent="true" id="sec1">
    <div class="bg"  data-bg="{{asset('assets/front')}}/images/bg/map-static.png" data-scrollax="properties: { translateY: '200px' }"></div>
    <div class="overlay"></div>
    <div class="hero-section-wrap fl-wrap">
        <div class="container">
            <div class="intro-item fl-wrap">
                <h2>We will help you to find all</h2>
                <h3>Find great places , hotels , restourants , shops.</h3>
            </div>
            <div class="main-search-input-wrap">
                <div class="main-search-input fl-wrap">
                    <div class="main-search-input-item">
                        <input type="text" placeholder="What are you looking for?" value=""/>
                    </div>
                    <div class="main-search-input-item location" id="autocomplete-container">
                        <input type="text" placeholder="Location" id="autocomplete-input" value=""/>
                        <a href="#"><i class="fa fa-dot-circle-o"></i></a>
                    </div>
                    <div class="main-search-input-item">
                        <select data-placeholder="All Categories" class="chosen-select" >
                            <option>All Categories</option>
                            <option>Shops</option>
                            <option>Hotels</option>
                            <option>Restaurants</option>
                            <option>Fitness</option>
                            <option>Events</option>
                        </select>
                    </div>
                    <button class="main-search-button" onclick="window.location.href='listings-half-screen-map-list.html'">Search</button>
                </div>
            </div>
        </div>
    </div>
    <div class="bubble-bg"> </div>
    <div class="header-sec-link">
        <div class="container"><a href="#sec2" class="custom-scroll-link">Let's Start</a></div>
    </div>
</section>
<!-- section end -->
<!--section -->
<section id="sec2">
    <div class="container">
        <div class="section-title">
            <h2>Featured Categories</h2>
            <div class="section-subtitle">Catalog of Categories</div>
            <span class="section-separator"></span>
            <p>Explore some of the best tips from around the city from our partners and friends.</p>
        </div>
        <!-- portfolio start -->
        <div class="gallery-items fl-wrap mr-bot spad">
            <!-- gallery-item-->
            <div class="gallery-item">
                <div class="grid-item-holder">
                    <div class="listing-item-grid">
                        <div class="bg"  data-bg="{{asset('assets/front')}}/images/all/1.jpg"></div>
                        <div class="listing-counter"><span>10 </span> Locations</div>
                        <div class="listing-item-cat">
                            <h3><a href="listing.html">Conference and Event</a></h3>
                            <p>Constant care and attention to the patients makes good record</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- gallery-item end-->
            <!-- gallery-item-->
            <div class="gallery-item gallery-item-second">
                <div class="grid-item-holder">
                    <div class="listing-item-grid">
                        <div class="bg"  data-bg="{{asset('assets/front')}}/images/all/1.jpg"></div>
                        <div class="listing-counter"><span>6 </span> Locations</div>
                        <div class="listing-item-cat">
                            <h3><a href="listing.html">Cafe - Pub</a></h3>
                            <p>Constant care and attention to the patients makes good record</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- gallery-item end-->
            <!-- gallery-item-->
            <div class="gallery-item">
                <div class="grid-item-holder">
                    <div class="listing-item-grid">
                        <div class="bg"  data-bg="{{asset('assets/front')}}/images/all/1.jpg"></div>
                        <div class="listing-counter"><span>21 </span> Locations</div>
                        <div class="listing-item-cat">
                            <h3><a href="listing.html">Gym - Fitness</a></h3>
                            <p>Constant care and attention to the patients makes good record</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- gallery-item end-->
            <!-- gallery-item-->
            <div class="gallery-item">
                <div class="grid-item-holder">
                    <div class="listing-item-grid">
                        <div class="bg"  data-bg="{{asset('assets/front')}}/images/all/1.jpg"></div>
                        <div class="listing-counter"><span>7 </span> Locations</div>
                        <div class="listing-item-cat">
                            <h3><a href="listing.html">Hotels</a></h3>
                            <p>Constant care and attention to the patients makes good record</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- gallery-item end-->
            <!-- gallery-item-->
            <div class="gallery-item">
                <div class="grid-item-holder">
                    <div class="listing-item-grid">
                        <div class="bg"  data-bg="{{asset('assets/front')}}/images/all/1.jpg"></div>
                        <div class="listing-counter"><span>15 </span> Locations</div>
                        <div class="listing-item-cat">
                            <h3><a href="listing.html">Shop - Store</a></h3>
                            <p>Constant care and attention to the patients makes good record</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- gallery-item end-->
        </div>
        <!-- portfolio end -->
        <a href="listing.html" class="btn  big-btn circle-btn dec-btn  color-bg flat-btn">View All<i class="fa fa-eye"></i></a>
    </div>
</section>
<!-- section end -->
<!--section -->
<section class="gray-section">
    <div class="container">
        <div class="section-title">
            <h2>Popular listings</h2>
            <div class="section-subtitle">Best Listings</div>
            <span class="section-separator"></span>
            <p>Nulla tristique mi a massa convallis cursus. Nulla eu mi magna.</p>
        </div>
    </div>
    <!-- carousel -->
    <div class="list-carousel fl-wrap card-listing ">
        <!--listing-carousel-->
        <div class="listing-carousel  fl-wrap ">
            <!--slick-slide-item-->
            <div class="slick-slide-item">
                <!-- listing-item -->
                <div class="listing-item">
                    <article class="geodir-category-listing fl-wrap">
                        <div class="geodir-category-img">
                            <img src="{{asset('assets/front')}}/images/all/1.jpg" alt="">
                            <div class="overlay"></div>
                            <div class="list-post-counter"><span>4</span><i class="fa fa-heart"></i></div>
                        </div>
                        <div class="geodir-category-content fl-wrap">
                            <a class="listing-geodir-category" href="listing.html">Retail</a>
                            <div class="listing-avatar"><a href="author-single.html"><img src="{{asset('assets/front')}}/images/avatar/1.jpg" alt=""></a>
                                <span class="avatar-tooltip">Added By  <strong>Lisa Smith</strong></span>
                            </div>
                            <h3><a href="listing-single.html">Event in City Mol</a></h3>
                            <p>Sed interdum metus at nisi tempor laoreet.  </p>
                            <div class="geodir-category-options fl-wrap">
                                <div class="listing-rating card-popup-rainingvis" data-starrating2="5">
                                    <span>(7 reviews)</span>
                                </div>
                                <div class="geodir-category-location"><a href="#"><i class="fa fa-map-marker" aria-hidden="true"></i> 27th Brooklyn New York, NY 10065</a></div>
                            </div>
                        </div>
                    </article>
                </div>
                <!-- listing-item end-->
            </div>
            <!--slick-slide-item end-->
            <!--slick-slide-item-->
            <div class="slick-slide-item">
                <!-- listing-item -->
                <div class="listing-item">
                    <article class="geodir-category-listing fl-wrap">
                        <div class="geodir-category-img">
                            <img src="{{asset('assets/front')}}/images/all/1.jpg" alt="">
                            <div class="overlay"></div>
                            <div class="list-post-counter"><span>15</span><i class="fa fa-heart"></i></div>
                        </div>
                        <div class="geodir-category-content fl-wrap">
                            <a class="listing-geodir-category" href="listing.html">Event</a>
                            <div class="listing-avatar"><a href="author-single.html"><img src="{{asset('assets/front')}}/images/avatar/1.jpg" alt=""></a>
                                <span class="avatar-tooltip">Added By  <strong>Mark Rose</strong></span>
                            </div>
                            <h3><a href="listing-single.html">Cafe "Lollipop"</a></h3>
                            <p>Morbi suscipit erat in diam bibendum rutrum in nisl.</p>
                            <div class="geodir-category-options fl-wrap">
                                <div class="listing-rating card-popup-rainingvis" data-starrating2="4">
                                    <span>(17 reviews)</span>
                                </div>
                                <div class="geodir-category-location"><a href="#"><i class="fa fa-map-marker" aria-hidden="true"></i> 27th Brooklyn New York, NY 10065</a></div>
                            </div>
                        </div>
                    </article>
                </div>
                <!-- listing-item end-->
            </div>
            <!--slick-slide-item end-->
            <!--slick-slide-item-->
            <div class="slick-slide-item">
                <!-- listing-item -->
                <div class="listing-item">
                    <article class="geodir-category-listing fl-wrap">
                        <div class="geodir-category-img">
                            <img src="{{asset('assets/front')}}/images/all/1.jpg" alt="">
                            <div class="overlay"></div>
                            <div class="list-post-counter"><span>13</span><i class="fa fa-heart"></i></div>
                        </div>
                        <div class="geodir-category-content fl-wrap">
                            <a class="listing-geodir-category" href="listing.html">Gym </a>
                            <div class="listing-avatar"><a href="author-single.html"><img src="{{asset('assets/front')}}/images/avatar/1.jpg" alt=""></a>
                                <span class="avatar-tooltip">Added By  <strong>Nasty Wood</strong></span>
                            </div>
                            <h3><a href="listing-single.html">Gym In Brooklyn</a></h3>
                            <p>Morbiaccumsan ipsum velit tincidunt . </p>
                            <div class="geodir-category-options fl-wrap">
                                <div class="listing-rating card-popup-rainingvis" data-starrating2="3">
                                    <span>(16 reviews)</span>
                                </div>
                                <div class="geodir-category-location"><a href="#"><i class="fa fa-map-marker" aria-hidden="true"></i> 27th Brooklyn New York, NY 10065</a></div>
                            </div>
                        </div>
                    </article>
                </div>
                <!-- listing-item end-->
            </div>
            <!--slick-slide-item end-->
            <!--slick-slide-item-->
            <div class="slick-slide-item">
                <!-- listing-item -->
                <div class="listing-item">
                    <article class="geodir-category-listing fl-wrap">
                        <div class="geodir-category-img">
                            <img src="{{asset('assets/front')}}/images/all/1.jpg" alt="">
                            <div class="overlay"></div>
                            <div class="list-post-counter"><span>3</span><i class="fa fa-heart"></i></div>
                        </div>
                        <div class="geodir-category-content fl-wrap">
                            <a class="listing-geodir-category" href="listing.html">Shops</a>
                            <div class="listing-avatar"><a href="author-single.html"><img src="{{asset('assets/front')}}/images/avatar/1.jpg" alt=""></a>
                                <span class="avatar-tooltip">Added By  <strong>Nasty Wood</strong></span>
                            </div>
                            <h3><a href="listing-single.html">Shop in Boutique Zone</a></h3>
                            <p>Morbiaccumsan ipsum velit tincidunt . </p>
                            <div class="geodir-category-options fl-wrap">
                                <div class="listing-rating card-popup-rainingvis" data-starrating2="4">
                                    <span>(6 reviews)</span>
                                </div>
                                <div class="geodir-category-location"><a href="#"><i class="fa fa-map-marker" aria-hidden="true"></i> 27th Brooklyn New York, NY 10065</a></div>
                            </div>
                        </div>
                    </article>
                </div>
                <!-- listing-item end-->
            </div>
            <!--slick-slide-item end-->
            <!--slick-slide-item-->
            <div class="slick-slide-item">
                <!-- listing-item -->
                <div class="listing-item">
                    <article class="geodir-category-listing fl-wrap">
                        <div class="geodir-category-img">
                            <img src="{{asset('assets/front')}}/images/all/1.jpg" alt="">
                            <div class="overlay"></div>
                            <div class="list-post-counter"><span>35</span><i class="fa fa-heart"></i></div>
                        </div>
                        <div class="geodir-category-content fl-wrap">
                            <a class="listing-geodir-category" href="listing.html">Cars</a>
                            <div class="listing-avatar"><a href="author-single.html"><img src="{{asset('assets/front')}}/images/avatar/1.jpg" alt=""></a>
                                <span class="avatar-tooltip">Added By  <strong>Kliff Antony</strong></span>
                            </div>
                            <h3><a href="listing-single.html">Best deal For the Cars</a></h3>
                            <p>Lorem ipsum gravida nibh vel velit.</p>
                            <div class="geodir-category-options fl-wrap">
                                <div class="listing-rating card-popup-rainingvis" data-starrating2="5">
                                    <span>(11 reviews)</span>
                                </div>
                                <div class="geodir-category-location"><a href="#"><i class="fa fa-map-marker" aria-hidden="true"></i> 27th Brooklyn New York, NY 10065</a></div>
                            </div>
                        </div>
                    </article>
                </div>
                <!-- listing-item end-->
            </div>
            <!--slick-slide-item end-->
            <!--slick-slide-item-->
            <div class="slick-slide-item">
                <!-- listing-item -->
                <div class="listing-item">
                    <article class="geodir-category-listing fl-wrap">
                        <div class="geodir-category-img">
                            <img src="{{asset('assets/front')}}/images/all/1.jpg" alt="">
                            <div class="overlay"></div>
                            <div class="list-post-counter"><span>553</span><i class="fa fa-heart"></i></div>
                        </div>
                        <div class="geodir-category-content fl-wrap">
                            <a class="listing-geodir-category" href="listing.html">Restourants</a>
                            <div class="listing-avatar"><a href="author-single.html"><img src="{{asset('assets/front')}}/images/avatar/1.jpg" alt=""></a>
                                <span class="avatar-tooltip">Added By  <strong>Adam Koncy</strong></span>
                            </div>
                            <h3><a href="listing-single.html">Luxury Restourant</a></h3>
                            <p>Sed non neque elit. Sed ut imperdie.</p>
                            <div class="geodir-category-options fl-wrap">
                                <div class="listing-rating card-popup-rainingvis" data-starrating2="5">
                                    <span>(7 reviews)</span>
                                </div>
                                <div class="geodir-category-location"><a href="#"><i class="fa fa-map-marker" aria-hidden="true"></i> 27th Brooklyn New York, NY 10065</a></div>
                            </div>
                        </div>
                    </article>
                </div>
                <!-- listing-item end-->
            </div>
            <!--slick-slide-item end-->
        </div>
        <!--listing-carousel end-->
        <div class="swiper-button-prev sw-btn"><i class="fa fa-long-arrow-left"></i></div>
        <div class="swiper-button-next sw-btn"><i class="fa fa-long-arrow-right"></i></div>
    </div>
    <!--  carousel end-->
</section>
<!-- section end -->
<!--section -->
<section class="color-bg">
    <div class="shapes-bg-big"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="images-collage fl-wrap">
                    <div class="images-collage-title">City<span>Book</span></div>
                    <div class="images-collage-main images-collage-item"><img src="{{asset('assets/front')}}/images/avatar/1.jpg" alt=""></div>
                    <div class="images-collage-other images-collage-item" data-position-left="23" data-position-top="10" data-zindex="2"><img src="{{asset('assets/front')}}/images/avatar/1.jpg" alt=""></div>
                    <div class="images-collage-other images-collage-item" data-position-left="62" data-position-top="54" data-zindex="5"><img src="{{asset('assets/front')}}/images/avatar/1.jpg" alt=""></div>
                    <div class="images-collage-other images-collage-item anim-col" data-position-left="18" data-position-top="70" data-zindex="11"><img src="{{asset('assets/front')}}/images/avatar/1.jpg" alt=""></div>
                    <div class="images-collage-other images-collage-item" data-position-left="37" data-position-top="90" data-zindex="1"><img src="{{asset('assets/front')}}/images/avatar/1.jpg" alt=""></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="color-bg-text">
                    <h3>Join our online community</h3>
                    <p>In ut odio libero, at vulputate urna. Nulla tristique mi a massa convallis cursus. Nulla eu mi magna. Etiam suscipit commodo gravida. Lorem ipsum dolor sit amet, conse ctetuer adipiscing elit, sed diam nonu mmy nibh euismod tincidunt ut laoreet dolore magna aliquam erat.</p>
                    <a href="#" class="color-bg-link modal-open">Sign In Now</a>
                </div>
            </div>
        </div>
    </div>
</section>
<!--section   end -->
<!--section -->
<section>
    <div class="container">
        <div class="section-title">
            <h2>How it works</h2>
            <div class="section-subtitle">Discover & Connect </div>
            <span class="section-separator"></span>
            <p>Explore some of the best tips from around the world.</p>
        </div>
        <!--process-wrap  -->
        <div class="process-wrap fl-wrap">
            <ul>
                <li>
                    <div class="process-item">
                        <span class="process-count">01 . </span>
                        <div class="time-line-icon"><i class="fa fa-map-o"></i></div>
                        <h4> Find Interesting Place</h4>
                        <p>Proin dapibus nisl ornare diam varius tempus. Aenean a quam luctus, finibus tellus ut, convallis eros sollicitudin turpis.</p>
                    </div>
                    <span class="pr-dec"></span>
                </li>
                <li>
                    <div class="process-item">
                        <span class="process-count">02 .</span>
                        <div class="time-line-icon"><i class="fa fa-envelope-open-o"></i></div>
                        <h4> Contact a Few Owners</h4>
                        <p>Faucibus ante, in porttitor tellus blandit et. Phasellus tincidunt metus lectus sollicitudin feugiat pharetra consectetur.</p>
                    </div>
                    <span class="pr-dec"></span>
                </li>
                <li>
                    <div class="process-item">
                        <span class="process-count">03 .</span>
                        <div class="time-line-icon"><i class="fa fa-hand-peace-o"></i></div>
                        <h4> Make a Listing</h4>
                        <p>Maecenas pulvinar, risus in facilisis dignissim, quam nisi hendrerit nulla, id vestibulum metus nullam viverra porta.</p>
                    </div>
                </li>
            </ul>
            <div class="process-end"><i class="fa fa-check"></i></div>
        </div>
        <!--process-wrap   end-->
    </div>
</section>
<section class="parallax-section" data-scrollax-parent="true">
    <div class="bg"  data-bg="{{asset('assets/front')}}/images/bg/1.jpg" data-scrollax="properties: { translateY: '100px' }"></div>
    <div class="overlay co lor-overlay"></div>
    <!--container-->
    <div class="container">
        <div class="intro-item fl-wrap">
            <h2>Visit the Best Places In Your City</h2>
            <h3>Find great places , hotels , restourants , shops.</h3>
            <a class="trs-btn" href="#">Add Listing + </a>
        </div>
    </div>
</section>
<!-- section end -->
<!--section -->
<section>
    <div class="container">
        <div class="section-title">
            <h2> Pricing Tables</h2>
            <div class="section-subtitle">cost of our services</div>
            <span class="section-separator"></span>
            <p>Explore some of the best tips from around the city from our partners and friends.</p>
        </div>
        <div class="pricing-wrap fl-wrap">
            <!-- price-item-->
            <div class="price-item">
                <div class="price-head op1">
                    <h3>Basic</h3>
                </div>
                <div class="price-content fl-wrap">
                    <div class="price-num fl-wrap">
                        <span class="curen">$</span>
                        <span class="price-num-item">49</span>
                        <div class="price-num-desc">Per month</div>
                    </div>
                    <div class="price-desc fl-wrap">
                        <ul>
                            <li>One Listing</li>
                            <li>90 Days Availability</li>
                            <li>Non-Featured</li>
                            <li>Limited Support</li>
                        </ul>
                        <a href="#" class="price-link">Choose Basic</a>
                    </div>
                </div>
            </div>
            <!-- price-item end-->
            <!-- price-item-->
            <div class="price-item best-price">
                <div class="price-head op2">
                    <h3>Extended</h3>
                </div>
                <div class="price-content fl-wrap">
                    <div class="price-num fl-wrap">
                        <span class="curen">$</span>
                        <span class="price-num-item">99</span>
                        <div class="price-num-desc">Per month</div>
                    </div>
                    <div class="price-desc fl-wrap">
                        <ul>
                            <li>Ten Listings</li>
                            <li>Lifetime Availability</li>
                            <li>Featured In Search Results</li>
                            <li>24/7 Support</li>
                        </ul>
                        <a href="#" class="price-link">Choose Extended</a>
                        <div class="recomm-price">
                            <i class="fa fa-check"></i>
                            <span class="clearfix"></span>
                            Recommended
                        </div>
                    </div>
                </div>
            </div>
            <!-- price-item end-->
            <!-- price-item-->
            <div class="price-item">
                <div class="price-head">
                    <h3>Professional</h3>
                </div>
                <div class="price-content fl-wrap">
                    <div class="price-num fl-wrap">
                        <span class="curen">$</span>
                        <span class="price-num-item">149</span>
                        <div class="price-num-desc">Per month</div>
                    </div>
                    <div class="price-desc fl-wrap">
                        <ul>
                            <li>Unlimited Listings</li>
                            <li>Lifetime Availability</li>
                            <li>Featured In Search Results</li>
                            <li>24/7 Support</li>
                        </ul>
                        <a href="#" class="price-link">Choose Professional</a>
                    </div>
                </div>
            </div>
            <!-- price-item end-->
        </div>
        <!-- about-wrap end  -->
    </div>
</section>
<!-- section end -->
<!--section -->
<section class="color-bg">
    <div class="shapes-bg-big"></div>
    <div class="container">
        <div class=" single-facts fl-wrap">
            <!-- inline-facts -->
            <div class="inline-facts-wrap">
                <div class="inline-facts">
                    <div class="milestone-counter">
                        <div class="stats animaper">
                            <div class="num" data-content="0" data-num="254">154</div>
                        </div>
                    </div>
                    <h6>New Visiters Every Week</h6>
                </div>
            </div>
            <!-- inline-facts end -->
            <!-- inline-facts  -->
            <div class="inline-facts-wrap">
                <div class="inline-facts">
                    <div class="milestone-counter">
                        <div class="stats animaper">
                            <div class="num" data-content="0" data-num="12168">12168</div>
                        </div>
                    </div>
                    <h6>Happy customers every year</h6>
                </div>
            </div>
            <!-- inline-facts end -->
            <!-- inline-facts  -->
            <div class="inline-facts-wrap">
                <div class="inline-facts">
                    <div class="milestone-counter">
                        <div class="stats animaper">
                            <div class="num" data-content="0" data-num="172">172</div>
                        </div>
                    </div>
                    <h6>Won Awards</h6>
                </div>
            </div>
            <!-- inline-facts end -->
            <!-- inline-facts  -->
            <div class="inline-facts-wrap">
                <div class="inline-facts">
                    <div class="milestone-counter">
                        <div class="stats animaper">
                            <div class="num" data-content="0" data-num="732">732</div>
                        </div>
                    </div>
                    <h6>New Listing Every Week</h6>
                </div>
            </div>
            <!-- inline-facts end -->
        </div>
    </div>
</section>
<!-- section end -->
<!--section -->
<section>
    <div class="container">
        <div class="section-title">
            <h2>Testimonials</h2>
            <div class="section-subtitle">Clients Reviews</div>
            <span class="section-separator"></span>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas in pulvinar neque. Nulla finibus lobortis pulvinar.</p>
        </div>
    </div>
    <!-- testimonials-carousel -->
    <div class="carousel fl-wrap">
        <!--testimonials-carousel-->
        <div class="testimonials-carousel single-carousel fl-wrap">
            <!--slick-slide-item-->
            <div class="slick-slide-item">
                <div class="testimonilas-text">
                    <div class="listing-rating card-popup-rainingvis" data-starrating2="5"> </div>
                    <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi arch itecto beatae vitae dicta sunt explicabo. </p>
                </div>
                <div class="testimonilas-avatar-item">
                    <div class="testimonilas-avatar"><img src="{{asset('assets/front')}}/images/avatar/1.jpg" alt=""></div>
                    <h4>Lisa Noory</h4>
                    <span>Restaurant Owner</span>
                </div>
            </div>
            <!--slick-slide-item end-->
            <!--slick-slide-item-->
            <div class="slick-slide-item">
                <div class="testimonilas-text">
                    <div class="listing-rating card-popup-rainingvis" data-starrating2="4"> </div>
                    <p>Aliquam erat volutpat. Curabitur convallis fringilla diam sed aliquam. Sed tempor iaculis massa faucibus feugiat. In fermentum facilisis massa, a consequat purus viverra.</p>
                </div>
                <div class="testimonilas-avatar-item">
                    <div class="testimonilas-avatar"><img src="{{asset('assets/front')}}/images/avatar/1.jpg" alt=""></div>
                    <h4>Antony Moore</h4>
                    <span>Restaurant Owner</span>
                </div>
            </div>
            <!--slick-slide-item end-->
            <!--slick-slide-item-->
            <div class="slick-slide-item">
                <div class="testimonilas-text">
                    <div class="listing-rating card-popup-rainingvis" data-starrating2="5"> </div>
                    <p>Feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te odio dignissim qui blandit praesent.</p>
                </div>
                <div class="testimonilas-avatar-item">
                    <div class="testimonilas-avatar"><img src="{{asset('assets/front')}}/images/avatar/1.jpg" alt=""></div>
                    <h4>Austin Harisson</h4>
                    <span>Restaurant Owner</span>
                </div>
            </div>
            <!--slick-slide-item end-->
            <!--slick-slide-item-->
            <div class="slick-slide-item">
                <div class="testimonilas-text">
                    <div class="listing-rating card-popup-rainingvis" data-starrating2="4"> </div>
                    <p>Qui sequitur mutationem consuetudium lectorum. Mirum est notare quam littera gothica, quam nunc putamus parum claram seacula quarta decima et quinta decima.</p>
                </div>
                <div class="testimonilas-avatar-item">
                    <div class="testimonilas-avatar"><img src="{{asset('assets/front')}}/images/avatar/1.jpg" alt=""></div>
                    <h4>Garry Colonsi</h4>
                    <span>Restaurant Owner</span>
                </div>
            </div>
            <!--slick-slide-item end-->
        </div>
        <!--testimonials-carousel end-->
        <div class="swiper-button-prev sw-btn"><i class="fa fa-long-arrow-left"></i></div>
        <div class="swiper-button-next sw-btn"><i class="fa fa-long-arrow-right"></i></div>
    </div>
    <!-- carousel end-->
</section>
<!-- section end -->
<!--section -->
<section class="gray-section">
    <div class="container">
        <div class="fl-wrap spons-list">
            <ul class="client-carousel">
                <li><a href="#" target="_blank"><img src="{{asset('assets/front')}}/images/clients/1.png" alt=""></a></li>
                <li><a href="#" target="_blank"><img src="{{asset('assets/front')}}/images/clients/1.png" alt=""></a></li>
                <li><a href="#" target="_blank"><img src="{{asset('assets/front')}}/images/clients/1.png" alt=""></a></li>
                <li><a href="#" target="_blank"><img src="{{asset('assets/front')}}/images/clients/1.png" alt=""></a></li>
                <li><a href="#" target="_blank"><img src="{{asset('assets/front')}}/images/clients/1.png" alt=""></a></li>
                <li><a href="#" target="_blank"><img src="{{asset('assets/front')}}/images/clients/1.png" alt=""></a></li>
            </ul>
            <div class="sp-cont sp-cont-prev"><i class="fa fa-angle-left"></i></div>
            <div class="sp-cont sp-cont-next"><i class="fa fa-angle-right"></i></div>
        </div>
    </div>
</section>
<!-- section end -->
<!--section -->
<section>
    <div class="container">
        <div class="section-title">
            <h2>Tips & Articles</h2>
            <div class="section-subtitle">From the blog.</div>
            <span class="section-separator"></span>
            <p>Browse the latest articles from our blog.</p>
        </div>
        <div class="row home-posts">
            <div class="col-md-4">
                <article class="card-post">
                    <div class="card-post-img fl-wrap">
                        <a href="blog-single.html"><img src="{{asset('assets/front')}}/images/all/1.jpg"   alt=""></a>
                    </div>
                    <div class="card-post-content fl-wrap">
                        <h3><a href="blog-single.html">Gallery Post</a></h3>
                        <p>In ut odio libero, at vulputate urna. Nulla tristique mi a massa convallis cursus. Nulla eu mi magna. Etiam suscipit commodo gravida. </p>
                        <div class="post-author"><a href="#"><img src="{{asset('assets/front')}}/images/avatar/1.jpg" alt=""><span>By , Alisa Noory</span></a></div>
                        <div class="post-opt">
                            <ul>
                                <li><i class="fa fa-calendar-check-o"></i> <span>25 April 2018</span></li>
                                <li><i class="fa fa-eye"></i> <span>264</span></li>
                                <li><i class="fa fa-tags"></i> <a href="#">Photography</a>  </li>
                            </ul>
                        </div>
                    </div>
                </article>
            </div>
            <div class="col-md-4">
                <article class="card-post">
                    <div class="card-post-img fl-wrap">
                        <a href="blog-single.html"><img  src="{{asset('assets/front')}}/images/all/1.jpg"   alt=""></a>
                    </div>
                    <div class="card-post-content fl-wrap">
                        <h3><a href="blog-single.html">Video and gallery post</a></h3>
                        <p>In ut odio libero, at vulputate urna. Nulla tristique mi a massa convallis cursus. Nulla eu mi magna. Etiam suscipit commodo gravida. </p>
                        <div class="post-author"><a href="#"><img src="{{asset('assets/front')}}/images/avatar/1.jpg" alt=""><span>By , Mery Lynn</span></a></div>
                        <div class="post-opt">
                            <ul>
                                <li><i class="fa fa-calendar-check-o"></i> <span>25 April 2018</span></li>
                                <li><i class="fa fa-eye"></i> <span>264</span></li>
                                <li><i class="fa fa-tags"></i> <a href="#">Design</a>  </li>
                            </ul>
                        </div>
                    </div>
                </article>
            </div>
            <div class="col-md-4">
                <article class="card-post">
                    <div class="card-post-img fl-wrap">
                        <a href="blog-single.html"><img  src="{{asset('assets/front')}}/images/all/1.jpg"   alt=""></a>
                    </div>
                    <div class="card-post-content fl-wrap">
                        <h3><a href="blog-single.html">Post Article</a></h3>
                        <p>In ut odio libero, at vulputate urna. Nulla tristique mi a massa convallis cursus. Nulla eu mi magna. Etiam suscipit commodo gravida. </p>
                        <div class="post-author"><a href="#"><img src="{{asset('assets/front')}}/images/avatar/1.jpg" alt=""><span>By , Garry Dee</span></a></div>
                        <div class="post-opt">
                            <ul>
                                <li><i class="fa fa-calendar-check-o"></i> <span>25 April 2018</span></li>
                                <li><i class="fa fa-eye"></i> <span>264</span></li>
                                <li><i class="fa fa-tags"></i> <a href="#">Stories</a>  </li>
                            </ul>
                        </div>
                    </div>
                </article>
            </div>
        </div>
        <a href="blog.html" class="btn  big-btn circle-btn  dec-btn color-bg flat-btn">Read All<i class="fa fa-eye"></i></a>
    </div>
</section>
<!-- section end -->
<!--section -->
<section class="gradient-bg">
    <div class="cirle-bg">
        <div class="bg" data-bg="{{asset('assets/front')}}/images/bg/circle.png"></div>
    </div>
    <div class="container">
        <div class="join-wrap fl-wrap">
            <div class="row">
                <div class="col-md-8">
                    <h3>Do You Have Questions ?</h3>
                    <p>Lorem ipsum dolor sit amet, harum dolor nec in, usu molestiae at no.</p>
                </div>
                <div class="col-md-4"><a href="contacts.html" class="join-wrap-btn">Get In Touch <i class="fa fa-envelope-o"></i></a></div>
            </div>
        </div>
    </div>
</section>
<!-- section end -->
@endsection

@push('scripts')

@endpush
