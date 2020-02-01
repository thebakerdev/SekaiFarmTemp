<template>
    <div class="stripe-checkout">
        <div class="stripe-checkout__card-wrap">
            <div id="card_element">
                <!-- Stripe element will be inserted here -->
            </div>
            <div class="p-h StripeElement--error ui red" v-if="error.show === true && error.message !== ''"><small>{{ error.message }}</small></div>
        </div>
    </div>
</template>
<script>
    export default {
        props: {
            clientSecret: {
                type: String,
                required: true
            },
            paymentData: {
                type: Object,
                required: true
            },
            stripeKey: {
                type: String,
                required: true
            }
        },
        data() {
            return {
                card: '',
                elements: '',
                error: {
                    message: '',
                    show: false
                },
                stripe: '' //stripe instance,
            }
        },
        methods: {
            confirmCardSetup() {

                return this.stripe.confirmCardSetup(
                     this.clientSecret, 
                     {
                        payment_method: {
                            card: this.card,
                            billing_details: { name: this.paymentData.name}
                        }
                    }
                );
            },
            /* Initialize stripe input */
            initializeStripe() {

                const vm = this;

                this.stripe = Stripe(this.stripeKey);

                this.elements = this.stripe.elements({
                    locale: this.locale
                });

                const style = {
                    base: {
                        color: '#32325d',
                        fontFamily: 'Roboto, sans-serif',
                        fontSmoothing: 'antialiased',
                        fontSize: '14px',
                        '::placeholder': {
                            color: '#aab7c4'
                        }
                    },
                    invalid: {
                        color: '#9f3a38',
                        iconColor: '#9f3a38'
                    }
                };

                this.card = this.elements.create('card');

                this.card.mount('#card_element');

                this.card.on('change', function(event) {

                    if (event.complete === true) {
                        vm.error.show = false;
                        vm.error.message = '';
                    } else {
                        vm.error.show = true;
                    }
                });
            },
            triggerCardError(message = null) {

                if (message != null) {
                    this.error.message = message;
                }
                
                this.error.show = true;

                $('#card_element').addClass('StripeElement--invalid');
            },
        },
        mounted() {

            this.initializeStripe();
        }
    }
</script>