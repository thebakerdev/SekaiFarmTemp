@extends('layouts.storefront')

@section('page-title', 'Confirmed')

@section('content')
    <div class="ui container grid content-wrapper">
        <div class="sixteen wide mobile eight wide tablet eight wide computer column centered middle aligned">
            <div class="text-center payment-success">
                <h2>{{ trans('translations.texts.subscription_success') }}</h2>
                <p>{!! trans('translations.texts.subscription_success_message',['qty' => 3, 'product' => 'Biodegradable Grain Bag', 'total' => '$300']) !!}</p>
                <table class="ui table">
                    <tr>
                        <td>Biodegradable Grain Bag</td>
                        <td class="text-right">$100 X 3</td>
                    </tr>
                    <tr>
                        <td>{{ __('translations.texts.total') }}</td>
                        <td class="text-right"><strong>$300</strong></td>
                    </tr>
                </table>
                <a href="{{ route('user.index') }}" class="ui button button--secondary mt-2">{{ trans('translations.buttons.go_to_dashboard') }}</a>
            </div>
        </div>
    </div>
    <input type="hidden" ref="paymentConfirmed" value="1">
@endsection
