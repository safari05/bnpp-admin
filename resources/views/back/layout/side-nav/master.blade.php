<li>
    <a href="{{route('dashboard')}}" class="side-menu {{request()->is('dashboard')? 'side-menu--active':''}}">
        <div class="side-menu__icon"> <i data-feather="home"></i> </div>
        <div class="side-menu__title"> Dashboard </div>
    </a>
</li>
<li>
    <a href="{{route('dash.map.index')}}" class="side-menu {{request()->is('dash/map*')? 'side-menu--active':''}}">
        <div class="side-menu__icon"> <i data-feather="map"></i> </div>
        <div class="side-menu__title"> Peta Sebaran </div>
    </a>
</li>
<li>
    <a class="side-menu {{request()->is('master/*')? 'side-menu--active':''}}">
        <div class="side-menu__icon"> <i data-feather="database"></i> </div>
        <div class="side-menu__title"> Master Data <i data-feather="chevron-down" class="side-menu__sub-icon"></i> </div>
    </a>
    <ul class="{{request()->is('master/*')? 'side-menu__sub-open':''}}">
        <li>
            <a href="{{route('master.prov')}}" class="side-menu {{request()->is('master/provinsi')? 'side-menu--active':''}}">
                <div class="side-menu__icon"> <i data-feather="slack"></i> </div>
                <div class="side-menu__title"> Provinsi </div>
            </a>
        </li>
        <li>
            <a href="{{route('master.kota')}}" class="side-menu {{request()->is('master/kota')? 'side-menu--active':''}}">
                <div class="side-menu__icon"> <i data-feather="package"></i> </div>
                <div class="side-menu__title"> Kota / Kabupaten </div>
            </a>
        </li>
        <li>
            <a href="{{route('master.kec')}}" class="side-menu {{request()->is('master/kecamatan')? 'side-menu--active':''}}">
                <div class="side-menu__icon"> <i data-feather="codesandbox"></i> </div>
                <div class="side-menu__title"> Kecamatan </div>
            </a>
        </li>
        <li>
            <a href="{{route('master.desa')}}" class="side-menu {{request()->is('master/desa')? 'side-menu--active':''}}">
                <div class="side-menu__icon"> <i data-feather="codepen"></i> </div>
                <div class="side-menu__title"> Desa / Kelurahan </div>
            </a>
        </li>
        <li>
            <a href="{{route('master.aset')}}" class="side-menu {{request()->is('master/aset')? 'side-menu--active':''}}">
                <div class="side-menu__icon"> <i data-feather="folder"></i> </div>
                <div class="side-menu__title"> Aset Master </div>
            </a>
        </li>
        <li>
            <a href="{{route('master.mobilitas')}}" class="side-menu {{request()->is('master/mobilitas')? 'side-menu--active':''}}">
                <div class="side-menu__icon"> <i data-feather="truck"></i> </div>
                <div class="side-menu__title"> Mobilitas Master </div>
            </a>
        </li>
        <li>
            <a href="{{route('master.pondes')}}" class="side-menu {{request()->is('master/pondes')? 'side-menu--active':''}}">
                <div class="side-menu__icon"> <i data-feather="triangle"></i> </div>
                <div class="side-menu__title"> Potensi Desa </div>
            </a>
        </li>
    </ul>
</li><li>
    <a class="side-menu {{request()->is('kepdata/*')? 'side-menu--active':''}}">
        <div class="side-menu__icon"> <i data-feather="smile"></i> </div>
        <div class="side-menu__title"> Master Kepegawaian <i data-feather="chevron-down" class="side-menu__sub-icon"></i> </div>
    </a>
    <ul class="{{request()->is('kepdata/*')? 'side-menu__sub-open':''}}">
        <li>
            <a href="{{route('master.kep.lembaga')}}" class="side-menu {{request()->is('kepdata/lembaga')? 'side-menu--active':''}}">
                <div class="side-menu__icon"> <i data-feather="users"></i> </div>
                <div class="side-menu__title"> Kelembagaan </div>
            </a>
        </li>
        <li>
            <a href="{{route('master.kep.operasional')}}" class="side-menu {{request()->is('kepdata/operasional')? 'side-menu--active':''}}">
                <div class="side-menu__icon"> <i data-feather="user"></i> </div>
                <div class="side-menu__title"> Staff Operasional </div>
            </a>
        </li>
    </ul>
