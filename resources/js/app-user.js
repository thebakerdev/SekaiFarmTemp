
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from 'vue';

import PageScripts from './page-scripts';

import Notifications from 'vue-notification';

Vue.use(Notifications);

Vue.prototype.trans = (string, args) => {

    let value = _.get(window.i18n, string);

    _.eachRight(args, (paramVal, paramKey) => {
        value = _.replace(value, `:${paramKey}`, paramVal);
    });

    return value;
};

import AddressContainer from './components/user/AddressContainer';

import AccountContainer from './components/user/AccountContainer';

/* Initialize vue */
const app = new Vue({
    el: '#app-user',
    components: {
        'account-container': AccountContainer,
        'address-container': AddressContainer
    },
    mounted() {
        PageScripts.init();
    }
});
