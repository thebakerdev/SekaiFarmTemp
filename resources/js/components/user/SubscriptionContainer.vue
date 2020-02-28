<template>
    <div class="ui grid subscription-container">
        <div class="sixteen wide mobile eight wide tablet eight wide computer column pb-0 user-dashboard__content-divider">
            <div class="form-display">
                <div class="field">
                    <label for="status" class="field__item">{{ trans('translations.labels.status') }}</label>
                    <span id="status" class="field__item" v-if="status==='cancelled'"><a class="ui label color--white">{{ trans('translations.texts.canceled') }}</a></span>
                    <span id="status" class="field__item" v-if="status==='subscribed'"><a class="ui label color--white bg--blue">{{ trans('translations.texts.subscribed') }}</a></span>
                    <span id="status" class="field__item" v-if="status==='unsubscribed'"><a class="ui label color--white bg--red">{{ trans('translations.texts.unsubscribed') }}</a></span>
                </div>
                <div class="field">
                    <label for="product" class="field__item">{{ trans('translations.headings.product') }}</label>
                    <span id="product" class="field__item">{{ product.name }}</span>
                </div>
                <div class="field" v-if="status !=='unsubscribed'">
                    <label for="qty" class="field__item">{{ trans('translations.labels.quantity') }}</label>
                    <div class="ui form product__qty" v-show="qty.editing === true">
                        <input type="number" id="qty" name="qty" v-model="qty.value">
                        <button class="ui button button--primary mt-1" @click="updateQuantity()" :class="{loading:qty.saving, disabled:qty.saving}">{{ trans('translations.buttons.save') }}</button> 
                        <span class="c-pointer" role="button" @click="qty.editing = false">{{ trans('translations.buttons.cancel') }}</span>
                    </div>
                    <div v-show="qty.editing === false">
                        <span id="qty" class="field__item">{{ qty.value }} / {{ trans('translations.texts.per_month') }}</span>
                        <br/>
                        <a class="link link--secondary text-uppercase c-pointer" href="javascript:void(0)" @click="qty.editing = true">{{ trans('translations.buttons.edit') }}</a>
                    </div>
                </div>
                <div class="field" v-else>
                    <label for="qty" class="field__item">{{ trans('translations.labels.quantity') }}</label>
                    <div class="ui form product__qty">
                        <input type="number" id="qty" name="qty" v-model="new_subscription.qty">
                    </div>
                </div>
                <div class="field">
                    <label for="name_in_card" class="field__item">{{ trans('translations.labels.card_number') }}</label>
                    <div v-show="card.editing === true">
                        <stripe-checkout 
                            ref="stripe_input_update" 
                            :stripe-key="stripeKey" 
                            :client-secret="client_secret"
                            :payment-data="{name:user.name}">
                        </stripe-checkout>
                        <button class="ui button button--primary mt-1" :class="{loading:card.saving, disabled:card.saving}" @click="updateCard()">{{ trans('translations.buttons.save') }}</button> 
                        <span class="c-pointer" role="button" @click="card.editing = false">{{ trans('translations.buttons.cancel') }}</span>
                    </div>
                    <div v-show="card.editing === false">
                        <span id="name_in_card" class="field__item"><!-- <i class="large cc visa icon color--grey-4"></i> --> ***********{{ card.last_four }}</span>
                        <br>
                        <a class="link link--secondary text-uppercase c-pointer" href="javascript:void(0)" @click="card.editing = true">{{ trans('translations.buttons.edit') }}</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="sixteen wide mobile eight wide tablet eight wide computer column text-center">
            <template v-if="status==='subscribed'">
                <p>{{ trans('translations.texts.cancel_subscription_text') }}</p>
                <button class="ui button button--danger button--fixed" :class="buttonStyle" @click="cancelSubscription()">{{ trans('translations.buttons.cancel_subscription') }}</button>
            </template>
            <template v-if="status==='cancelled'">
                <p>{{ trans('translations.texts.resume_subscription_text',{date:subscription.expiry}) }}</p>
                <button class="ui button button--primary button--fixed" :class="buttonStyle" @click="resumeSubscription()">{{ trans('translations.buttons.resume_subscription') }}</button>
            </template>
            <template v-if="status==='unsubscribed'">
                <h3 class="subscription__heading mb-0">
                    ${{ total }} / <span>{{ trans('translations.texts.per_month') }}</span>
                </h3>
                <p>{{ trans('translations.texts.subscribe_back_message') }}</p>
                <button class="ui button button--secondary button--fixed" :class="buttonStyle" @click="reactivateSubscription()">{{ trans('translations.buttons.subscribe') }}</button>
            </template>
        </div>
    </div>
