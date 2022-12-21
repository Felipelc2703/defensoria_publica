import { createWebHistory, createRouter } from "vue-router"
import Home from './pages/Home.vue'
import Login from './pages/Login.vue'
import Register from './pages/Register.vue'
import Dashboard from './pages/Dashboard.vue'
import Prueba from './pages/Prueba.vue'
import CrearCita from './pages/CrearCita.vue'
import BuscarFolio from './pages/BuscarFolio.vue'
import CentrosAtencion from './pages/CentrosAtencion.vue'
import store from './store'

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
        path: '/prueba',
        name: Prueba,
        component: Prueba,
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
    }
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