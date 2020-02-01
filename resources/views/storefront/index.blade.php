@extends('layouts.storefront')

@section('page-title', 'Home')

@section('page-style')
    <link rel="stylesheet" href="{{ asset('css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('css/slick-theme.css') }}">
@endsection

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
                                :product="product">
                            </user-registration>
                        @else
                            <a href="{{ route('user.index') }}" class="ui button button--secondary">{{ trans('translations.buttons.go_to_dashboard') }}</a>
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

@section('page-script-after')
    <script>
        $(document).ready(function(){

           /*  $('.ui.form').form({
                fields: {
                    name        : 'empty',
                    country     : 'not[0|country]',
                    state       : 'empty',
                    city        : 'empty',
                    address1    : 'empty',
                    postal      : 'empty',
                    phone       : 'number'
                }
            }); */

           /*  $('#countryDropdown').dropdown({
                onChange: function() {

                    var country = $('#country').val();

                    //set calling code
                    $('#callingCodeDropdown').dropdown('set selected',get_calling_code(country));
                    //trigger change event
                    $('#country').change();

                    remove_error();
                }
            }); */

            $('#form_display_btn').click(function() {
                
                $('.product__form-input').fadeIn();
                
                $(this).fadeOut();
                
                $('#subscribe_btn').fadeIn();
            });

            $('.show_login_btn').click(function() {
                $('#login_modal').modal('show');
            });
        });

        /* Returns calling code value */
        function get_calling_code(country) {
            var callingCodes = {!! json_encode(App\country::getCountryCodes()) !!}

            return callingCodes[country];
        }

         /* Removes error class as semantic does not detect change on error */
         function remove_error() {

            var postal = $('#postal'),
                postalParent = postal.parent('.field'),
                callingCodeParent = $('#callingCodeDropdown').parent('.field');

            if(postalParent.hasClass('error') && (postal.val()).trim() != '') {
                postalParent.removeClass('error');
            }

            if(callingCodeParent.hasClass('error')) {
                callingCodeParent.removeClass('error');
            }

        }
    </script>
@endsection