</template>
<script>
    import FormValidation from './../../mixins/formValidation';

    import StripeCheckout from './../storefront/StripeCheckout';

    export default {
        components: {
            'stripe-checkout': StripeCheckout
        },
        props: {
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
            subscription: {
                type: Object,
                required: true
            },
            user: {
                type: Object,
                required: true
            },
        },
        computed: {
            total() {
                return this.product.price * this.new_subscription.qty;
            }
        },
        data() {
            return {
                status: '', //subscribed, canceled, unsubscribed,
                client_secret: this.clientSecret,
                card: {
                    editing: false,
                    saving: false,
                    last_four: this.user.card_last_four
                },
                qty: {
                    editing: false,
                    saving: false,
                    value: this.subscription.quantity
                },
                new_subscription: {
                    qty:1
                }
            }
        },
        methods: {
            cancelSubscription() {
                const vm = this;

                if (this.button.state === 'active') {

                    this.button.state = 'loading';
                    
                    axios.post('/subscription/cancel').then(response => {
                    
                        if (response.data.status === 'success') {
                            vm.checkSubscriptionStatus();

                            setTimeout(()=>{
                                this.$notify({
                                    group: 'user-notification',
                                    title: vm.trans('translations.headings.notification'),
                                    text: vm.trans('translations.texts.cancel_subscription_message'),
                                    type: 'error'
                                });
                            },400);
                        }
                    }).finally(()=> {
                        this.button.state = 'active';
                    });
                }
                
            },
            checkSubscriptionStatus() {

                const vm = this;

                axios.get('/subscription/check-status').then(response => {

                    if (response.data.status === 'success') {
                        vm.status = response.data.subscription_status;
                    }
                });
            },
            reactivateSubscription() {

                const vm = this;

                if (this.button.state === 'active') {

                    this.button.state = 'loading';
                    
                    axios.post('/subscription/reactivate',{qty: this.new_subscription.qty}).then(response => {
                    
                        if (response.data.status === 'success') {

                            vm.qty.value = vm.new_subscription.qty;

                            vm.checkSubscriptionStatus();

                            setTimeout(()=>{
                                this.$notify({
                                    group: 'user-notification',
                                    title: vm.trans('translations.headings.notification'),
                                    text: vm.trans('translations.texts.subscription_reactivated_message')
                                });
                            },400);
                        }
                    }).finally(()=> {
                        this.button.state = 'active';
                    });
                } 
            },
            resumeSubscription() {
                
                const vm = this;

                if (this.button.state === 'active') {

                    this.button.state = 'loading';
                    
                    axios.post('/subscription/resume').then(response => {
                    
                        if (response.data.status === 'success') {
                            vm.checkSubscriptionStatus();

                            setTimeout(()=>{
                                this.$notify({
                                    group: 'user-notification',
                                    title: vm.trans('translations.headings.notification'),
                                    text: vm.trans('translations.texts.resume_subscription_message')
                                });
                            },400);
                        }
                    }).finally(()=> {
                        this.button.state = 'active';
                    });
                } 
            },
            updateCard() {

                const vm = this;
                
                if (vm.card.saving === false) {

                    vm.card.saving = true;

                    vm.$refs.stripe_input_update.confirmCardSetup().then(response => {

                        if (typeof response.setupIntent !== 'undefined') {

                            const payment_method = response.setupIntent.payment_method;
                
                            axios.put('/subscription/update/card',{payment_method: payment_method}).then(response => {

                                vm.client_secret = response.data.payment_intent.client_secret;

                                vm.card.editing = false;

                                vm.card.last_four = response.data.card_last_four;
                                
                                setTimeout(()=>{
                                    this.$notify({
                                        group: 'user-notification',
                                        title: vm.trans('translations.headings.notification'),
                                        text: vm.trans('translations.texts.card_updated')
                                    });
                                },400);
                            }).finally(() => {
                                vm.card.saving = false;
                            });
                        }

                        if (typeof response.error !== 'undefined') {
                            vm.$refs.stripe_input_update.triggerCardError(response.error.message);
                            vm.card.saving = false;
                        }
                        
                    }).catch(error => {
                         vm.card.saving = false;
                    });
                }
                
                
            },
            updateQuantity() {

                const vm = this;

                if (vm.qty.saving === false) {

                    vm.qty.saving = true;

                    axios.put('/subscription/update/quantity', {qty: this.qty.value}).then(response => {

                        if (response.data.status === 'success') {
                            vm.qty.editing = false;

                            setTimeout(()=>{
                                this.$notify({
                                    group: 'user-notification',
                                    title: vm.trans('translations.headings.notification'),
                                    text: vm.trans('translations.texts.quantity_update_message')
                                });
                            },400);
                        }
                    }).finally(()=> {
                        vm.qty.saving = false;
                    });
                }
            }
        },
        mounted() {
            this.checkSubscriptionStatus();
        },
        mixins:[FormValidation]
    }
</script>