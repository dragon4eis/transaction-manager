/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from 'vue';
import store from './store/index';
import router from './routes/index';
import {toNumber} from './helpers';
import VueNotifications from 'vue-notifications';
import iziToast from 'izitoast';


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

function toast({title, message, type, timeout}) {
    if (type === VueNotifications.types.warn) type = 'warning';
    return iziToast[type]({title, message, timeout})
}

Vue.use(VueNotifications, {
    success: toast,
    error: toast,
    info: toast,
    warn: toast
});

const app = new Vue({
    el: '#app',
    router,
    store,
    notifications: {
        showSuccessMsg: {
            type: VueNotifications.types.success,
            title: 'Success',
            message: 'That\'s the success!'
        },
        showInfoMsg: {
            type: VueNotifications.types.info,
            title: 'Info',
            message: 'Here is some info for you'
        },
        showWarnMsg: {
            type: VueNotifications.types.warn,
            title: 'Warning',
            message: 'That\'s the kind of warning'
        },
        showErrorMsg: {
            type: VueNotifications.types.error,
            title: 'Error',
            message: 'That\'s the error'
        }
    },
    methods: {
        showNotification(config) {
            if (config != null) {
                config.timeout = config.timeout || 3000;
                toast(config)
            }
        }
    }
});
