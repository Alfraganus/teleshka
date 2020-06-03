import Vue from 'vue'
import Vuex from 'vuex'
import Cookie from 'js-cookie'

Vue.use(Vuex)

export default new Vuex.Store({
    strict: true,
    state: {
        // backend_url: 'http://wb.uz/',
        backend_url: 'http://donyor.uz/',
        access_token: Cookie.get('access_token') || "null",
        user: Cookie.get('user') || "null",
        locale: Cookie.get('locale') || 'ru',
        errors: []
    },
    getters: {
        backend_url: (state) => {
            return state.backend_url
        }
    },
    mutations: {
        setUser: (state, arg) => {
            Cookie.set('user', JSON.stringify(arg), 1)
            state.user = JSON.stringify(arg)
        },
        setAccessToken: (state, arg) => {
            Cookie.set('access_token', JSON.stringify(arg), 1)
            state.access_token = JSON.stringify(arg)
        }
    },
    actions: {
        setLocale: (state, arg) => {
            Cookie.set('locale', arg)
        },
        setUser: (context, arg) => {
            context.commit('setUser', arg)
        },
        setAccessToken: (context, arg) => {
            context.commit('setAccessToken', arg)
        },
    },
    modules: {}
})
