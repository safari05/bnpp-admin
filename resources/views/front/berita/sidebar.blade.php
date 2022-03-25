<div class="box-widget-wrap">
    <!--box-widget-item -->
    <div class="box-widget-item fl-wrap">
        <div class="box-widget-item-header">
            <h3>Cari Berita : </h3>
        </div>
        <div class="box-widget search-widget">
            <form action="" class="fl-wrap">
                <input name="cari" id="cari" type="text" class="search" placeholder="Kata kunci..." value="{{ @request()->cari }}" />
                <button class="search-submit" id="submit_btn"><i class="fa fa-search transition"></i> </button>
            </form>
        </div>
    </div>
    <!--box-widget-item end -->
{{--    <!--box-widget-item -->--}}
{{--    <div class="box-widget-item fl-wrap">--}}
{{--        <div class="box-widget-item-header">--}}
{{--            <h3>Tags: </h3>--}}
{{--        </div>--}}
{{--        <div class="list-single-tags tags-stylwrap">--}}
{{--            <a href="{{ url('/berita') }}">COViD-19</a>--}}
{{--            <a href="{{ url('/berita') }}">Joko Widodo</a>--}}
{{--            <a href="{{ url('/berita') }}">Daya Beli</a>--}}
{{--            <a href="{{ url('/berita') }}">Masyarakat</a>--}}
{{--            <a href="{{ url('/berita') }}">Trending</a>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    <!--box-widget-item end -->--}}
    <!--box-widget-item -->
    <div class="box-widget-item fl-wrap">
        <div class="box-widget-item-header">
            <h3>Berita Terbaru : </h3>
        </div>
        <div class="box-widget widget-posts blog-widgets">
            <div class="box-widget-content">
                <ul>
                    @foreach($beritaTerbaru as $row)
                    <li class="clearfix">
                        <a href="{{ url('/berita/'.$row->slug) }}" class="widget-posts-img"><img src="{{asset('upload/content/'.$row->slug.'/'.$row->poster)}}" onerror="this.src='{{ asset('assets/front/images/broken.jpg') }}'" alt=""></a>
                        <div class="widget-posts-descr">
                            <a href="{{ url('/berita/'.$row->slug) }}" title="{{ $row->judul }}">{{ $row->judul }}</a>
                            <span class="widget-posts-date"><i class="fa fa-calendar-check-o"></i> {{ date('d M Y', strtotime($row->created_at)) }} </span>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    <div class="box-widget-item fl-wrap">
        <div class="box-widget-item-header">
            <h3>Kategori : </h3>
        </div>
        <div class="box-widget">
            <div class="box-widget-content">
                <ul class="cat-item">
                    @foreach($kategori as $row)
                    <li><a href="{{ url('/berita?kategori='.$row->idcategory) }}">{{ $row->nama }}</a> <span>({{ @$row->content ? $row->content->count() : 0 }})</span></li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    <!--box-widget-item end -->
</div>
