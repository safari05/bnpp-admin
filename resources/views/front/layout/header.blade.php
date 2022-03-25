<header class="main-header dark-header fs-header sticky">
    <div class="header-inner">
        <div class="logo-holder">
            <a href="{{route('home')}}"><img src="{{ asset('/assets/front') }}/images/logo.png" alt=""></a>
        </div>
{{--        <div class="header-search vis-header-search">--}}
{{--            <div class="header-search-input-item">--}}
{{--                <input type="text" placeholder="Keywords" value=""/>--}}
{{--            </div>--}}
{{--            <div class="header-search-select-item">--}}
{{--                <select data-placeholder="All Categories" class="chosen-select" >--}}
{{--                    <option>All Categories</option>--}}
{{--                    <option>Shops</option>--}}
{{--                    <option>Hotels</option>--}}
{{--                    <option>Restaurants</option>--}}
{{--                    <option>Fitness</option>--}}
{{--                    <option>Events</option>--}}
{{--                </select>--}}
{{--            </div>--}}
{{--            <button class="header-search-button" onclick="window.location.href='listing.html'">Search</button>--}}
{{--        </div>--}}
        <a href="{{ url('/login') }}" class="add-list">Masuk <span><i class="fa fa-sign-in"></i></span></a>
        <!-- nav-button-wrap-->
        <div class="nav-button-wrap color-bg">
            <div class="nav-button">
                <span></span><span></span><span></span>
            </div>
        </div>
        <!-- nav-button-wrap end-->
        <!--  navigation -->
        <div class="nav-holder main-menu">
            <nav>
                <ul>
                    <li>
                        <a href="{{route('home')}}" class="{{ request()->is('/') ? 'act-link' : null }}">Beranda</a>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="{{ request()->is('profil*') ? 'act-link' : null }}">Profil BNPP <i class="fa fa-caret-down"></i></a>
                        <!--second level -->
                        <ul>
                            <li><a href="{{route('profil.latar-belakang')}}">Latar Belakang</a></li>
                            <li><a href="{{route('profil.maksud-tujuan')}}">Maksud dan Tujuan</a></li>
                        </ul>
                        <!--second level end-->
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="{{ request()->is('infrastruktur*') ? 'act-link' : null }}">Infrasturktur Perbatasan <i class="fa fa-caret-down"></i></a>
                        <!--second level -->
                        <ul>
                            <li><a href="{{url('infrastruktur-data')}}">Data & Grafik Infrastuktur</a></li>
                            <li><a href="{{url('infrastruktur-peta')}}">Peta Infrastuktur</a></li>
                        </ul>
                        <!--second level end-->
                    </li>
                    <li>
                        <a href="{{ url('download-dokumen') }}" class="{{ request()->is('download-dokumen*') ? 'act-link' : null }}">Download Dokumen</a>
                    </li>
                    <li>
                        <a href="{{ url('berita') }}" class="{{ request()->is('berita*') ? 'act-link' : null }}">Berita</a>
                    </li>
                </ul>
            </nav>
        </div>
        <!-- navigation  end -->
    </div>
</header>
