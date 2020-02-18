@extends('layouts.user')

@section('page-title', trans('translations.labels.address'))

@section('content')
    <div class="user-dashboard__content-inner user-address">
        <h3 class="user-dashboard__content-heading mb-0">{{ trans('translations.labels.address') }}</h3>
        <address-container 
            :addresses="{{ json_encode($addresses) }}"
            :countries="{{ json_encode($countries) }}"
            :user="{{ json_encode($user) }}">
        </address-container>
    </div>
@endsection