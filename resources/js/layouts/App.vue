<template>
    <v-app>
        <div v-if="currentRoute != 'Login'">
            <div class="header-fixed">
                <div class="text-center">
                    <img class="scale-logo-principal" width="200" height="75" src="../../../public/images/logo_pj_principal.svg" alt="">
                </div>
                <div class="first-line"></div>
            </div>
            <div class="text-right" style="margin-top: -3px;">
                <button class="button-usuarios" @click="irLogin()" v-if="token == 0">Usuarios</button>
                <button class="button-usuarios" @click="logout()" v-else>Cerrar Sesión</button>
            </div>
            <div>
                <div class="row justify-content-between">
                    <div class="col-sm-6 col-12">
                        <div class="ml-16">
                            <img class="boton_inicio" @click="irInicio()" width="200" height="75" src="../../../public/images/logo_citas_en_linea.svg" alt="">
                        </div>
                    </div>
                    <div class="col-sm-6 col-12">
                        <div class="div-buscar-cita" v-if="token == 0">
                            <label class="label-buscar-cita" for="buscar-cita">Si usted ya cuenta con una cita y desea imprimir su confirmación o cancelarla, ingrese a continuación su número de folio.</label>
                            <div class="row justify-content-between">
                                <div class="col-sm-9 col-12">
                                    <div id="input_container">
                                        <input id="buscar-cita" type="text" class="input-buscar-cita" @keyup.enter="buscarCita()" v-model="buscar_cita.folio">
                                        <img width="100" height="100" src="../../../public/images/lupa.png" id="input_img">
                                    </div>
                                </div>
                                <div class="col-sm-3 col-12">
                                    <button class="button-buscar-cita" @click="buscarCita()">Buscar</button>
                                </div>
                            </div>
                        </div>
                        <div v-else>
                            <nav class="navbar navbar-expand-lg navbar-light">
                                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                                  <ul class="navbar-nav">
                                    <li class="nav-item dropdown link-nav">
                                        <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Horarios
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                            <a class="dropdown-item link-nav" @click="this.$router.push('/agregar-horario')">Cargar Horario</a>
                                            <a class="dropdown-item link-nav" @click="this.$router.push('/editar-horario')">Modificar Horario</a>
                                        </div>
                                    </li>
                                    <li class="nav-item dropdown link-nav">
                                        <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Catalogos
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                            <a class="dropdown-item link-nav" @click="this.$router.push('/centros-atencion')">Centro de Atención</a>
                                            <a class="dropdown-item link-nav" @click="this.$router.push('/catalogo-requisitos')">Requisito</a>
                                            <a class="dropdown-item link-nav" @click="this.$router.push('/catalogo-tramites')">Tramite</a>
                                            <a class="dropdown-item link-nav" @click="this.$router.push('/catalogo-notas')">Notas</a>
                                            <a class="dropdown-item link-nav" @click="this.$router.push('/conf-whats')">Configuración WhatsApp</a>
                                        </div>
                                    </li>
                                    <li class="nav-item link-nav">
                                        <a class="nav-link" @click="this.$router.push('/catalogo-usuarios')">Usuario</a>
                                    </li>
                                    <li class="nav-item dropdown link-nav">
                                        <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                          Reportes
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                          <a class="dropdown-item link-nav" @click="this.$router.push('/reporte-graficas')">Gráficas</a>
                                          <a class="dropdown-item link-nav" @click="this.$router.push('/reportes')">Reporte de Citas</a>
                                        </div>
                                    </li>
                                  </ul>
                                </div>
                              </nav>
                        </div>
                    </div>
                </div>
            </div>
            <div class="second-line"></div>
            <div v-if="alert_cita_no_encontrada">
                <v-alert @input="closeAlert" text type="warning" color="#f5e79e" density="comfortable">No se encontro ninguna cita registrada con ese número de folio.</v-alert>
            </div>
        </div>

        <router-view></router-view>

        <footer v-if="currentRoute != 'Login'">
            <div class="third-line"></div>
            <div class="footer-info">
                <div class="row justify-content-around">
                    <div class="col-sm-12 col-md-4 text-center">
                        <img width="200" height="170" src="./../../../public/images/logo_pf_footer.svg" alt="">
                    </div>
                    <div class="col-sm-12 col-md-4 text-center div-texto-superior-footer">
                        <div>
                            <p class="texto-ciudad-judicial">Ciudad Judicial Siglo XXI</p>
                            <p class="texto-direccion">Periférico Ecológico Arco Sur No. 4000 San Andrés Cholula, Puebla. Reserva Territorial Atlixcáyotl, Teléfono (222) 223-84-00</p>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4 text-center div-texto-superior-footer">
                        <div>
                            <p class="texto-ciudad-judicial">Centro de Justicia</p>
                            <p class="texto-direccion">Prolongación de la Avenida 11 Sur No. 11921, Colonia: ExHacienda Castillotla, Teléfono. (222) 213 7370. C.P. 72498.</p>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-around">
                    <div class="col-sm-12 col-md-4 text-center">
                        <div class="row justify-content-around ml-8">
                            <div class="col-sm-12 col-md-6 text-center">
                                <img width="150" height="100" src="./../../../public/images/logo_transparencia_footer.png" alt="">
                            </div>
                            <div class="col-sm-12 col-md-6 text-center">
                                <ul class="lista-dos">
                                    <li>INFORMACIÓN PÚBLICA / DENUNCIAS</li>
                                    <li>SOLICITUDES</li>
                                    <li>RECURSOS</li>
                                    <li>BUSCADOR</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4 text-center div-texto-superior-footer">
                        <div>
                            <p class="texto-ciudad-judicial">Te Recomendamos</p>
                            <ul class="lista">
                                <li>Plan Institucional de Desarrollo</li>
                                <li>Comité de Control Interno</li>
                                <li>Presupuesto Basado en Resultados</li>
                                <li>Licitaciones</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4 text-center div-texto-superior-footer">
                        <div>
                            <p class="texto-ciudad-judicial">Organos Auxiliares</p>
                            <ul class="lista">
                                <li>Instituto de Estudios Judiciales</li>
                                <li>Centro Justicia Alternativa</li>
                                <li>Centro de Convivencia Familiar</li>
                                <li>Archivo Judicial</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-around">
                    <div class="col-auto text-center">
                        <p class="texto-ciudad-judicial">Aviso de Privacidad</p>
                    </div>
                </div>
                <div class="row justify-content-around">
                    <div class="col-auto text-center mb-4">
                        <img class="mr-2" width="30" height="30" src="./../../../public/images/logo_redes_1.png" alt="">
                        <img class="mr-3" width="30" height="30" src="./../../../public/images/logo_redes_2.png" alt="">
                        <img class="mr-3" width="30" height="30" src="./../../../public/images/logo_redes_3.png" alt="">
                        <img class="" width="30" height="30" src="./../../../public/images/logo_redes_4.png" alt="">
                    </div>
                </div>
            </div>
            <div class="fourth-line">
                <div class="text-center texto-final">
                    <p>© 2022 Poder Judicial del Estado de Puebla.</p>
                </div>
            </div>
        </footer>
    </v-app>
