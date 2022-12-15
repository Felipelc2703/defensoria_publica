<template>
    <div>
        <v-dialog
            v-model="dialogRequisitos"
            max-width="600px"
        >
            <v-card>
                <v-card-title>
                    Sistema de Citas
                </v-card-title>
                <v-divider></v-divider>
                <v-card-text>
                    <div class="m-1">
                        <p><span>Estimado ciudadano:</span></p>
                        <v-divider></v-divider>
                        <p>A continuación se muestran los requisitos que deberá presentar ante el Centro de Atención para realizar el trámite; favor de seleccionar aquéllos con los que cuenta:</p>
                        <v-card class="mb-14">
                            <v-toolbar color="#691C32">
                                <v-toolbar-title class="text-white">Requisitos</v-toolbar-title>
                            </v-toolbar>
                            <v-list lines="three" select-strategy="multiple">
                                <v-list-item value="notifications">
                                    <v-list-item-title>Acta de matrimonio (en su caso de existir).</v-list-item-title>

                                    <!-- <v-list-item-subtitle>
                                    Notify me about updates to apps or games that I downloaded
                                    </v-list-item-subtitle> -->

                                    <template v-slot:prepend="{ isActive }">
                                        <v-list-item-action end>
                                            <v-checkbox-btn :model-value="isActive"></v-checkbox-btn>
                                        </v-list-item-action>
                                    </template>
                                </v-list-item>

                                <v-list-item value="sound">
                                    

                                    <v-list-item-title>Acta de nacimiento de sus hijos.</v-list-item-title>

                                    <!-- <v-list-item-subtitle>
                                    Auto-update apps at any time. Data charges may apply
                                    </v-list-item-subtitle> -->

                                    <template v-slot:prepend="{ isActive }">
                                        <v-list-item-action end>
                                            <v-checkbox-btn :model-value="isActive"></v-checkbox-btn>
                                        </v-list-item-action>
                                    </template>
                                </v-list-item>

                                <v-list-item value="domicilio">

                                    <v-list-item-title>Domicilio de la persona que se va a demandar (calle, número, colonia).</v-list-item-title>

                                    <!-- <v-list-item-subtitle>
                                    Automatically add home screen widgets when downloads complete
                                    </v-list-item-subtitle> -->

                                    <template v-slot:prepend="{ isActive }">
                                        <v-list-item-action end>
                                            <v-checkbox-btn :model-value="isActive"></v-checkbox-btn>
                                        </v-list-item-action>
                                    </template>
                                </v-list-item>

                                <v-list-item value="testigos">

                                    <v-list-item-title>Nombre y domicilio de 2 testigos con copia de credencial de elector, (pueden ser familiares y una vez propuestos no los puede cambiar) traerlos a los testigos hasta que se les indique</v-list-item-title>

                                    <!-- <v-list-item-subtitle>
                                    Automatically add home screen widgets when downloads complete
                                    </v-list-item-subtitle> -->

                                    <template v-slot:prepend="{ isActive }">
                                        <v-list-item-action end>
                                            <v-checkbox-btn :model-value="isActive"></v-checkbox-btn>
                                        </v-list-item-action>
                                    </template>
                                </v-list-item>

                                <v-list-item value="hechos">

                                    <v-list-item-title>Descripción detallada de los hechos (por escritos señalando circunstancia de tiempo, modo y lugar)</v-list-item-title>

                                    <!-- <v-list-item-subtitle>
                                    Automatically add home screen widgets when downloads complete
                                    </v-list-item-subtitle> -->

                                    <template v-slot:prepend="{ isActive }">
                                        <v-list-item-action end>
                                            <v-checkbox-btn :model-value="isActive"></v-checkbox-btn>
                                        </v-list-item-action>
                                    </template>
                                </v-list-item>
                            </v-list>
                        </v-card>
                        <p>Si usted ya cuenta con una cita agendada y desea consultarla, dé click aquí. Todos los trámites son personales. Para verificar las especificaciones de los requisitos dé click <span class="text-red">aquí</span>.</p>
                    </div>
                </v-card-text>
                <v-divider></v-divider>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        variant="flat"
                        color="error"
                        @click="cancelar()"
                    >
                        Cancelar
                    </v-btn>
                    <v-btn
                        variant="flat"
                        color="error"
                        @click="agendar()"
                    >
                        Aceptar
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
    export default {
        name: 'prueba',
        data() {
            return {
                dialogRequisitos: true,
            }
        },
        methods: {
            cancelar() {
                this.dialogRequisitos = false
                this.$router.push('/')
            },
            agendar() {
                this.dialogRequisitos = false
            }
        }
    }
</script>