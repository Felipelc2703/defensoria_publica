import { createStore } from 'vuex'
import catalogos from './../modules/catalogos'
import agendarCita from './../modules/agendarCita.js'

const store = createStore({
    state: {
        // define variables
        token: localStorage.getItem('token') || 0,
        clave: '',
        rolId: localStorage.getItem('rol_id') || null,
    },
    getters: {
        // get state variable value
        getToken: function (state) {
            return state.token
        },
        getClave: function(state) {
            return state.clave
        },
        getrolId: function(state) {
            return state.rolId
        }
    },
    mutations: {
        // update variable value
        UPDATE_TOKEN(state, payload) {
            state.token = payload
        },
        setClave(state, payload) {
            state.clave = payload
        },
        UPDATE_rolId(state, payload) {
            state.rolId = payload
        },
        
    },
    actions: {
        // action to be performed
        setToken(context, payload) {
            localStorage.setItem('token', payload)
            context.commit('UPDATE_TOKEN', payload)
        },
        removeToken(context) {
            localStorage.removeItem('token')
            context.commit('UPDATE_TOKEN', 0)
        },
        setrolId(context, payload) {
            localStorage.setItem('rol_id', payload)
            context.commit('UPDATE_rolId', payload)
        },
        removeRolId(context) {
            localStorage.removeItem('rol_id')
            context.commit('UPDATE_rolId', null)
        }
    },
    modules: {
        catalogos,
        agendarCita,
    }
})

export default store