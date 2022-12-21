<template>
    <div class="container">
        <div class="text-center">
            <h2>CENTRO DE ATENCIÓN</h2>
            <v-btn class="mb-4"
                @click="agregarCentro" >
                <v-icon icon="mdi-text-box-edit-outline"></v-icon>
            </v-btn>
        </div>
        <v-select
            label="Seleccione el tipo de requisito"
            :items="['California', 'Colorado', 'Florida', 'Georgia', 'Texas', 'Wyoming']"
        >
        </v-select>
        <v-table>
            <thead>
            <tr>
                <th class="text-left">
                    Requisito
                </th>
                <th class="text-left">
                    Requisito Padre
                </th>
                <th class="text-left">
                    Acciones
                </th>
            </tr>
            </thead>
            <tbody>
                <tr
                    v-for="item in tramites"
                    :key="item.id"
                >
                    <td>{{ item.nombre }}</td>
                    <td>{{ item.requi_padre }}</td>
                    <td>
                        <v-btn class="mb-4"
                            @click="editarCentro" >
                            <v-icon icon="mdi-text-box-edit-outline"></v-icon>
                        </v-btn>
                        <v-btn class="mb-4"
                            @click="eliminarCentro" >
                            <v-icon icon="mdi-text-box-edit-outline"></v-icon>
                        </v-btn>
                    </td>
                </tr>
                </tbody>
        </v-table>

        <v-dialog
            v-model="dialogAgregarCentro"
            max-width="700px"
            >
            <v-card>
                <v-card-title>
                    <h3>Agregar Oficina</h3>
                </v-card-title>
                <v-divider></v-divider>
                <v-form>
                    <v-card-text>
                    
                        <v-text-field
                            variant="solo"
                            v-model="centro.nombre"
                            label="Nombre"
                        ></v-text-field>
                        <v-text-field
                            variant="solo"
                            v-model="centro.direccion"
                            label="Direccion"
                        ></v-text-field>
                        <v-row
                            justify="space-between"
                        >
                            <v-col
                                cols="12"
                                md="6"
                            >
                                <v-text-field
                                    variant="solo"
                                    v-model="centro.telefono"
                                    label="Telefono"
                                    counter="10"
                                    maxlength="10"
                                >
                                </v-text-field>
                            </v-col>

                            <v-col
                                cols="12"
                                md="6"
                            >
                                <v-text-field
                                    variant="solo"
                                    v-model="centro.num_cajas"
                                    label="Numero de cajas"
                                    type="number"
                                >
                                </v-text-field>
                            </v-col>
                        </v-row>
                        <v-divider>
                        </v-divider>
                        <p>Seleccione los tramites disponibles para esta oficina</p>
                        
                        <div v-for="(tramite,index) in tramites" :key="index">
                            <v-checkbox 
                                :label = "tramite.nombre"
                                :value = "tramite.id"
                            ></v-checkbox>

                        </div>
                    </v-card-text>
                </v-form>

                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        variant="flat"
                        color="warning"
                        @click="cancelar()"
                    >
                        Cancelar
                    </v-btn>
                    <v-btn
                        variant="flat"
                        color="error"
                        @click="aceptar()"
                    >
                        Guardar
                    </v-btn>
                </v-card-actions>
                

            </v-card>
        </v-dialog>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                centro: {
                    nombre: '',
                    direccion: '',
                    telefono: '',
                    num_cajas: '',
                    // tramites: [],
                },
                page: 1,
                pageCount: 0,
                itemsPerPage: 10,
                headers: [
                    {
                        text:'REQUISITO',
                        value:'REQUISITO'
                    },
                    {
                        text:'REQUISITO PADRE',
                    },
                    {
                        text:'ACCIONES'
                    }
                ],
                dialogAgregarCentro: false,
                tramites: [
                    {
                        id:1,
                        nombre: 'ALIMENTOS',
                        requi_padre:'',
                    },
                    {
                        id:2,
                        nombre: 'GUARDA Y CUSTODIA',
                        requi_padre:'',
                    },
                    {
                        id:3,
                        nombre: 'DIVORCIO',
                        requi_padre:'',
                    },
                    {
                        id:4,
                        nombre: 'VISITA YT CONVIVENCIA',
                        requi_padre:'',
                    },
                    {
                        id:5,
                        nombre: 'RECUPERACION DE MENOR',
                        requi_padre:'',
                    },
                    {
                        id:6,
                        nombre: 'PATERNIDAD',
                        requi_padre:'',
                    },
                ]
            }
        },
        methods: {
            agregarCentro() {
                console.log('agregar centro')
                this.dialogAgregarCentro = true
            }  
        },
    }
</script>