
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

Vue.component('login-form', require('./components/storefront/LoginForm.vue').default); 

/* Initialize vue */
const app = new Vue({
    el: '#app',
    computed: {
        total: function() {
            return this.product.qty * this.product.price;
        }
    },
    data: {
        product: {
            qty: 1,
            price: 0,
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

        this.product.price = this.$refs.price.value;
    }
});
