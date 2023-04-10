export default {
    state: {
        juzgadoSeleccionado: null,
    },
    getters: {
        getJuzgadoSeleccionado(state) {
            return state.juzgadoSeleccionado
        },
    },
    mutations: {
        setJuzgadoSeleccionado(state, payload) {
            state.juzgadoSeleccionado = payload
        },
    }
}