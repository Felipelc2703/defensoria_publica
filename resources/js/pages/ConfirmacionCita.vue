<template>
    <div class="m-0">
        <div class="container pt-6 pb-6">
            <h5 class="titulo-confirmacion">Confirmación de Cita</h5>
            <p><span class="formato-texto">Información Importante</span></p>
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
                    <button class="boton-cancelar" @click="cancelarCita()">Cancelar Cita</button>
                </div>
                <div class="col-sm-12 col-md-6">
                    <button class="boton-imprimir" @click="imprimirCita()">Imprimir</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { defineComponent } from "vue";

    export default defineComponent({
        name: 'confirmacion-cita',
        computed: {
            citaAgendada() {
                return this.$store.getters.getCitaAgendada
            }
        },
        methods: {
            cancelarCita() {

            },
            imprimirCita() {

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
</style>