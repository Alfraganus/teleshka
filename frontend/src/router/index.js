import Vue from 'vue'
import VueRouter from 'vue-router'
import Layout from '@/views/layouts/Layout';
import store from '../store';
Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'Loyaut',
    component: Layout,
    hidden: true,
    children: [{
      path: '/',
      component: () =>
        import('@/views/Home')
    },]
  },
  {
    path: '/login',
    name: 'Login',
    component: () => import('../views/layouts/Login.vue'),
    hidden: true,
  },
  {
    path: '/about',
    name: 'Loyaut',
    component: Layout,
    hidden: true,
    children: [{
      path: '/',
      component: () =>
        import('@/views/About.vue')
    },]
  },
  {
    path: '/teleshka-list',
    name: 'Teleshka-list',
    component: Layout,
    hidden: true,
    children: [{
      path: '/',
      component: () =>
        import('@/views/Teleshka-list.vue')
    },]
  },
  {
    path: '/users',
    name: 'Users',
    component: Layout,
    hidden: true,
    children: [{
      path: '/',
      component: () =>
        import('@/views/Users.vue')
    },]
  },
]

const router = new VueRouter({
    mode: 'hash',
    // mode: 'history',
    base: process.env.BASE_URL,
    routes
})

router.beforeEach((to, from, next) => {
    var access_token = JSON.parse(store.state.access_token);
    if (!access_token && to.fullPath != '/login')
        next('/login')
    else
        next()
})

export default router
