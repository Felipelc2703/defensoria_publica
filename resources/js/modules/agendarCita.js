export default {
    state: {
        tramiteSeleccionado: null,
        asuntoStore: null,
        citaAgendada: null,
    },
    getters: {
        getTramiteSeleccionado(state) {
            return state.tramiteSeleccionado
        },
        getAsuntoStore(state) {
            return state.asuntoStore
        },
        getCitaAgendada(state) {
            return state.citaAgendada
        }
    },
    mutations: {
        setTramiteSeleccionado(state, payload) {
            state.tramiteSeleccionado = payload
        },
        setAsuntoStore(state, payload) {
            state.asuntoStore = payload
        },
        setCitaAgendada(state, payload) {
            state.citaAgendada = payload
        }
    }
}