</template>

<script>
    import { defineComponent } from "vue"
    import { errorSweetAlert } from "../helpers/sweetAlertGlobals"

    export default defineComponent({
        name: 'app',
        data() {
            return {
                buscar_cita: {
                    folio: '',
                },
                alert_cita_no_encontrada: false,
            }
        },
        created() {
            this.getTramites()
        },
        computed: {
            currentRoute() {
                return this.$route.name
            },
            token() {
                return this.$store.getters.getToken
            },
        },
        methods: {
            irLogin() {
                this.$router.push('/login')
            },
            async getTramites() {
                try {
                    let response = await axios.get('/api/tramites-citas')
                    if (response.status === 200) {
                        if (response.data.status === "ok") {
                            this.$store.commit('setCatalogoTramitesTipo1', response.data.tramites_tipo_1)
                            this.$store.commit('setCatalogoTramitesTipo2', response.data.tramites_tipo_2)
                            this.$store.commit('setCatalogoTramitesTipo3', response.data.tramites_tipo_3)
                            this.$store.commit('setCatalogoTramitesTipo4', response.data.tramites_tipo_4)
                        } else {
                            errorSweetAlert(`${response.data.message}<br>Error: ${response.data.error}<br>Location: ${response.data.location}<br>Line: ${response.data.line}`)
                        }
                    } else {
                        errorSweetAlert('Ocurrió un error al obtener el catalogo de tramites para agendar citas.')
                    }
                } catch (error) {
                    errorSweetAlert('Ocurrió un error al obtener el catalogo de tramites para agendar citas.')
                }
            },
            irInicio() {
                this.$store.commit('setAsuntoStore', null)
                this.$router.push('/')
            },
            irCatalogoUSuarios() {
                this.$router.push('/catalogo-usuarios')
            },
            async buscarCita() {
                try {
                    let response = await axios.post('/api/buscar-cita', this.buscar_cita)
                    if (response.status === 200) {
                        if (response.data.status === "ok") {
                            this.$store.commit('setCitaAgendada', response.data.cita)
                            this.$router.push('/confirmacion-cita-buscada')
                        } else if (response.data.status === "not-found") {
                            this.alert_cita_no_encontrada = true
                            setTimeout(() => {
                                this.alert_cita_no_encontrada = false
                            }, "5000")
                        } else {
                            errorSweetAlert(`${response.data.message}<br>Error: ${response.data.error}<br>Location: ${response.data.location}<br>Line: ${response.data.line}`)
                        }
                    } else {
                        errorSweetAlert('Ocurrió un error al buscar cita.')
                    }
                } catch (error) {
                    errorSweetAlert('Ocurrió un error al buscar cita.')
                }
            },
            logout() {
                this.$store.dispatch('removeToken')
                this.$router.push('/login')
            }
        }
    })
