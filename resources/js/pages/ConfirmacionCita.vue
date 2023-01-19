<template>
    <div class="m-0">
        <div class="container pt-6 pb-6">
            <h5 class="titulo-confirmacion">Confirmación de Cita</h5>
            <p><span class="formato-texto">Información importante</span></p>
            <p class="texto-cita">Estimado(a) <span class="texto-nombre">{{citaAgendada.nombre}}</span> su cita para el trámite <span class="texto-tramite">{{citaAgendada.tramite}}</span> ha quedado agendada para el {{citaAgendada.fecha}}, a las {{citaAgendada.hora}} horas.</p>
            <p class="texto-cita">Por lo que reiteramos debe presentarse en el Centro de Atención de <span class="centro-atencion-cita">{{citaAgendada.centro_atencion}}</span> ubicado en <span class="direccion-cita">{{citaAgendada.direccion_centro_atencion}}</span>, en la fecha y hora antes mencionada.</p>
            <br>
            <p>Le recordamos que el <span class="texto-folio">folio</span> de su Cita es:</p>
            <br>
            <br>
            <h4 class="folio-cita">{{citaAgendada.folio}}</h4>
            <div class="first-line"></div>
            <div class="mt-6 text-center row">
                <div class="col-sm-12 col-md-6">
                    <button class="boton-cancelar" @click="abrirModalCancelarCita()">Cancelar Cita</button>
                </div>
                <div class="col-sm-12 col-md-6">
                    <button class="boton-imprimir" @click="imprimirCita()">Imprimir</button>
                </div>
            </div>
        </div>
        <v-dialog
            v-model="dialogCancelarCita"
            max-width="600px"
            persistent
        >
            <v-card>
                <div class="container mb-2">
                    <div class="text-center mt-10 mb-10">
                        <img width="123" height="123" src="./../../../public/images/logo_calendario_cancelar.svg" alt="">
                    </div>
                    <div class="text-center mt-10 mb-10">
                        <p class="texto-confirmacion-cancelar-cita">¿Seguro desea cancelar su cita?</p>
                    </div>
                    <div class="mt-10 mb-10 text-center row">
                        <div class="col-sm-12 col-md-6 text-ri">
                            <button class="boton-cerrar-modal" @click="dialogCancelarCita = false">No!</button>
                        </div>
                        <div class="col-sm-12 col-md-6 text-left">
                            <button class="boton-cancelar-cita" @click="cancelarCita()">Si, Cancelar Cita</button>
                        </div>
                    </div>
                </div>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
    import { defineComponent } from "vue";
    import { errorSweetAlert, successSweetAlert } from "../helpers/sweetAlertGlobals"

    export default defineComponent({
        name: 'confirmacion-cita',
        data(){
            return{
                dialogCancelarCita: false,
            }
        },
        computed: {
            citaAgendada() {
                return this.$store.getters.getCitaAgendada
            }
        },
        methods: {
            abrirModalCancelarCita(){
                this.dialogCancelarCita = true
            },
            async cancelarCita() {
                try {
                    let response = await axios.get(`/api/cancelar-cita/${this.citaAgendada.id}`)
                    if (response.status === 200) {
                        if (response.data.status === "ok") {
                            successSweetAlert(response.data.message)
                            this.$router.push('/')
                        } else {
                            errorSweetAlert(`${response.data.message}<br>Error: ${response.data.error}<br>Location: ${response.data.location}<br>Line: ${response.data.line}`)
                        }
                    } else {
                        errorSweetAlert('Ocurrió un error al cancelar la cita.')
                    }
                } catch (error) {
                    errorSweetAlert('Ocurrió un error al cancelar la cita.')
                }
                
            },
            async imprimirCita() {
                try {
                    let response = await axios.get(`/api/imprimir-cita/${this.citaAgendada.id}`, {
                        responseType: 'arraybuffer'
                    }).then((response)=>{                                                        
                        let blob = new Blob([response.data], { type: 'application/pdf' })
                        let link = document.createElement('a')
                        link.href = window.URL.createObjectURL(blob)
                        // link.download = `${item.nombre}.pdf
                        link.download = 'confirmacion_cita.pdf'
                        link.click()
                    })
                    // console.log(response)
                } catch (error) {
                    console.log("error: ", error)
                }

            }
        }
    })
</script>

<style scoped>
    .titulo-confirmacion {
        font-family: 'Lato', sans-serif;
        font-weight: 900;
        font-size: 18pt;
    }

    .formato-texto {
        font-family: 'Lato', sans-serif;
        font-size: 14pt;
    }

    .texto-cita {
        text-align: justify;
    }

    .texto-nombre {
        text-transform: uppercase;
    }

    .texto-tramite {
        text-transform: uppercase;
    }

    .centro-atencion-cita {
        text-transform: uppercase;
    }

    .direccion-cita {
        text-transform: uppercase;
    }

    .texto-folio {
        text-transform: uppercase;
        font-weight: 900;
        font-size: 15pt;
    }

    .folio-cita {
        text-transform: uppercase;
        font-weight: 900;
        font-size: 37pt;
        color: #6a73a0;
        text-align: center;
    }

    .first-line {
        background-color: #b1bced;
        height: 3px;
    }
    
    .boton-cancelar {
        background-color: #6a73a0;
        color: white;
        font-family: 'Lato', sans-serif;
        font-size: 15pt;
        font-weight: bold;
        padding: 6px 30px;
        margin-right: 15px;
        border-radius: 20px;
    }

    .boton-imprimir {
        background-color: #a4bc4b;
        color: white;
        font-family: 'Lato', sans-serif;
        font-size: 15pt;
        font-weight: bold;
        padding: 6px 50px;
        margin-left: 15px;
        border-radius: 20px;
    }
    
    .texto-confirmacion-cancelar-cita {
        font-family: 'Lato', sans-serif;
        font-size: 18pt;
        font-weight: 400;
    }

    .boton-cerrar-modal {
        background-color: #6a73a0;
        color: white;
        font-family: 'Lato', sans-serif;
        font-size: 12pt;
        font-weight: bold;
        padding: 6px 80px;
        margin-right: 15px;
        border-radius: 20px;
    }

    .boton-cancelar-cita {
        background-color: #a4bc4b;
        color: white;
        font-family: 'Lato', sans-serif;
        font-size: 12pt;
        font-weight: bold;
        padding: 6px 50px;
        margin-left: 15px;
        border-radius: 20px;
    }
</style>