@extends('layouts.user')

@section('page-title', trans('translations.headings.subscription'))

@section('content')
    <div class="user-dashboard__content-inner user-subscription">
        <h3 class="user-dashboard__content-heading">{{ trans('translations.headings.subscription') }}</h3> 
        <subscription-container 
            :product="{{ $product }}"
            :subscription="{{ $subscription }}"
            :user="{{ $user }}"
            :stripe-key="'{{ $stripe_key }}'"
            :client-secret="'{{ $payment_intent->client_secret }}'"> 
        </subscription-container>
    </div>
@endsection
@section('page-script-before')
    <script src="https://js.stripe.com/v3/"></script>
@endsection