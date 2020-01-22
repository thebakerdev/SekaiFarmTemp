<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>SekaiFarm - Login</title>
    <meta name="description">

    <!-- Scripts -->
    <link rel="stylesheet" href="{{ asset('css/semantic.min.css') }}">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app" class="ht-100 bg--background-grey">
        <div class="ui grid container ht-100 middle aligned">
            <div class="sixteen wide mobile eight wide tablet seven wide computer column centered">
                <div class="ui card fluid">
                    <div class="content">
                        <div class="header">SekaiFarm {{ __('translations.buttons.login') }}</div>
                    </div>
                    <div class="content">
                        <form method="POST" action="{{ route('admin.login.login') }}" class="ui form" novalidate>
                            @csrf
                            <div class="field @error('username') error @enderror">
                                <label for="username">{{ __('translations.labels.username') }}</label>
                                <input type="text" id="username" name="username" value="{{ old('username') }}" placeholder="{{ __('translations.labels.username') }}" required>
                            </div>
                            <div class="field @error('password') error @enderror">
                                <label for="password">{{ __('translations.labels.password') }}</label>
                                <input type="password" id="password" name="password" value="{{ old('password') }}" placeholder="{{ __('translations.labels.password') }}" required>
                            </div>
                            <button class="ui button button--primary fluid" type="submit">{{ __('translations.buttons.login') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/jquery.3.3.1.min.js') }}"></script>
    <script src="{{ asset('js/semantic.min.js') }}"></script>
</body>
</html>
