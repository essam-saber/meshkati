require('./bootstrap');
window.Vue = require('vue');
Vue.component('sales-record', require('./components/SalesRecord.vue'));


const app = new Vue({
    el: '#app'
});
// custom select2
// $('#kt_datatable_search_status').select2();
// $('#kt_datatable_search_type').select2();
