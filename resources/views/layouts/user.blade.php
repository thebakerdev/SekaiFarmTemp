<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    <title>SekaiFarm - @yield('page-title') </title>
    
    <!-- SEO -->
    <meta name="description" content="Description">
    <meta name="Keywords" content="Keywords">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="url">

    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('images/favicon/site.webmanifest') }}">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
    
    @yield('page-style')
    <link rel="stylesheet" href="{{ asset('css/semantic.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
      .ignore-css{all:unset;}
    </style>
</head>
<body>
    <div id="app" class="site-wrapper ht-100">
        <div class="main-content">
            <header class="site-header ui container grid">
                <div class="row centered">
                    <div class="eight wide mobile seven wide tablet seven wide computer column">
                        <h1 class="site-name"><a href="{{ URL::to('/') }}">Sekai<span>Farm</span></a></h1>
                    </div>
                    <div class="eight wide mobile seven wide tablet seven wide computer column middle aligned text-right">
                        @if(Route::getCurrentRoute()->uri() == '/')
                            <!-- <span id="show-cart-button" class="cart-link"><i class="large shopping cart icon"></i><span class="cart-link__count" v-if="qty.length" v-cloak>@{{ qty }}</span></span> -->
                            @if (null)
                                <button class="ui tiny primary button button--secondary show_login_btn">{{ __('translations.texts.sign_in') }}</button>
                            @else
                                <div class="user__menu">
                                    <i class="ui icon user circle outline color--green"></i><a href="{{ route('user.index') }}" class="mr-1">{{ trans('translations.texts.my_dashboard') }}</a><a href="{{ route('user.login.logout') }}">{{ trans('translations.texts.logout') }}</a>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </header>
            <div class="bg--grey-2 pt-2 pb-2">
                <div class="ui grid container">
                    <div class="row centered">
                        <div class="sixteen wide mobile fourteen wide tablet fourteen wide computer column">
                            <div class="user-dashboard ht-100">
                                <aside class="user-dashboard__sidebar panel">
                                    <h3 class="user-dashboard__sidebar-title text-uppercase">Menu</h3>
                                    <ul class="user-dashboard__sidebar-links p-0">
                                        <li class="active"><a href="#"><i class="box icon"></i> Orders</a></li>
                                        <li><a href="#"><i class="credit card outline icon"></i> Subscription</a></li>
                                        <li><a href="#"><i class="user circle outline icon"></i> Account</a></li>
                                        <li class="mb-0"><a href="#"><i class="home icon"></i> Address</a></li>
                                    </ul>
                                </aside>
                                <section class="user-dashboard__content panel">
                                    @yield('content')
                                </section>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer class="footer ui container">
            @include('partials.user.footer')
        </footer>
        <input type="hidden" ref="baseUrl" value="{{ url('/') }}">
        @include('layouts.modals.loginModal')
    </div>
       
    <script src="{{ asset('js/jquery.3.3.1.min.js') }}"></script>
    <script src="{{ asset('js/semantic.min.js') }}"></script>
    @yield('page-script-before')
    <script src="{{ asset('js/app.js') }}" defer></script>
    @yield('page-script-after')
   
</body>
</html>
