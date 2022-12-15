<template>
    <div class="container">
        <div class="text-center mt-4">
            <h2 class="text-left">Defensoría Pública</h2>
            <h3 class="text-left">Citas en Linea</h3>
        </div>
        <div class="text-center mt-4 mb-4">
            <div class="row justify-content-around">
                <div class="col-sm-12 col-md-6 col-lg-3 mt-4">
                    <v-card variant="tonal">
                        <p><span>Asuntos Civiles y Familiares</span></p>
                        <v-icon icon="mdi-account-child"></v-icon>
                    </v-card>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-3 mt-4">
                    <v-card variant="tonal">
                        <p><span>Asuntos Administrativos</span></p>
                        <v-icon icon="mdi-folder"></v-icon>
                    </v-card>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-3 mt-4">
                    <v-card variant="tonal">
                        <p><span>Asuntos Laborales</span></p>
                        <v-icon icon="mdi-account-hard-hat"></v-icon>
                    </v-card>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-3 mt-4">
                    <v-card variant="tonal">
                        <p><span>Ejecución de Sentencias</span></p>
                        <v-icon icon="mdi-account-account-tie"></v-icon>
                    </v-card>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { defineComponent } from "@vue/runtime-core"
    import { successSweetAlert } from '../helpers/sweetAlertGlobals'

    export default defineComponent({
        name: 'home',
        data() {
            return {
                tab: null,
            }
        },
        created() {
            this.probarAlert()
        },
        methods: {
            probarAlert() {
                successSweetAlert('¡Bienvenido!')
            }
        }
    })
</script>