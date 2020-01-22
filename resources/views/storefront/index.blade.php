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
            @php ( $currency =  'USD' )
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
                        <form method="POST" action="{{ route('user.store') }}" class="ui form product__form">
                            @csrf
                            <div class="mb-2 product__form-input">
                                <div class="ui divider mt-2 mb-2"></div>
                                <fieldset class="mb-2">
                                    <legend>{{ trans('translations.headings.basic_info') }}</legend>
                                    <div class="field {{ ($errors->first('name')) ? 'error' : '' }}">
                                        <label for="name">{{ trans('translations.labels.name') }}</label>
                                        <input type="text" id="name" name="name" value="{{old('name')}}">
                                    </div>
                                    <div class="field {{ ($errors->first('email')) ? 'error' : '' }}">
                                        <label for="email">{{ trans('translations.labels.email') }}</label>
                                        <input type="email" id="email" name="email" value="{{old('email')}}">
                                    </div>
                                    <div class="field {{ ($errors->first('password')) ? 'error' : '' }}">
                                        <label for="password">{{ trans('translations.labels.password') }}</label>
                                        <input type="password" id="password" name="password">
                                    </div>
                                    <div class="field">
                                        <label for="password_confirmation">{{ trans('translations.labels.confirm_password') }}</label>
                                        <input type="password" id="password_confirmation" name="password_confirmation">
                                    </div>
                                    <div class="field">
                                        <label for="password_confirmation">{{ trans('translations.labels.credit_card') }}</label>
                                        <input type="text" id="card" name="card">
                                    </div>
                                </fieldset>
                                <fieldset>
                                    <legend>{{ trans('translations.headings.shipping_details') }}</legend>
                                    <div class="field">
                                        <div class="two fields">
                                            <div class="eight wide field {{ ($errors->first('country')) ? 'error' : '' }}">
                                                <label for="country">{{ trans('translations.labels.country') }}</label>
                                                <div id="countryDropdown" class="ui fluid selection dropdown">
                                                    <input id="country" type="hidden" name="country" value="{{ old('country','0|Country') }}">
                                                    <i class="dropdown icon"></i>
                                                    <div class="default text">{{ trans('translations.labels.country') }}</div>
                                                    <div class="menu">
                                                        @if($supported_countries->count())
                                                            @foreach($supported_countries as $supported_country)
                                                                <div class="item" data-value="{{ $supported_country->name }}">{{ $supported_country->name }}</div>
                                                            @endforeach
                                                        @else
                                                            <div class="item" data-value="United States">United States</div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="eight wide field {{ ($errors->first('state')) ? 'error' : '' }}">
                                                <label for="state">{{ trans('translations.labels.state') }}</label>
                                                <input type="text" id="state" class="input" name="state" value="{{ old('state') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="field">
                                        <div class="two fields">
                                            <div class="eight wide field {{ ($errors->first('city')) ? 'error' : '' }}">
                                                <label for="city">{{ trans('translations.labels.city') }}</label>
                                                <input type="text" id="city" class="input" name="city" value="{{ old('city') }}">
                                            </div>
                                            <div class="eight wide field {{ ($errors->first('postal')) ? 'error' : '' }}">
                                                <label for="postal">{{ trans('translations.labels.postal') }}</label>
                                                <input type="text" id="postal" class="input" name="postal" value="{{ old('postal','') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="field {{ ($errors->first('address1')) ? 'error' : '' }}">
                                        <label for="address1">{{ trans('translations.labels.address_1') }}</label>
                                        <input type="text" id="address1" class="input" name="address1" value="{{ old('address1') }}">
                                    </div>
                                    <div class="field">
                                        <label for="address2">{{ trans('translations.labels.address_2') }}</label>
                                        <input type="text" id="address2" class="input" name="address2" value="{{ old('address2') }}">
                                    </div>
                                    <div class="field {{ ($errors->first('phone')) ? 'error' : '' }}">
                                        <label for="phone">{{ trans('translations.labels.phone') }} <small>({{trans('translations.labels.phone_tracking')}})</small></label>
                                        <div class="two fields">
                                            <div class="five wide field {{ ($errors->first('callingCode')) ? 'error' : '' }}">
                                                <div id="callingCodeDropdown" class="ui fluid selection dropdown">
                                                    <input id="callingCode" type="hidden" name="calling_code" value="{{ old('calling_code', '') }}">
                                                    <i class="dropdown icon"></i>
                                                    <div class="default text">{{ trans('translations.labels.code') }}</div>
                                                    <div class="menu">
                                                        @if($supported_countries->count())
                                                            @foreach($supported_countries as $supported_country)
                                                                <div class="item" data-value="{{ $supported_country->calling_code }}"><i class="{{ $supported_country->iso }} flag"></i>{{ $supported_country->calling_code }}</div>
                                                            @endforeach
                                                        @else
                                                            <div class="item" data-value="+1"><i class="us flag"></i>+1</div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="eleven wide field {{ ($errors->first('phone')) ? 'error' : '' }}">
                                                <input type="text"  class="input" name="phone" value="{{ old('phone') }}" @keypress="isNumber($event)" onCopy="return false" onDrag="return false" onDrop="return false" onPaste="return false">
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                                <input type="hidden" v-model="product.qty" name="qty">
                                <div class="product__total">
                                    {{ trans('translations.texts.total') }} $@{{product.price}} x @{{ product.qty}} = <strong>$@{{total}}</strong> / {{ trans('translations.texts.per_month') }}
                                </div>
                            </div>
                            
                            <div class="product__action" v-cloak>
                                @if (auth()->user() === null)
                                    <button id="subscribe_btn" type="submit" class="ui large button button--primary">{{ trans('translations.buttons.subscribe') }}</button>
                                    <button id="form_display_btn" type="button" class="ui large button button--primary">$@{{ total }}/ <small class="text-normal">{{ trans('translations.texts.per_month') }}</small></button><span class="no-wrap">{{ trans('translations.texts.already_subscribed') }} <a href="#" class="text-bold color--yellow show_login_btn">{{ trans('translations.texts.sign_in') }}</a></span>
                                @else
                                    <a href="{{ route('user.index') }}" class="ui button button--secondary">{{ trans('translations.buttons.go_to_dashboard') }}</a>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    </div>
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

            $('#countryDropdown').dropdown({
                onChange: function() {

                    var country = $('#country').val();

                    //set calling code
                    $('#callingCodeDropdown').dropdown('set selected',get_calling_code(country));
                    //trigger change event
                    $('#country').change();

                    remove_error();
                }
            });

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
