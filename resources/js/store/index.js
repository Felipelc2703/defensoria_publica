import { createStore } from 'vuex'
import catalogos from './../modules/catalogos'
import agendarCita from './../modules/agendarCita.js'

const store = createStore({
    state: {
        // define variables
        token: localStorage.getItem('token') || 0,
        clave: ''
    },
    getters: {
        // get state variable value
        getToken: function (state) {
            return state.token
        },
        getClave: function(state) {
            return state.clave
        }
    },
    mutations: {
        // update variable value
        UPDATE_TOKEN(state, payload) {
            state.token = payload
        },
        setClave(state, payload) {
            state.clave = payload
        }
        
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
        }
    },
    modules: {
        catalogos,
        agendarCita,
    }
})

export default store