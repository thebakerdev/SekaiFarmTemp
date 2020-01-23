<template>
    <div class="stripe-checkout">
        <div class="stripe-checkout__card-wrap">
            <div id="card_element">
                <!-- Stripe element will be inserted here -->
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        props: {
            client_secret: {
                type: String,
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
                stripe: '' //stripe instance,
            }
        },
        methods: {
            initializeStripe() {

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
            }
        },
        mounted() {

            this.initializeStripe();
        }
    }
</script>