require('./bootstrap');

window.Vue = require('vue');

import router from "./router/router.js"


const app = new Vue({
    el: '#app',
    router
});
