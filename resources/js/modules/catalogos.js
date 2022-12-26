export default {
    state: {
        centrosAtencion: [],
        tramites: [],
        requisitos: [],
        tiposTramite: [],
    },
    getters: {
        getCatalogoCentrosAtencion(state) {
            return state.centrosAtencion
        },
        getCatalogoTramites(state) {
            return state.tramites
        },
        getCatalogoRequisitos(state) {
            return state.requisitos
        },
        getCatalogoTiposTramites(state) {
            return state.tiposTramite
        },

    },
    mutations: {
        setCatalogoCentrosAtencion(state, payload) {
            state.centrosAtencion = payload
        },
        setCatalogoTramites(state, payload) {
            state.tramites = payload
        },
        setCatalogoRequisitos(state,payload) {
            state.requisitos = payload
        },
        setCatalogoTiposTramites(state,payload) {
            state.tiposTramite = payload
        },
    }
}