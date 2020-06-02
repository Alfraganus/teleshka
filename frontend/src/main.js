import Vue from 'vue'
import App from './App.vue'
import './registerServiceWorker'
import router from './router'
import store from './store'
import vuetify from './plugins/vuetify';
import axios from 'axios'
Vue.prototype.$axios = axios

Vue.config.productionTip = false
import Cookies from 'vue-cookies';
Vue.use(Cookies)
router.beforeEach((to, from, next) => {
  if (to.name !== 'Login' && !Cookies.get('token')) next({ name: 'Login' })
  else next()
})

new Vue({
  router,
  store,
  vuetify,
  render: h => h(App)
}).$mount('#app')
