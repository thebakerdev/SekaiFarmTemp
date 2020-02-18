@extends('layouts.user')

@section('page-title', trans('translations.headings.subscription'))

@section('content')
    <div class="user-dashboard__content-inner user-subscription">
        <h3 class="user-dashboard__content-heading">{{ trans('translations.headings.subscription') }}</h3>
        <div class="ui grid">
            <div class="sixteen wide mobile eight wide tablet eight wide computer column pb-0 user-dashboard__content-divider">
                <div class="form-display">
                    <div class="field">
                        <label for="status" class="field__item">{{ trans('translations.labels.status') }}</label>
                        <span id="status" class="field__item"><a class="ui label bg--blue color--white">{{ trans('translations.texts.subscribed') }}</a></span>
                    </div>
                    <div class="field">
                        <label for="product" class="field__item">{{ trans('translations.headings.product') }}</label>
                        <span id="product" class="field__item">Biodegradable Grain Bag</span>
                    </div>
                    <div class="field">
                        <label for="quantity" class="field__item">{{ trans('translations.labels.quantity') }}</label>
                        <span id="quantity" class="field__item">5 / {{ trans('translations.texts.per_month') }}</span>
                    </div>
                    <div class="field">
                        <label for="name_in_card" class="field__item">{{ trans('translations.labels.name_in_card') }}</label>
                        <span id="name_in_card" class="field__item">John Doe</span>
                    </div>
                    <div class="field">
                        <label for="name_in_card" class="field__item">{{ trans('translations.labels.card_number') }}</label>
                        <span id="name_in_card" class="field__item"><i class="large cc visa icon color--grey-4"></i> ****54545454</span>
                    </div>
                </div>
            </div>
            <div class="sixteen wide mobile eight wide tablet eight wide computer column text-center">
                <p>{{ trans('translations.texts.cancel_subscription_text') }}</p>
                <button class="ui button button--danger button--fixed">{{ trans('translations.buttons.cancel_subscription') }}</button>
            </div>
        </div>
    </div>
@endsection