</script>

<style scoped>
    .background-header {
        background-color: #6a73a0;
    }

    .background-footer {
        background-color: #353535;
        color: white;
    }

    .first-line {
        background-color: #b1bced;
        height: 5px;
    }

    .button-usuarios {
        background-color: #6a73a0;
        color: white;
        padding: 2px 10px 2px 30px;
        border-radius: 0 0 0 25px;
        font-size: 12px;
    }

    .label-buscar-cita {
        text-align: left;
        font-size: 14px;
        font-weight: bold;
        line-height: 16px;
        font-family: 'Lato', sans-serif;
    }

    .input-buscar-cita {
        padding: 10px;
        background-color: #e5e5e5;
        border-radius: 5px;
        width: 100%;
        text-decoration: none!important;
        height: 30px;
    }

    .input-buscar-cita:focus {
        outline: none;
    }

    .div-buscar-cita {
        margin-left: 10px;
        margin-right: 65px;
    }

    .button-buscar-cita {
        color: white;
        background-color: #353535;
        padding: 3px 10px;
        border-radius: 5px;
    }

    .second-line {
        margin-top: 15px;
        background-color: #c4f45d;
        height: 5px;
    }

    .scale-logo-principal {
        transform: scale(1.3);
    }

    .third-line {
        background-color: #c4f45d;
        height: 5px;
    }

    .footer-info {
        background-color: #646569;
    }

    .texto-ciudad-judicial {
        margin-top: 10px;
        text-align: left;
        color: white;
        font-weight: 900;
        font-size: 18px;
        padding-left: 60px;
        padding-inline: 60px;
        font-family: 'Lato', sans-serif;
    }

    .texto-direccion {
        text-align: left;
        color: white;
        font-size: 14px;
        padding-left: 60px;
        padding-right: 120px;
        text-align: justify;
        line-height: 18px;
        font-family: 'Lato', sans-serif;
    }

    .div-texto-superior-footer {
        padding-top: 12px;
    }

    .lista{
        text-align: left;
        color: white;
        font-size: 14px;
        padding-left: 60px;
        padding-right: 50px;
        line-height: 18px;
        margin-left: 14px;
        font-family: 'Lato', sans-serif;
    }

    .lista-dos {
        color: white;
        font-size: 14px;
        text-align: left;
        font-family: 'Lato', sans-serif;
    }

    .fourth-line {
        background-color: #353535;
        height: 30px;
    }

    .texto-final {
        color: white;
        font-size: 20px;
    }

    .icon {
        padding-right: 25px;
        background: url("./../../../public/images/lupa.png") no-repeat right;
        background-size: 20px;
        background-color: #e5e5e5;
    }

    #input_container { 
        position:relative;
        padding:0;
        margin:0;
    }

    #input_img {
        position:absolute;
        bottom:5px;
        right:10px;
        width:20px;
        height:20px;
    }

    .boton_inicio {
        cursor: pointer;
    }
</style>