</li>
{{-- Menu Kelola Kecamatan --}}
<li>
    <a href="{{route('kec.index')}}" class="side-menu {{request()->is('kecamatan*')? 'side-menu--active':''}}">
        <div class="side-menu__icon"> <i data-feather="layers"></i> </div>
        <div class="side-menu__title"> Infrastruktur Kecamatan </div>
    </a>
</li>
<li>
    <a href="{{route('desa.index')}}" class="side-menu {{request()->is('desa*')? 'side-menu--active':''}}">
        <div class="side-menu__icon"> <i data-feather="package"></i> </div>
        <div class="side-menu__title"> Infrastruktur Desa </div>
    </a>
</li>
<li>
    <a class="side-menu {{request()->is('dokumen*')? 'side-menu--active':''}}">
        <div class="side-menu__icon"> <i data-feather="archive"></i> </div>
        <div class="side-menu__title"> Dokumen <i data-feather="chevron-down" class="side-menu__sub-icon"></i> </div>
    </a>
    <ul class="{{request()->is('dokumen*')? 'side-menu__sub-open':''}}">
        <li>
            <a href="{{route('dok.manage.index')}}" class="side-menu {{(request()->is('dokumen/manage*'))? 'side-menu--active':''}}">
                <div class="side-menu__icon"> <i data-feather="file-text"></i> </div>
                <div class="side-menu__title"> Kelola Dokumen </div>
            </a>
        </li>
        <li>
            <a href="{{route('dok.kategori.index')}}" class="side-menu {{(request()->is('dokumen/kategori*'))? 'side-menu--active':''}}">
                <div class="side-menu__icon"> <i data-feather="bookmark"></i> </div>
                <div class="side-menu__title"> Kelola Kategori </div>
            </a>
        </li>
        <li>
            <a href="{{route('dok.pengajuan.index')}}" class="side-menu {{(request()->is('dokumen/pengajuan'))? 'side-menu--active':''}}">
                <div class="side-menu__icon"> <i data-feather="file-text"></i> </div>
                <div class="side-menu__title"> Pengajuan Dokumen </div>
            </a>
        </li>
        <li>
            <a href="{{route('dok.pengajuan.history')}}" class="side-menu {{(request()->is('dokumen/pengajuan/history'))? 'side-menu--active':''}}">
                <div class="side-menu__icon"> <i data-feather="file-text"></i> </div>
                <div class="side-menu__title"> Riwayat Pengajuan Dokumen </div>
            </a>
        </li>
    </ul>
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
<li>
    <a class="side-menu {{request()->is('plb/*')? 'side-menu--active':''}}">
        <div class="side-menu__icon"> <i data-feather="git-branch"></i> </div>
        <div class="side-menu__title"> Pos Lintas Batas <i data-feather="chevron-down" class="side-menu__sub-icon"></i> </div>
    </a>
    <ul class="{{request()->is('plb/*')? 'side-menu__sub-open':''}}">
        <li>
            <a href="{{route('plb.log.index')}}" class="side-menu {{(request()->is('plb/log*'))? 'side-menu--active':''}}">
                <div class="side-menu__icon"> <i data-feather="truck"></i> </div>
                <div class="side-menu__title"> Kelola Catatan Pos Lintas Batas </div>
            </a>
        </li>
        <li>
            <a href="{{route('plb.master.index')}}" class="side-menu {{(request()->is('plb/master*'))? 'side-menu--active':''}}">
                <div class="side-menu__icon"> <i data-feather="compass"></i> </div>
                <div class="side-menu__title"> Kelola Pos Lintas Batas </div>
            </a>
        </li>
    </ul>
</li>
<li>
    <a href="{{route('monev.index')}}" class="side-menu {{request()->is('monev*')? 'side-menu--active':''}}">
        <div class="side-menu__icon"> <i data-feather="pocket"></i> </div>
        <div class="side-menu__title"> Monev </div>
    </a>
</li>
<li class="side-nav__devider my-6"></li>
<li>
    <a class="side-menu {{request()->is('users*')? 'side-menu--active':''}}">
        <div class="side-menu__icon"> <i data-feather="sliders"></i> </div>
        <div class="side-menu__title"> Pengaturan <i data-feather="chevron-down" class="side-menu__sub-icon"></i> </div>
    </a>
    <ul class="{{request()->is('users*')? 'side-menu__sub-open':''}}">
        <li>
            <a href="{{route('users.index')}}" class="side-menu {{(request()->is('users') || request()->is('users/*'))? 'side-menu--active':''}}">
                <div class="side-menu__icon"> <i data-feather="users"></i> </div>
                <div class="side-menu__title"> Kelola User </div>
            </a>
        </li>
    </ul>
</li>
