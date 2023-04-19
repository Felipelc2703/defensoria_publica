import { createStore } from 'vuex'
import catalogos from './../modules/catalogos'
import agendarCita from './../modules/agendarCita.js'
import agendarCitaJuzgado from '../modules/agendarCitaJuzgado'
import { errorSweetAlert } from './../helpers/sweetAlertGlobals'
import router from '../router'

const store = createStore({
    state: {
        user: null,
        contRecaptcha: 0,
        showRecaptcha: false,
    },
    getters: {
        isLogged: state => !!state.user,
        user: function(state) {
            return state.user
        },
        getShowRecaptcha: function(state) {
            return state.showRecaptcha
        },
        getContRecaptcha: function(state) {
            return state.contRecaptcha
        }
    },
    mutations: {
        setUserData(state, userData) {
            state.user = userData
            localStorage.setItem('user', JSON.stringify(userData))
            axios.defaults.headers.common.Authorization = `Bearer ${userData.token}`
        },
        clearUserData () {
            localStorage.removeItem('user')
            location.reload()
        }
    },
    actions: {
        async login({commit}, credentials) {
            try {
                let response = await axios.post('/api/login', credentials)
                if (response.status === 200) {
                    if (response.data.status === "ok") {
                        commit('setUserData', response.data.session)

                        if (response.data.session.user.rol_id == 1) {
                            router.push({name: 'AgregarHorario'})
                        } else if (response.data.session.user.rol_id == 2) {
                            router.push('/citas-del-dia')
                        } else if (response.data.session.user.rol_id == 3) {
                            router.push({name: 'AgregarHorarioJuzgado'})
                        }
                        else if (response.data.session.user.rol_id == 4) {
                            router.push({name: 'ReporteJuzgados'})
                        }
                        else if (response.data.session.user.rol_id == 5) {
                            router.push({name: 'CatalogoUsuarios'})
                        }

                        this.state.contRecaptcha = 0
                        this.state.showRecaptcha = true
                    } else {
                        errorSweetAlert(response.data.message)
                        
                        this.state.contRecaptcha++
                        if (this.state.contRecaptcha == 3) {
                            this.state.showRecaptcha = true
                        }
                    }
                } else {
                    errorSweetAlert('Ocurrió un error al iniciar sesión')
                }
            } catch (error) {
                errorSweetAlert('Ocurrió un error al iniciar sesión')
            }
        },
        logout ({commit}) {
            commit('clearUserData')
        }
    },
    modules: {
        catalogos,
        agendarCita,
        agendarCitaJuzgado,
    }
})

export default store