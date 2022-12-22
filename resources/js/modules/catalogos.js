export default {
    state: {
        centrosAtencion: [],
        tramites: [],
        tramites_tipo_1: [],
        tramites_tipo_2: [],
        tramites_tipo_3: [],
        tramites_tipo_4: [],
    },
    getters: {
        getCatalogoCentrosAtencion(state) {
            return state.centrosAtencion
        },
        getCatalogoTramites(state) {
            return state.tramites
        },
        getCatalogoTramitesTipo1(state) {
            return state.tramites_tipo_1
        },
        getCatalogoTramitesTipo2(state) {
            return state.tramites_tipo_2
        },
        getCatalogoTramitesTipo3(state) {
            return state.tramites_tipo_3
        },
        getCatalogoTramitesTipo4(state) {
            return state.tramites_tipo_4
        }
    },
    mutations: {
        setCatalogoCentrosAtencion(state, payload) {
            state.centrosAtencion = payload
        },
        setCatalogoTramites(state, payload) {
            state.tramites = payload
        },
        setCatalogoTramitesTipo1(state, payload) {
            state.tramites_tipo_1 = payload
        },
        setCatalogoTramitesTipo2(state, payload) {
            state.tramites_tipo_2 = payload
        },
        setCatalogoTramitesTipo3(state, payload) {
            state.tramites_tipo_3 = payload
        },
        setCatalogoTramitesTipo4(state, payload) {
            state.tramites_tipo_4 = payload
        }
    }
}