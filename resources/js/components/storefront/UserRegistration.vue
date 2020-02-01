<template>
    <div class="user-registration">
        <form id="registration_form" method="post" :action="form_action" ref="registration_form" class="ui form" @submit="onRegister($event)">
            <input type="hidden" name="_token" :value="csrf">
            <input type="hidden" name="qty" :value="product.qty">
            <input type="hidden" name="payment_method" :value="payment_method">
            <div v-if="show_form">
                <fieldset class="mb-2">
                    <legend>{{ trans('translations.headings.basic_info') }}</legend>
                    <div class="field" :class="registration_data.errors.has('name') ? 'error':''">
                        <label for="name">{{ trans('translations.labels.name') }}</label>
                        <input type="text" id="name" name="name" v-model="registration_data.name">
                    </div>
                    <div class="field" :class="registration_data.errors.has('email') ? 'error':''">
                        <label for="email">{{ trans('translations.labels.email') }}</label>
                        <input type="email" id="email" name="email" v-model="registration_data.email">
                    </div>
                    <div class="field" :class="registration_data.errors.has('password') ? 'error':''">
                        <label for="password">{{ trans('translations.labels.password') }}</label>
                        <input type="password" id="password" name="password" v-model="registration_data.password">
                    </div>
                    <div class="field">
                        <label for="password_confirmation">{{ trans('translations.labels.confirm_password') }}</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" v-model="registration_data.password_confirmation">
                    </div>
                    <div class="field">
                        <label>{{ trans('translations.labels.credit_card') }}</label>
                        <stripe-checkout 
                            ref="stripe_input" 
                            :stripe-key="stripeKey" 
                            :client-secret="clientSecret"
                            :payment-data="{name:registration_data.data}">
                        </stripe-checkout>
                    </div>
                </fieldset>
                <fieldset>
                    <legend>{{ trans('translations.headings.shipping_details') }}</legend>
                    <div class="field">
                        <div class="two fields">
                            <div class="eight wide field" :class="registration_data.errors.has('country') ? 'error':''">
                                <label for="country">{{ trans('translations.labels.country') }}</label>
                                <div id="country_dropdown" class="ui fluid selection dropdown">
                                    <input id="country" type="hidden" name="country" value="test" v-model="registration_data.country">
                                    <i class="dropdown icon"></i>
                                    <div class="default text">{{ trans('translations.labels.country') }}</div>
                                    <div class="menu">
                                        <div class="item" data-value="United States">United States</div>
                                    </div>
                                </div>
                            </div>
                            <div class="eight wide field" :class="registration_data.errors.has('state') ? 'error':''">
                                <label for="state">{{ trans('translations.labels.state') }}</label>
                                <input type="text" id="state" class="input" name="state" v-model="registration_data.state">
                            </div>
                        </div>
                    </div>
                    <div class="field">
                        <div class="two fields">
                            <div class="eight wide field" :class="registration_data.errors.has('city') ? 'error':''">
                                <label for="city">{{ trans('translations.labels.city') }}</label>
                                <input type="text" id="city" class="input" name="city" v-model="registration_data.city">
                            </div>
                            <div class="eight wide field" :class="registration_data.errors.has('postal') ? 'error':''">
                                <label for="postal">{{ trans('translations.labels.postal') }}</label>
                                <input type="text" id="postal" class="input" name="postal" v-model="registration_data.postal">
                            </div>
                        </div>
                    </div>
                    <div class="field" :class="registration_data.errors.has('address1') ? 'error':''">
                        <label for="address1">{{ trans('translations.labels.address_1') }}</label>
                        <input type="text" id="address1" class="input" name="address1" v-model="registration_data.address1">
                    </div>
                    <div class="field">
                        <label for="address2">{{ trans('translations.labels.address_2') }}</label>
                        <input type="text" id="address2" class="input" name="address2" v-model="registration_data.address2">
                    </div>
                    <div class="field">
                        <label for="phone">{{ trans('translations.labels.phone') }} <small>({{trans('translations.labels.phone_tracking')}})</small></label>
                        <div class="two fields">
                            <div class="five wide field">
                                <div id="calling_code_dropdown" class="ui fluid selection dropdown">
                                    <input id="calling_code" type="hidden" name="calling_code">
                                    <i class="dropdown icon"></i>
                                    <div class="default text">{{ trans('translations.labels.code') }}</div>
                                    <div class="menu">
                                        <div class="item" data-value="+1"><i class="us flag"></i>+1</div>
                                    </div>
                                </div>
                            </div>
                            <div class="eleven wide field" :class="registration_data.errors.has('phone') ? 'error':''">
                                <input type="text"  class="input" name="phone" v-model="registration_data.phone">
                            </div>
                        </div>
                    </div>
                </fieldset>
                <div class="user-registration__subscription-total">
                    {{ trans('translations.texts.total') }} ${{ product.price }} x  {{ product.qty }}= <strong>${{ total }}</strong> / {{ trans('translations.texts.per_month') }}
                </div>
            </div>
            <div class="user-registration__actions field mt-2">
                <template v-if="show_form">
                    <button id="subscribe_btn" type="submit" class="ui large button button--primary">{{ trans('translations.buttons.subscribe') }}</button>
                </template>
                <template v-else>
                    <button id="form_display_btn" type="button" class="ui large button button--primary">${{ total }}/ <small class="text-normal">{{ trans('translations.texts.per_month') }}</small></button><span class="no-wrap">{{ trans('translations.texts.already_subscribed') }} <a href="#" class="text-bold color--yellow show_login_btn">{{ trans('translations.texts.sign_in') }}</a></span>
                </template>
            </div>
        </form>
    </div>
