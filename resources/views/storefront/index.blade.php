@extends('layouts.storefront')

@section('page-title', 'Home')

@section('content')
    @if ($notification = session('notification'))
        <div class="ui container grid">
            <div class="column wide">
                {{ show_notification($notification['message'],$notification['type']) }}
            </div>
        </div>
    @endif
    <div class="ui container grid content-wrapper product centered">
        @if($product != null)
            <div class="row">
                <div class="sixteen wide mobile seven wide tablet seven wide computer column">
                    <div class="product__images">
                        <div class="product__image mb-1">
                            <img src="{{ asset('storage/'.$product->photo) }}" alt="Product Photo">
                        </div>
                    </div>
                </div>
                <div class="sixteen wide mobile seven wide tablet seven wide computer column">
                    <div class="product__info mb-2">
                        <h2 class="product__name mb-2">{{ $product->name }}</h2>
                        <div class="product__price mb-2">
                            ${{ $product->price }} 
                            <span class="ml-h">{{ trans('translations.texts.free_shipping') }}</span>
                            <input ref="price" type="hidden" value="{{ $product->price}}">
                        </div>
                        <div class="product__description mb-2">
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolores praesentium nostrum natus quibusdam doloribus itaque. Aspernatur rem quod quibusdam maiores!</p>
                        </div>
                        @if (auth()->user() === null)
                            <div class="product__qty mb-2">
                                <label for="qty">{{ trans('translations.headings.qty') }}</label>
                                <div class="ui mini input">
                                    <input type="number" id="qty" class="input" min="1" v-model="product.qty">
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="mb-2">
                        @if (auth()->user() === null)
                            <user-registration 
                                :action-url="'{{ route('user.store') }}'"
                                :validation-url="'{{ route('user.validate') }}'"
                                :stripe-key="'{{ $stripe_key }}'" 
                                :client-secret="'{{ $payment_intent->client_secret}}'"
                                :product="{{ json_encode($product) }}"
                                :qty="product.qty"
                                :countries="{{ json_encode($supported_countries) }}">
                            </user-registration>
                        @else
                            <a href="{{ route('user.orders.index') }}" class="ui button button--secondary">{{ trans('translations.buttons.go_to_dashboard') }}</a>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

@section('page-script-before')
    <script src="https://js.stripe.com/v3/"></script>
    <script src="{{ route('locale.localizeForJs') }}"></script>
@endsection

