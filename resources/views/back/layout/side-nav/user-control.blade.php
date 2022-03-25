<li>
    <a href="index.html" class="side-menu {{request()->is('dashboard')? 'side-menu--active':''}}">
        <div class="side-menu__icon"> <i data-feather="home"></i> </div>
        <div class="side-menu__title"> Dashboard </div>
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
