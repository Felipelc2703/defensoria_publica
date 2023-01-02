import { createWebHistory, createRouter } from "vue-router"
import Home from './pages/Home.vue'
import Login from './pages/Login.vue'
import Register from './pages/Register.vue'
import Dashboard from './pages/Dashboard.vue'
import CrearCita from './pages/CrearCita.vue'
import BuscarFolio from './pages/BuscarFolio.vue'
import CentrosAtencion from './pages/CentrosAtencion.vue'
import confwhats from './pages/confwhats.vue'
import edituser from './pages/edituser.vue'
import createuser from './pages/createuser.vue'
import ReporteGraf from './pages/ReporteGraf.vue'
import Reportes from './pages/Reportes.vue'
import ConfirmacionCita from './pages/ConfirmacionCita.vue'

import store from './store'
import CatalogoRequisitos from './pages/CatalogoRequisitos.vue'
import CatalogoUsuarios from './pages/CatalogoUsuarios.vue'
import CatalogoTramites from './pages/CatalogoTramites.vue'
import AgregarHorario from './pages/AgregarHorario.vue'

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
        path: '/buscar-folio',
        name: 'BuscarFolio',
        component: BuscarFolio,
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
        path: '/edit-user',
        name: 'edituser',
        component: edituser,
        meta: {
            requiresAuth: false
        }
    },
    {
        path: '/create-user',
        name: 'createuser',
        component: createuser,
        meta: {
            requiresAuth: false
        }
    },
    {
        path: '/reporte-graficas',
        name: 'ReporteGraf',
        component: ReporteGraf,
        meta: {
            requiresAuth: false
        }
    },
    {
        path: '/reportes',
        name: 'Reportes',
        component: Reportes,
        meta: {
            requiresAuth: false
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