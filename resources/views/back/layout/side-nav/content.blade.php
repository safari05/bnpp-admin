<li>
    <a href="index.html" class="side-menu {{request()->is('dashboard')? 'side-menu--active':''}}">
        <div class="side-menu__icon"> <i data-feather="home"></i> </div>
        <div class="side-menu__title"> Dashboard </div>
    </a>
</li>
<li>
    <a class="side-menu {{request()->is('konten*')? 'side-menu--active':''}}">
        <div class="side-menu__icon"> <i data-feather="image"></i> </div>
        <div class="side-menu__title"> Konten <i data-feather="chevron-down" class="side-menu__sub-icon"></i> </div>
    </a>
    <ul class="{{request()->is('konten*')? 'side-menu__sub-open':''}}">
        <li>
            <a href="{{route('konten.berita.index')}}" class="side-menu {{(request()->is('konten/berita*'))? 'side-menu--active':''}}">
                <div class="side-menu__icon"> <i data-feather="file-text"></i> </div>
                <div class="side-menu__title"> Kelola Berita / Kegiatan </div>
            </a>
        </li>
        <li>
            <a href="{{route('konten.static.index')}}" class="side-menu {{(request()->is('konten/static*'))? 'side-menu--active':''}}">
                <div class="side-menu__icon"> <i data-feather="smile"></i> </div>
                <div class="side-menu__title"> Kelola Profil </div>
            </a>
        </li>
    </ul>
</li>
