<template>
    <div class="container mb-6">
        <div class="text-center my-6">
            <h2>Configurar WhatsApp</h2>
        </div>

        <div class="my-6 px-4 py-4">
            <v-form class="col-12" ref="formAgregarWhats">
                <v-text-field
                    v-model="data.telefono"
                    variant="solo"
                    type="number"
                    label="Número de teléfono"
                    :rules="telefonoRules"
                ></v-text-field>
                <div class="row justify-content-between">
                    <div class="col-md-6 col-12">
                        <v-text-field
                            v-model="data.hora_inicio"
                            type="time"
                            variant="solo"
                            label="Hora inicial"
                            :rules="horaInicioRules"
                        ></v-text-field>
                    </div>
                    <div class="col-md-6 col-12">
                        <v-text-field
                            v-model="data.hora_fin"
                            type="time"
                            variant="solo"
                            label="Hora final"
                            :rules="horaFinRules"
                        ></v-text-field>
                    </div>
                </div>
                Días disponibles:
                <br>
                <input type="checkbox" id="check_dia1" v-model="data.dia1">
                <label for="check_dia1">&nbsp;Lunes</label>
                <br>
                <input type="checkbox" id="check_dia2" v-model="data.dia2">
                <label for="check_dia2">&nbsp;Martes</label>
                <br>
                <input type="checkbox" id="check_dia3" v-model="data.dia3">
                <label for="check_dia3">&nbsp;Miércoles</label>
                <br>
                <input type="checkbox" id="check_dia4" v-model="data.dia4">
                <label for="check_dia4">&nbsp;Jueves</label>
                <br>
                <input type="checkbox" id="check_dia5" v-model="data.dia5">
                <label for="check_dia5">&nbsp;Viernes</label>
                <br>
                <input type="checkbox" id="check_dia6" v-model="data.dia6">
                <label for="check_dia6">&nbsp;Sábado</label>
                <br>
                <input type="checkbox" id="check_dia7" v-model="data.dia7">
                <label for="check_dia7">&nbsp;Domingo</label>
                <div class="text-center mt-4">
                    <v-btn
                        variant="flat"
                        color="#A3BC39"
                        class="boton-nuevo"
                        @click="guardarNumeroWhats()"
                        >
                        Guardar
                    </v-btn>
                </div>
            </v-form>
        </div>
    </div>
</template>

<script>
    import { defineComponent } from 'vue';
    import { errorSweetAlert, successSweetAlert } from "../helpers/sweetAlertGlobals"

    export default defineComponent({
        name: 'confwhats',
        data() {
            return {
                data: {
                    id: null,
                    telefono: '',
                    hora_inicio: '',
                    hora_fin: '',
                    dia1: false,
                    dia2: false,
                    dia3: false,
                    dia4: false,
                    dia5: false,
                    dia6: false,
                    dia7: false,
                },
                telefonoRules: [
                    v => !!v || 'El campo de número de teléfono es requerido',
                    v => v.length == 10 || 'El número de teléfono debe ser valido'
                ],
                horaInicioRules: [
                    v => !!v || 'El campo de hora inicial es requerido'
                ],
                horaFinRules: [
                    v => !!v || 'El campo de hora final es requerido'
                ],
            }
        },
        created() {
            this.getWhatsApp()
        },
        methods: {
            async guardarNumeroWhats () {
                const { valid } = await this.$refs.formAgregarWhats.validate()
                if (valid) {
                    Swal.fire({
                        title: '¿Guardar?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3085D6',
                        cancelButtonColor: '#D33',
                        confirmButtonText: 'Si, guardar',
                        cancelButtonText: 'Cancelar',
                        showLoaderOnConfirm: true,
                        preConfirm: async () => {
                            try {
                                let response = await axios.post('/api/whatsapp/guardar-numero', this.data)
                                return response
                            } catch (error) {
                                errorSweetAlert('Ocurrió un error al guardar número de contacto de WhatsApp.')
                            }
                        },
                        allowOutsideClick: () => !Swal.isLoading()
                    }).then((result) => {
                        if (result.isConfirmed) {
                            if (result.value.status === 200) {
                                if (result.value.data.status === "ok") {
                                    successSweetAlert(result.value.data.message)
                                    
                                } else {
                                    errorSweetAlert(`${result.value.data.message}<br>Error: ${result.value.data.error}<br>Location: ${result.value.data.location}<br>Line: ${result.value.data.line}`)
                                }
                            } else {
                                errorSweetAlert('Ocurrió un error al guardar número de contacto de WhatsApp.')
                            }
                        }
                    })
                }
            },
            async getWhatsApp() {
                try {
                    let response = await axios.get('/api/whatsapp/get-numero')
                    if (response.status === 200) {
                        if (response.data.status === "ok") {
                            this.data.id = response.data.registro.id
                            this.data.telefono = response.data.registro.telefono
                            this.data.hora_inicio = response.data.registro.hora_inicio
                            this.data.hora_fin = response.data.registro.hora_fin
                            this.data.dia1 = response.data.registro.dia1
                            this.data.dia2 = response.data.registro.dia2
                            this.data.dia3 = response.data.registro.dia3
                            this.data.dia4 = response.data.registro.dia4
                            this.data.dia5 = response.data.registro.dia5
                            this.data.dia6 = response.data.registro.dia6
                            this.data.dia7 = response.data.registro.dia7
                        } else if (response.data.status === "no-data") {
                            
                        } else {
                            // errorSweetAlert(`${response.data.message}<br>Error: ${response.data.error}<br>Location: ${response.data.location}<br>Line: ${response.data.line}`)
                        }
                    } else {
                        // errorSweetAlert('Ocurrió un error al obtener el catalogo de tramites para agendar citas.')
                    }
                } catch (error) {
                    // errorSweetAlert('Ocurrió un error al obtener el catalogo de tramites para agendar citas.')
                }
            }
        }
    })
</script>
