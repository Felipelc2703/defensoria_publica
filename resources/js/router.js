import { createWebHistory, createRouter } from "vue-router"
import Home from './pages/Home.vue'
import Login from './pages/Login.vue'
import Register from './pages/Register.vue'
import Dashboard from './pages/Dashboard.vue'
import CrearCita from './pages/CrearCita.vue'
import confwhats from './pages/confwhats.vue'
import edituser from './pages/edituser.vue'
import createuser from './pages/createuser.vue'
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
        path: '/crear-cita',
        name: 'CrearCita',
        component: CrearCita,
        meta: {
            requiresAuth: false
        }
    },
    {
        path: '/conf-whats',
        name: 'confwhats',
        component: confwhats,
        meta: {
            requiresAuth: false
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