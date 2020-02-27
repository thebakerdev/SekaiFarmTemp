
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from 'vue';

import PageScripts from './page-scripts';

import Notifications from 'vue-notification';

import VuejsDialog from 'vuejs-dialog';

import 'vuejs-dialog/dist/vuejs-dialog.min.css';

Vue.prototype.trans = (string, args) => {

    let value = _.get(window.i18n, string);

    _.eachRight(args, (paramVal, paramKey) => {
        value = _.replace(value, `:${paramKey}`, paramVal);
    });

    return value;
};

Vue.use(Notifications);

Vue.use(VuejsDialog, {
    okText: Vue.prototype.trans('translations.buttons.proceed'),
    cancelText: Vue.prototype.trans('translations.buttons.cancel'),
});



import AddressContainer from './components/user/AddressContainer';

import AccountContainer from './components/user/AccountContainer';

import SubscriptionContainer from './components/user/SubscriptionContainer';

/* Initialize vue */
const app = new Vue({
    el: '#app-user',
    components: {
        'account-container': AccountContainer,
        'address-container': AddressContainer,
        'subscription-container': SubscriptionContainer
    },
    mounted() {
        PageScripts.init();
    }
});
