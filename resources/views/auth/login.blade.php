@extends('back.layout.app')

@section('content')
<div class="hidden xl:flex flex-col min-h-screen">
    <a href="" class="-intro-x flex items-center pt-5">
        <img alt="Dashboard BNPP" class="w-10" src="{{asset('assets/logo')}}/bnpp.png">
        <span class="text-white text-lg ml-3"> BNPP</span>
    </a>
    <div class="my-auto">
        <img alt="Dashboard BNPP" class="-intro-x w-40 -mt-16" src="{{asset('assets/logo')}}/bnpp.png">
        <div class="-intro-x text-white font-medium text-4xl leading-tight mt-10">
            Badan Nasional Pengelola Perbatasan
            <br>
            Republik Indonesia
        </div>
        <div class="-intro-x mt-5 text-lg text-white dark:text-gray-500">Silakan Login untuk dapat mengakses dashboard admin</div>
    </div>
</div>
<!-- END: Login Info -->
<!-- BEGIN: Login Form -->
<div class="h-screen xl:h-auto flex py-5 xl:py-0 my-10 xl:my-0">
    <div class="my-auto mx-auto xl:ml-20 bg-white xl:bg-transparent px-5 sm:px-8 py-8 xl:p-0 rounded-md shadow-md xl:shadow-none w-full sm:w-3/4 lg:w-2/4 xl:w-auto">
        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <h2 class="intro-x font-bold text-2xl xl:text-3xl text-center xl:text-left">
                Sign In
            </h2>
            <div class="intro-x mt-2 text-gray-500 xl:hidden text-center">A few more clicks to sign in to your account. Manage all your e-commerce accounts in one place</div>
            <div class="intro-x mt-8">
                <input type="email" class="intro-x login__input input input--lg border border-gray-300 block" placeholder="Email" name="email" :value="old('email')" required autofocus>
                <input type="password" class="intro-x login__input input input--lg border border-gray-300 block mt-4" placeholder="Password" name="password" required autocomplete="current-password" >
            </div>
            {{-- <div class="intro-x flex text-gray-700 dark:text-gray-600 text-xs sm:text-sm mt-4">
                <div class="flex items-center mr-auto">
                    <input type="checkbox" class="input border mr-2" id="remember-me" name="remember">
                    <label class="cursor-pointer select-none" for="remember-me">Remember me</label>
                </div>
                <a href="">Forgot Password?</a>
            </div> --}}
            <div class="intro-x mt-5 xl:mt-8 text-center xl:text-left">
                <button class="button button--lg w-full xl:w-32 text-white bg-theme-1 xl:mr-3 align-top" stype="submit">Login</button>
                {{-- <button class="button button--lg w-full xl:w-32 text-gray-700 border border-gray-300 dark:border-dark-5 dark:text-gray-300 mt-3 xl:mt-0 align-top">Sign up</button> --}}
            </div>
            {{-- <div class="intro-x mt-10 xl:mt-24 text-gray-700 dark:text-gray-600 text-center xl:text-left">
                By signin up, you agree to our
                <br>
                <a class="text-theme-1 dark:text-theme-10" href="">Terms and Conditions</a> & <a class="text-theme-1 dark:text-theme-10" href="">Privacy Policy</a>
            </div> --}}
        </form>
    </div>
</div>
@endsection


{{-- <x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <x-jet-authentication-card-logo />
        </x-slot>

        <x-jet-validation-errors class="mb-4" />


        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-jet-label for="email" value="{{ __('Email') }}" />
                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <div class="mt-4">
                <x-jet-label for="password" value="{{ __('Password') }}" />
                <x-jet-input id="password" class="block mt-1 w-full" type="password"/>
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <input id="remember_me" type="checkbox" class="form-checkbox" name="remember">
                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-jet-button class="ml-4">
                    {{ __('Login') }}
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout> --}}
