import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

import usersIndex from '../components/users/Index.vue';

const routes = [{ path: '/users', name: 'users.index', component: usersIndex }];

const router = new VueRouter({
  routes,
  hashbang: false,
  mode: 'history'
});

export default router;
