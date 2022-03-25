<nav class="side-nav {{request()->is('dash/map*')? 'side-nav--simple':''}}">
    <a href="" class="intro-x flex items-center pl-5 pt-4">
        <img alt="Dashboard BNPP" class="w-10" src="{{asset('assets/logo')}}/bnpp.png">
        @if(!request()->is('dash/map*'))
        <span class="hidden xl:block text-white text-lg ml-3"> BNPP </span>
        @endif
    </a>
    <div class="side-nav__devider my-6"></div>
    <ul>
        @if(Auth::user()->idrole == 1)
        @include('back.layout.side-nav.master')
        @endif

        @if(Auth::user()->idrole == 2)
        @include('back.layout.side-nav.master')
        @endif

        @if(Auth::user()->idrole == 3)
        @include('back.layout.side-nav.user-control')
        @endif

        @if(Auth::user()->idrole == 4)
        @include('back.layout.side-nav.content')
        @endif

        @if(Auth::user()->idrole == 5)
        @include('back.layout.side-nav.camat')
        @endif
    </ul>
</nav>
