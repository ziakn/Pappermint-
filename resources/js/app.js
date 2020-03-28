require('./bootstrap');
import common from './common';
Vue.mixin(common);
window.Vue = require('vue');
import Vue from 'vue'
Vue.use(require('vue-moment'));
import vuetify from './plugins/vuetify'
router.afterEach((to, from) => {
    Vue.nextTick(() => {
        document.title = to.meta.title ? to.meta.title : 'Tas-Taz Title';
    });
})
Vue.component('z-dashboard', require('./components/dashboard.vue').default);
Vue.component('z-staff', require('./components/staff.vue').default);

import router from './router'
import store from './store'

const app = new Vue({
    el: '#app',
    vuetify,
    router,
    store: store,
});
