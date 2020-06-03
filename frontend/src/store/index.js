import Vue from 'vue'
import Vuex from 'vuex'
import Cookies from 'vue-cookies'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    backend_url: 'http://teleshka.uz',
    access_token: Cookies.get('token'),
  },
  mutations: {
  },
  actions: {
  },
  modules: {
  }
})
