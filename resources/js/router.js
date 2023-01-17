import { createWebHistory, createRouter } from "vue-router"
import Home from './pages/Home.vue'
import Login from './pages/Login.vue'
import Register from './pages/Register.vue'
import Dashboard from './pages/Dashboard.vue'
import CrearCita from './pages/CrearCita.vue'
import ConfirmacionCitaBuscada from './pages/ConfirmacionCitaBuscada.vue'
import CentrosAtencion from './pages/CentrosAtencion.vue'
import confwhats from './pages/confwhats.vue'
import ReporteGraf from './pages/ReporteGraf.vue'
import Reportes from './pages/Reportes.vue'
import ConfirmacionCita from './pages/ConfirmacionCita.vue'

import store from './store'
import CatalogoRequisitos from './pages/CatalogoRequisitos.vue'
import CatalogoUsuarios from './pages/CatalogoUsuarios.vue'
import CatalogoTramites from './pages/CatalogoTramites.vue'
import CatalogoNotas from './pages/CatalogoNotas.vue'

import AgregarHorario from './pages/AgregarHorario.vue'
import EditarHorario from './pages/EditarHorarios.vue'

const routes = [
    {
        path: '/',
        name: 'Home',
        component: Home
    },
    {
        path: '/login',
        name: 'Login',
        component: Login,
        meta: {
            requiresAuth: false
        }
    },
    {
        path: '/register',
        name: 'Register',
        component: Register,
        meta: {
            requiresAuth: false
        }
    },
    {
        path: '/dashboard',
        name: 'Dashboard',
        component: Dashboard,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/crear-cita',
        name: 'CrearCita',
        component: CrearCita,
    },
    {
        path: '/confirmacion-cita-buscada',
        name: 'ConfirmacionCitaBuscada',
        component: ConfirmacionCitaBuscada,
    },
    {
        path: '/centros-atencion',
        name: 'CentrosAtencion',
        component: CentrosAtencion,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/conf-whats',
        name: 'confwhats',
        component: confwhats,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/reporte-graficas',
        name: 'ReporteGraf',
        component: ReporteGraf,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/reportes',
        name: 'Reportes',
        component: Reportes,
        meta: {
            requiresAuth: true
        }
    },
    {        
        path: '/catalogo-requisitos',
        name: 'CatalogoRequisitos',
        component: CatalogoRequisitos,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/catalogo-usuarios',
        name: 'CatalogoUsuarios',
        component: CatalogoUsuarios,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/catalogo-tramites',
        name: 'CatalogoTramites',
        component: CatalogoTramites,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/confirmacion-cita',
        name: 'ConfirmacionCita',
        component: ConfirmacionCita,
    },
    {
        path: '/catalogo-notas',
        name: 'CatalogoNotas',
        component: CatalogoNotas,
    },
    {
        path: '/agregar-horario',
        name: 'AgregarHorario',
        component: AgregarHorario,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/confirmacion-cita',
        name: 'ConfirmacionCita',
        component: ConfirmacionCita,
    },
    {
        path: '/editar-horario',
        name: 'EditarHorario',
        component: EditarHorario,
        meta: {
            requiresAuth: true
        }
    },
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

router.beforeEach((to, from) => {
    if (to.meta.requiresAuth && store.getters.getToken == 0) {
        return {name: 'Login'}
    }
    if (to.meta.requiresAuth == false && store.getters.getToken != 0) {
        return {name: 'Dashboard'}
    }
})

export default router