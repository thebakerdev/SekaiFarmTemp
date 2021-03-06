
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from 'vue';

import PageScripts from './page-scripts';

Vue.prototype.trans = (string, args) => {

    let value = _.get(window.i18n, string);

    _.eachRight(args, (paramVal, paramKey) => {
        value = _.replace(value, `:${paramKey}`, paramVal);
    });

    return value;
};

/* Global vue components */
Vue.component('stock-adjust', require('./components/admin/StockAdjust.vue').default);

Vue.component('content-update', require('./components/admin/ContentUpdate.vue').default);

Vue.component('user-auth', require('./components/storefront/UserAuth.vue').default); 

Vue.component('stripe-checkout', require('./components/storefront/StripeCheckout.vue').default);

Vue.component('user-registration', require('./components/storefront/UserRegistration.vue').default);

/* Initialize vue */
const app = new Vue({
    el: '#app',
    data: {
        product: {
            qty: 1,
        }
    },
    methods: {
        isNumber(evt) {

            evt = (evt) ? evt : window.event;

            let  charCode = (evt.which) ? evt.which : evt.keyCode;

            if ((charCode > 31 && (charCode < 48 || charCode > 57)) || charCode === 46) {
                evt.preventDefault();;
            } else {
                return true;
            }
        }
    },
    mounted() {
        PageScripts.init();
    }
});
