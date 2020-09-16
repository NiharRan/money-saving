
require('./bootstrap');

window.Vue = require('vue');

import DataTable from 'laravel-vue-datatable';
Vue.use(DataTable);

import VueSweetalert2 from 'vue-sweetalert2';
Vue.use(VueSweetalert2)

import MultiSelect from "vue-multiselect";
Vue.component('multi-select', MultiSelect)

import vueLaravelErrors from "vue-laravel-errors"
Vue.use(vueLaravelErrors, { type : "object" || "array"});

Vue.mixin(require('./mixins/trans'));
Vue.mixin(require('./mixins/auth'));
Vue.mixin(require('./mixins/breabcrumb'));
Vue.mixin(require('./plugins/sweetalert'));

Vue.component('breadcrumb', require('./panels/Breadcrumb').default);

Vue.component('customer-list', require('./pages/Customer/List').default);
Vue.component('account-list', require('./pages/Account/List').default);
Vue.component('dashboard-page', require('./pages/Dashboard').default);


const app = new Vue({
    el: '#app',
});
