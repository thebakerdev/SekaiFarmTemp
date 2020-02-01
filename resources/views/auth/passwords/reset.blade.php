@extends('layouts.storefront')

@section('page-title', 'Reset Password')

@section('content')
<div class="ui container grid content-wrapper">
    <div class="sixteen wide mobile eight wide tablet eight wide computer column centered middle aligned">
        <div class="user-auth">
            <h5 class="ui user-auth__title">{{ trans('translations.texts.change_password') }}</h5>
            <form method="POST" action="{{ route('password.update') }}" class="ui form">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <div class="field @error('email') error @enderror">
                    <label for="email">{{ trans('translations.labels.email') }}</label>
                    <input type="email" id="email" name="email" value="{{old('email')}}">
                </div>
                <div class="field @error('password') error @enderror">
                    <label for="password">{{ trans('translations.labels.password') }}</label>
                    <input type="password" id="password" name="password">
                </div>
                <div class="field {{ ($errors->first('name')) ? 'error' : '' }}">
                    <label for="password_confirmation">{{ trans('translations.labels.confirm_password') }}</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" value="{{old('name')}}">
                </div>
                <div class="field">
                    <button id="subscribe_btn" type="submit" class="ui large button button--primary">{{ trans('translations.texts.reset_password') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
