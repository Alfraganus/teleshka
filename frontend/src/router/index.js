import Vue from 'vue'
import VueRouter from 'vue-router'
import Layout from '@/views/layouts/Layout';

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
    component: () => import('../views/layouts/Login.vue')
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
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

export default router
