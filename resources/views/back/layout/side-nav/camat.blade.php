<li>
    <a href="index.html" class="side-menu {{request()->is('dashboard')? 'side-menu--active':''}}">
        <div class="side-menu__icon"> <i data-feather="home"></i> </div>
        <div class="side-menu__title"> Dashboard </div>
    </a>
</li>
<li>
    <a class="side-menu {{request()->is('master/*')? 'side-menu--active':''}}">
        <div class="side-menu__icon"> <i data-feather="database"></i> </div>
        <div class="side-menu__title"> Master Data <i data-feather="chevron-down" class="side-menu__sub-icon"></i> </div>
    </a>
    <ul class="{{request()->is('master/*')? 'side-menu__sub-open':''}}">
        <li>
            <a href="{{route('master.desa')}}" class="side-menu {{request()->is('master/desa')? 'side-menu--active':''}}">
                <div class="side-menu__icon"> <i data-feather="activity"></i> </div>
                <div class="side-menu__title"> Desa / Kelurahan </div>
            </a>
        </li>
    </ul>
</li>
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
