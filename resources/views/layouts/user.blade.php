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
    <div id="app-user" class="site-wrapper ht-100">
        <div class="main-content">
            <header class="site-header ui container grid pb-2">
                <div class="row centered">
                    <div class="eight wide mobile seven wide tablet seven wide computer column">
                        <h1 class="site-name"><a href="{{ URL::to('/') }}">Sekai<span>Farm</span></a></h1>
                    </div>
                    <div class="eight wide mobile seven wide tablet seven wide computer column middle aligned text-right">
                        <div class="user__menu">
                            <i class="ui icon user circle outline color--green"></i><strong class="mr-1">{{ auth()->user()->email }}</strong><a href="{{ route('user.login.logout') }}">{{ trans('translations.texts.logout') }}</a>
                        </div>
                    </div>
                </div>
            </header>
            <div class="bg--grey-2 pt-2 pb-2">
                <div class="ui grid container">
                    <div class="row centered">
                        <div class="sixteen wide mobile fourteen wide tablet fourteen wide computer column">
                            <div class="user-dashboard ht-100">
                                <aside class="user-dashboard__sidebar panel">
                                    <h3 class="user-dashboard__sidebar-title text-uppercase">{{ trans('translations.headings.menu') }}</h3>
                                    <ul class="user-dashboard__sidebar-links p-0">
                                        <li class="{{ Request::segment(1)=='orders' ? 'active':'' }}"><a href="{{ route('user.orders.index') }}"><i class="box icon"></i> {{ trans('translations.labels.orders') }}</a></li>
                                        <li class="{{ Request::segment(1)=='subscription' ? 'active':'' }}"><a href="{{ route('user.subscription.index') }}"><i class="credit card outline icon"></i> {{ trans('translations.headings.subscription') }}</a></li>
                                        <li class="{{ Request::segment(1)=='account' ? 'active':'' }}"><a href="{{ route('user.account.index') }}"><i class="user circle outline icon"></i> {{ trans('translations.headings.account') }}</a></li>
                                        <li class="{{ Request::segment(1)=='address' ? 'active mb-0':'mb-0' }}"><a href="{{ route('user.address.index') }}"><i class="home icon"></i> {{ trans('translations.labels.address') }}</a></li>
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
        <notifications group="user-notification"
                   position="top right"
                   :max="1"
                   :width="310"
                   :ignore-duplicates="true"
                   :speed="600" />
        <input type="hidden" ref="baseUrl" value="{{ url('/') }}">
    </div>
       
    <script src="{{ asset('js/jquery.3.3.1.min.js') }}"></script>
    <script src="{{ asset('js/semantic.min.js') }}"></script>
    @yield('page-script-before')
    <script src="{{ route('locale.localizeForJs') }}"></script>
    <script src="{{ asset('js/app-user.js') }}" defer></script>
    @yield('page-script-after')
   
</body>
</html>
