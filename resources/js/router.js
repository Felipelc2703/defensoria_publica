import { createWebHistory, createRouter } from "vue-router"
import Home from './pages/Home.vue'
import Login from './pages/Login.vue'
import Dashboard from './pages/Dashboard.vue'
import CrearCita from './pages/CrearCita.vue'
import CrearCitaJuzgado from './pages/CrearCitaJuzgado.vue'
import CrearCitaConsejero from './pages/CrearCitaConsejero.vue'
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
import CitasDelDia from './pages/CitasDelDia.vue'
import DatosCita from './pages/DatosCita.vue'

import AgregarHorarioJuzgado from './pages/juzgados/AgregarHorarioJuzgado.vue'
import EditarHorarioJuzgado from './pages/juzgados/EditarHorarioJuzgado.vue'
import CitasDelDiaJuez from './pages/juzgados/CitasDelDiaJuez.vue'
import ConfirmacionCitaJuzgado from './pages/juzgados/ConfirmacionCitaJuzgado.vue'
import ConfirmacionCitaBuscadaJuzgado from './pages/juzgados/ConfirmacionCitaBuscadaJuzgado.vue'
import ReporteGraficasJuez from './pages/juzgados/ReporteGraficasJuez.vue'
import ReportesJuez from './pages/juzgados/ReportesJuez.vue'
import ReporteJuzgados from './pages/juzgados/ReporteJuzgados.vue'
import CatalogoUsuariosJuez from './pages/juzgados/CatalogoUsuariosJuez.vue'
import CatalogoJueces from './pages/juzgados/CatalogoJueces.vue'
import CatalogoJuzgados from './pages/juzgados/CatalogoJuzgados.vue'

import AgregarHorarioConsejo from './pages/consejeros/AgregarHorarioConsejo.vue'
import CatalogoUsuariosConsejo from './pages/consejeros/CatalogoUsuariosConsejo.vue'
import CatalogoConsejeros from './pages/consejeros/CatalogoConsejeros.vue'
import EditarHorarioConsejero from './pages/consejeros/EditarHorarioConsejero.vue'
import CitasDelDiaConsejero from './pages/consejeros/CitasDelDiaConsejero.vue'
import ConfirmacionCitaConsejero from './pages/consejeros/ConfirmacionCitaConsejero.vue'
import ConfirmacionCitaBuscadaConsejero from './pages/consejeros/ConfirmacionCitaBuscadaConsejero.vue'
import ReporteGraficasConsejero from './pages/consejeros/ReporteGraficasConsejero.vue'
import ReportesConsejero from './pages/consejeros/ReportesConsejero.vue'
import ReportesConsejeros from './pages/consejeros/ReportesConsejeros.vue'

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
        path: '/crear-cita-juzgado',
        name: 'CrearCitaJuzgado',
        component: CrearCitaJuzgado,
    },
    {
        path: '/crear-cita-consejero',
        name: 'CrearCitaConsejero',
        component: CrearCitaConsejero,
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
    {
        path: '/citas-del-dia',
        name: 'CitasDelDia',
        component: CitasDelDia,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/datos-cita',
        name: 'DatosCita',
        component: DatosCita
    },
    {
        path: '/agregar-horario-juzgado',
        name: 'AgregarHorarioJuzgado',
        component: AgregarHorarioJuzgado,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/editar-horario-juzgado',
        name: 'EditarHorarioJuzgado',
        component: EditarHorarioJuzgado,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/citas-del-dia-juez',
        name: 'CitasDelDiaJuez',
        component: CitasDelDiaJuez,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/confirmacion-cita-juzgado',
        name: 'ConfirmacionCitaJuzgado',
        component: ConfirmacionCitaJuzgado,
    },
    {
        path: '/confirmacion-cita-consejero',
        name: 'ConfirmacionCitaConsejero',
        component: ConfirmacionCitaConsejero,
    },
    {
        path: '/confirmacion-cita-buscada-juzgado',
        name: 'ConfirmacionCitaBuscadaJuzgado',
        component: ConfirmacionCitaBuscadaJuzgado,
    },
    {
        path: '/reporte-graficas-juez',
        name: 'ReporteGraficasJuez',
        component: ReporteGraficasJuez,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/reportes-juez',
        name: 'ReportesJuez',
        component: ReportesJuez,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/reportes-juzgados',
        name: 'ReporteJuzgados',
        component: ReporteJuzgados,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/catalogo-usuarios-juez',
        name: 'CatalogoUsuariosJuez',
        component: CatalogoUsuariosJuez,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/catalogo-jueces',
        name: 'CatalogoJueces',
        component: CatalogoJueces,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/catalogo-juzgados',
        name: 'CatalogoJuzgados',
        component: CatalogoJuzgados,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/agregar-horario-consejero',
        name: 'AgregarHorarioConsejo',
        component: AgregarHorarioConsejo,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/catalogo-usuarios-consejo',
        name: 'CatalogoUsuariosConsejo',
        component: CatalogoUsuariosConsejo,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/catalogo-consejeros',
        name: 'CatalogoConsejeros',
        component: CatalogoConsejeros,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/editar-horario-consejero',
        name: 'EditarHorarioConsejero',
        component: EditarHorarioConsejero,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/citas-del-dia-consejero',
        name: 'CitasDelDiaConsejero',
        component: CitasDelDiaConsejero,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/confirmacion-cita-buscada-consejero',
        name: 'ConfirmacionCitaBuscadaConsejero',
        component: ConfirmacionCitaBuscadaConsejero,
    },
    {
        path: '/reporte-graficas-consejero',
        name: 'ReporteGraficasConsejero',
        component: ReporteGraficasConsejero,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/reportes-consejero',
        name: 'ReportesConsejero',
        component: ReportesConsejero,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/reportes-consejeros',
        name: 'ReportesConsejeros',
        component: ReportesConsejeros,
        meta: {
            requiresAuth: true
        }
    },
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

router.beforeEach((to, from, next) => {
    const requiresAuth = to.matched.some(record => record.meta.requiresAuth)
    const currentUser = store.state.user

    if (requiresAuth && !currentUser) {
        next('/login')
    } else if (to.path == '/login' && currentUser) {
        next('/citas-del-dia')
    } else {
        next()
    }
})

export default router