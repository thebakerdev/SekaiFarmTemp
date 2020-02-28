<template>
    <div class="user-registration">
        <div class="user-registration__overlay" :class="{active: button.state === 'loading'}"></div>
        <form id="registration_form" method="post" :action="form_action" ref="registration_form" class="ui form" @submit.prevent="onRegister()" @keydown="registration_data.errors.clear($event.target.name)">
            <input type="hidden" name="_token" :value="csrf">
            <input type="hidden" name="qty" :value="qty">
            <input type="hidden" name="product_id" :value="product.id">
            <input type="hidden" name="product_name" :value="product.name">
            <input type="hidden" name="product_price" :value="product.price">
            <input type="hidden" name="payment_method" :value="payment_method">
            <transition name="fade" mode="out-in">
                <div v-show="show_form">
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
                                            <div v-for="(country,key) in countries" :key="key" class="item" :data-value="country">{{ country }}</div>
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
                            <label for="phone">{{ trans('translations.labels.phone') }}</label>
                            <div class="two fields">
                                <div class="eight wide field" :class="registration_data.errors.has('phone') ? 'error':''">
                                    <imask-input v-model="registration_data.phone"  name="phone" :mask="'+num'" :blocks="{ num: { mask: Number}}" :lazy="true"/>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <div class="user-registration__subscription-total">
                        {{ trans('translations.texts.total') }} ${{ product.price }} x  {{ product.qty }}= <strong>${{ total }}</strong> / {{ trans('translations.texts.per_month') }}
                    </div>
                </div>
            </transition>
            <div class="user-registration__actions field mt-2">
                <div class="user-registration__actions-loader" v-if="show_form">
                    <button id="subscribe_btn" type="submit" class="ui large button button--primary" :class="buttonStyle">{{ trans('translations.buttons.subscribe') }}</button>
                    <div class="loader" :class="{active: button.state === 'loading'}">{{ trans('translations.texts.loading') }}</div>
                </div>
            </div>
        </form>
        <div class="user-registration__actions" v-show="show_form === false">
            <button id="form_display_btn" type="button" class="ui large button button--primary" @click="show_form = true">${{ total }}/ <small class="text-normal">{{ trans('translations.texts.per_month') }}</small></button><span class="no-wrap">{{ trans('translations.texts.already_subscribed') }} <a href="#" class="text-bold color--yellow show_login_btn">{{ trans('translations.texts.sign_in') }}</a></span>
        </div>
    </div>
</template>
<script>
    import Form from 'form-backend-validation';
    
    import StripeCheckout from './StripeCheckout';

    import FormValidation from './../../mixins/formValidation';

    import Common from './../../mixins/common';

    import {IMaskComponent} from 'vue-imask';

    export default {
        components: {
            'stripe-checkout': StripeCheckout,
            'imask-input': IMaskComponent
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
            countries: {
                type: Object,
                required: true
            },
            product: {
                type: Object,
                required: true
            },
            qty: {
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
                return this.product.price * this.qty;
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
            onRegister() {

                const vm = this;

                if (this.button.state === 'active') {
                    
                    this.button.state = 'loading';

                    this.validate(this.registration_data, this.$refs.registration_form).then(response => {

                        if (response.status === 'success') {

                            console.log(response);
                            
                            vm.$refs.stripe_input.confirmCardSetup().then(response => {

                                if (typeof response.setupIntent !== 'undefined') {

                                    const form = document.getElementById('registration_form');

                                    vm.payment_method = response.setupIntent.payment_method;

                                    vm.form_action = vm.actionUrl;

                                    setTimeout(()=>{
                                        form.submit();
                                    },500);
                                }

                                if (typeof response.error !== 'undefined') {
                                
                                    vm.$refs.stripe_input.triggerCardError(response.error.message);
                                    this.button.state = 'active';
                                }
                            }).catch(error => {
                                
                                this.button.state = 'active';
                            });
                        }
                    }).catch(error => {
                        this.button.state = 'active';
                        vm.$refs.stripe_input.validateEmpty();
                    });
                }
            }
        },
        mounted() {
            const vm = this;

            this.form_action = this.validationUrl;

            this.initializeDropdown(this.registration_data,'country');
        },
        mixins: [FormValidation, Common],
    }
</script>