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
                                        <input autocomplete="off" id="buscar-cita" type="text" class="input-buscar-cita" @keyup.enter="buscarCita()" v-model="this.$store.state.buscarCita">
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
                                    <li class="nav-item dropdown link-nav" v-if="rolId == 1">
                                        <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Horarios
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                            <a class="dropdown-item link-nav" @click="this.$router.push('/agregar-horario')">Cargar Horario</a>
                                            <a class="dropdown-item link-nav" @click="this.$router.push('/editar-horario')">Modificar Horario</a>
                                        </div>
                                    </li>
                                    <li class="nav-item dropdown link-nav" v-if="rolId == 1">
                                        <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Catálogos
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                            <a class="dropdown-item link-nav" @click="this.$router.push('/centros-atencion')">Centro de Atención</a>
                                            <a class="dropdown-item link-nav" @click="this.$router.push('/catalogo-requisitos')">Requisito</a>
                                            <a class="dropdown-item link-nav" @click="this.$router.push('/catalogo-tramites')">Trámite</a>
                                            <a class="dropdown-item link-nav" @click="this.$router.push('/catalogo-notas')">Notas</a>
                                            <a class="dropdown-item link-nav" @click="this.$router.push('/conf-whats')">Configuración WhatsApp</a>
                                        </div>
                                    </li>
                                    <li class="nav-item link-nav">
                                        <a class="nav-link" @click="this.$router.push('/citas-del-dia')">Citas del día</a>
                                    </li>
                                    <li class="nav-item link-nav" v-if="rolId == 1">
                                        <a class="nav-link" @click="this.$router.push('/catalogo-usuarios')">Usuario</a>
                                    </li>
                                    <li class="nav-item dropdown link-nav" v-if="rolId == 1">
                                        <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                          Reportes
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink" v-if="rolId == 1">
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
                <v-alert @input="closeAlert" text type="warning" color="#f5e79e" density="comfortable">No se encontró ninguna cita registrada con ese número de folio.</v-alert>
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
                            <p class="texto-direccion boton_inicio" @click="irUbiCiudadJudicial()">Periférico Ecológico Arco Sur No. 4000 San Andrés Cholula, Puebla. Reserva Territorial Atlixcáyotl, Teléfono (222) 223-84-00</p>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4 text-center div-texto-superior-footer">
                        <div>
                            <p class="texto-ciudad-judicial">Centro de Justicia</p>
                            <p class="texto-direccion boton_inicio" @click="irUbiCentroJusticia()">Prolongación de la Avenida 11 Sur No. 11921, Colonia: ExHacienda Castillotla, Teléfono. (222) 213 7370. C.P. 72498.</p>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-around">
                    <div class="col-sm-12 col-md-3 text-center div-texto-superior-footer">
                        
                    </div>
                    <div class="col-sm-12 col-md-8 text-center div-texto-superior-footer">
                        <div class="row justify-content-around">
                            <div class="col-sm-12 col-md-2 text-center div-texto-superior-footer">
                        
                            </div>
                            <!-- <div class="col-sm-12 col-md-8 text-center div-texto-superior-footer">
                                <div>
                                    <p class="texto-ciudad-judicial">Dirección General de Defensoría Pública</p>
                                    <ul class="lista">
                                        <li class="boton_inicio" @click="irDF()">Calle 14 Norte no. 205, Barrio La Luz</li>
                                    </ul>
                                </div>
                            </div> -->
                            <div class="col-sm-12 col-md-3 text-center div-texto-superior-footer">
                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-around">
                    <div class="col-sm-12 col-md-4 text-center">
                        <div class="row justify-content-around ml-8">
                            <div class="col-sm-12 col-md-6 text-center">
                                <img width="150" height="100" src="./../../../public/images/logo_transparencia_footer.png" alt="">
                            </div>
                        </div>
                    </div>

                    
                    
                    <div class="col-sm-12 col-md-4 text-center div-texto-superior-footer">
                        <div>
                            <p class="texto-ciudad-judicial">Te Recomendamos</p>
                            <ul class="lista">
                                <li class="boton_inicio" @click="irPj()">Poder Judicial del Estado de Puebla</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4 text-center div-texto-superior-footer">
                                <div>
                                    <p class="texto-ciudad-judicial">Dirección General de Defensoría Pública</p>
                                    <ul class="lista">
                                        <li class="boton_inicio" @click="irDF()">Calle 14 Norte no. 205, Barrio La Luz</li>
                                    </ul>
                                </div>
                    </div>
                    <!-- <div class="col-sm-12 col-md-4 text-center div-texto-superior-footer">
                        <div>
                            <p class="texto-ciudad-judicial">Órganos Auxiliares</p>
                            <ul class="lista">
                                <li class="boton_inicio" @click="irEEFJ()">Escuela Estatal de Formación Judicial</li>
                                <li class="boton_inicio" @click="irJusticiaAlter()">Centro Justicia Alternativa</li>
                                <li class="boton_inicio" @click="irCentroConFam()">Centro de Convivencia Familiar</li>
                                <li class="boton_inicio" @click="irArchivoJudi()">Archivo Judicial</li>
                            </ul>
                        </div>
                    </div> -->
                </div>
                <div class="row justify-content-around">
                    <div class="col-auto text-center">
                        <p class="texto-ciudad-judicial">Aviso de Privacidad</p>
                    </div>
                </div>
                <div class="row justify-content-around">
                    <div class="col-auto text-center mb-4">
                        <img class="mr-2 boton_inicio" width="30" height="30" src="./../../../public/images/logo_redes_1.png" alt="" @click="irFb()">
                        <img class="mr-3 boton_inicio" width="30" height="30" src="./../../../public/images/logo_redes_2.png" alt="" @click="irTwi()">
                        <img class="mr-3 boton_inicio" width="30" height="30" src="./../../../public/images/logo_redes_3.png" alt="" @click="irInst()">
                        <img class="boton_inicio" width="30" height="30" src="./../../../public/images/logo_redes_4.png" alt="" @click="irYt()">
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
            buscarCita2() {
                return this.$store.getters.getbuscarCita
            },
            rolId() {
                return this.$store.getters.getrolId
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
                        errorSweetAlert('Ocurrió un error al obtener el catálogo de tramites para agendar citas.')
                    }
                } catch (error) {
                    errorSweetAlert('Ocurrió un error al obtener el catálogo de trámites para agendar citas.')
                }
            },
            irInicio() {
                this.$store.commit('setAsuntoStore', null)
                this.$router.push('/')
            },
            irPj() {
                window.open("https://www.pjpuebla.gob.mx/")
            },
            irInst() {
                window.open("https://instagram.com/podjudpuebla?igshid=YmMyMTA2M2Y=")
            },
            irTwi() {
                window.open("https://twitter.com/PodJudPuebla?t=5IcEy9NNl88eRs4ea4p9Bw&s=09")
            },
            irFb() {
                window.open("https://www.facebook.com/PoderJudicialdelEstadodePuebla?mibextid=ZbWKwL")
            },
            irYt() {
                window.open("https://youtube.com/@PoderJudicialdelEstadodePuebla")
            },
            irUbiCiudadJudicial() {
                window.open("https://www.google.com.mx/maps/search/Perif%C3%A9rico+Ecol%C3%B3gico+Arco+Sur+No.+4000+San+Andr%C3%A9s+Cholula,+Puebla.+Reserva+Territorial+Atlixc%C3%A1yotl,/@19.014682,-98.2685127,17z/data=!3m1!4b1")
            },
            irUbiCentroJusticia() {
                window.open("https://www.google.com.mx/maps/place/Tribunal+Superior+de+Justicia+del+Estado/@18.9877513,-98.2508287,17z/data=!3m1!4b1!4m5!3m4!1s0x85cfc0e7e88fce75:0xda00bc5f61176b42!8m2!3d18.9877603!4d-98.2486794")
            },
            irEEFJ(){
                window.open("https://www.pjpuebla.gob.mx/secciones/oaiej/index.php")
            },
            irJusticiaAlter(){
                window.open("https://www.pjpuebla.gob.mx/secciones/oacja/index.php")
            },
            irCentroConFam(){
                window.open("https://www.pjpuebla.gob.mx/secciones/centrocf/index.php")
            },
            irArchivoJudi(){
                window.open("https://www.pjpuebla.gob.mx/secciones/oaarchivo-judicial/index.php")
            },
            irDF(){
                window.open("https://www.google.com/maps/place/Direcci%C3%B3n+General+de+Defensor%C3%ADa+P%C3%BAblica/@19.0405367,-98.190754,18.5z/data=!4m9!1m2!2m1!1sdefensoria+publica!3m5!1s0x85cfc0eff3339d39:0xbec385d1a8f05c4f!8m2!3d19.0413464!4d-98.1898678!15sChJkZWZlbnNvcmlhIHB1YmxpY2GSARFnb3Zlcm5tZW50X29mZmljZeABAA")
            },
            irCatalogoUSuarios() {
                this.$router.push('/catalogo-usuarios')
            },
            async buscarCita() {
                this.buscar_cita.folio = this.$store.state.buscarCita
                console.log(this.buscar_cita)
                try {
                    let response = await axios.post('/api/buscar-cita', this.buscar_cita)
                    if (response.status === 200) {
                        if (response.data.status === "ok") {
                            this.$store.commit('setCitaAgendada', response.data.cita)
                            this.$router.push('/confirmacion-cita-buscada')
                            this.$store.state.buscarCita = ''
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
                this.$store.dispatch('removerolId')
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