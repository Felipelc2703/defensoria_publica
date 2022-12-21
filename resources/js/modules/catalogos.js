export default {
    state: {
        centrosAtencion: [],
        tramites: [],
    },
    getters: {
        getCatalogoCentrosAtencion(state) {
            return state.centrosAtencion
        },
        getCatalogoTramites(state) {
            return state.tramites
        }
    },
    mutations: {
        setCatalogoCentrosAtencion(state, payload) {
            state.centrosAtencion = payload
        },
        setCatalogoTramites(state, payload) {
            state.tramites = payload
        }
    }
}