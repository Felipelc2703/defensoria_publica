export default {
    state: {
        tramiteSeleccionado: null,
        asuntoStore: null,
    },
    getters: {
        getTramiteSeleccionado(state) {
            return state.tramiteSeleccionado
        },
        getAsuntoStore(state) {
            return state.asuntoStore
        }
    },
    mutations: {
        setTramiteSeleccionado(state, payload) {
            state.tramiteSeleccionado = payload
        },
        setAsuntoStore(state, payload) {
            state.asuntoStore = payload
        }
    }
}