</template>
<script>
    import Form from 'form-backend-validation';
    
    import StripeCheckout from './StripeCheckout';

    import FormValidation from './../../mixins/formValidation';

    export default {
        components: {
            'stripe-checkout': StripeCheckout
        },
        props: {
            actionUrl: {
                type: String,
                required: true
            },
            clientSecret: {
                type: String,
                required: true
            },
            product: {
                type: Object,
                required: true
            },
            stripeKey: {
                type: String,
                required: true
            },
            validationUrl: {
                type: String,
                required: true
            }
        },
        computed: {
            total() {
                return this.product.price * this.product.qty;
            }
        },
        data() {
            return {
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                form_action: '',
                payment_method: '',
                show_form: false,
                registration_data: new Form({
                    name: '',
                    email: '',
                    password: '',
                    password_confirmation: '',
                    country: '',
                    state: '',
                    city: '',
                    postal: '',
                    address1: '',
                    address2: '',
                    phone: ''
                },{ resetOnSuccess: false }),
            }
        },
        methods: {
            onRegister(e) {

                e.preventDefault();

                const vm = this;

                this.validate(this.registration_data, this.$refs.registration_form).then(response => {

                    if (response.status === 'success') {
                        
                        vm.$refs.stripe_input.confirmCardSetup().then(response => {

                            if (typeof response.setupIntent !== 'undefined') {

                                const form = document.getElementById('registration_form');

                                vm.payment_method = response.setupIntent.payment_method;

                                vm.form_action = vm.actionUrl;

                                setTimeout(()=>{
                                    form.submit();
                                },1000);
                            }

                            if (typeof response.error !== 'undefined') {
                               
                               vm.$refs.stripe_input.triggerCardError(response.error.message);

                            }
                        }).catch(error => {
                            console.log(error.message);
                        });
                    }
     
                }).catch(error => {
                    //check card error
                });
            }
        },
        mixins: [FormValidation],
        mounted() {

            const vm = this;

            this.form_action = this.validationUrl;

            $('#country').change(function(){
                
                vm.registration_data.populate({
                    country: $(this).val()
                });
            });
        }
    }
</script>