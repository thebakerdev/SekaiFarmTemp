@extends('layouts.storefront')

@section('page-title', 'Confirmed')

@section('content')
    <div class="ui container grid content-wrapper">
        <div class="sixteen wide mobile eight wide tablet eight wide computer column centered middle aligned">
            <div class="text-center payment-success">
                <h2>{{ trans('translations.texts.subscription_success') }}</h2>
                <p>{!! trans('translations.texts.subscription_success_message',['qty' => $qty, 'product' => $product_name, 'total' => '$'.$total]) !!}</p>
                <table class="ui table">
                    <tr>
                        <td>{{ $product_name }}</td>
                        <td class="text-right">${{ $product_price }} X {{ $qty }}</td>
                    </tr>
                    <tr>
                        <td>{{ __('translations.texts.total') }}</td>
                        <td class="text-right"><strong>${{ $total }}</strong></td>
                    </tr>
                </table>
                <button type="button" class="ui button button--secondary mt-2 show_login_btn">{{ trans('translations.texts.sign_in') }}</button>
            </div>
        </div>
    </div>
@endsection
@section('page-script-before')
    <script src="{{ route('locale.localizeForJs') }}"></script>
@endsection