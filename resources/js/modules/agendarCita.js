export default {
    state: {
        tramiteSeleccionado: null,
    },
    getters: {
        getTramiteSeleccionado(state) {
            return state.tramiteSeleccionado
        },
    },
    mutations: {
        setTramiteSeleccionado(state, payload) {
            state.tramiteSeleccionado = payload
        },
    }
}