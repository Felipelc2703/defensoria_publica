export default {
    state: {
        consejeros: [],
    },
    getters: {
        getConsejeros(state) {
            return state.consejeros
        },
    },
    mutations: {
        setConsejeros(state, payload) {
            state.consejeros = payload
        },
    }
}