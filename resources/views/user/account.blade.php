@extends('layouts.user')

@section('page-title', trans('translations.headings.account'))

@section('content')
    <div class="user-dashboard__content-inner user-account">
        <h3 class="user-dashboard__content-heading">{{ trans('translations.headings.account') }}</h3>
        <account-container 
            :user="{{ $user }}"
            :address-link="'{{ route('user.address.index') }}'">
        </account-container>
    </div>
@endsection