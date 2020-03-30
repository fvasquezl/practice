require('./bootstrap');

window.Vue = require('vue');

import router from "./router/router.js"


Vue.component('data-table', require('./components/DataTable.vue').default);


const app = new Vue({
    el: '#app',
    router
});
