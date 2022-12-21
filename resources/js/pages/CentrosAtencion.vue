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
        <EasyDataTable 
            :headers="headers" 
            :items="items"
            alternating
        >
            <template #item-actions="item">
                <div class="operation-wrapper">
                    
                    <v-btn class="mb-4"
                        icon
                        @click="agregarCentro" >
                        <v-icon icon="mdi-text-box-edit-outline"></v-icon>
                    </v-btn>
                    <v-btn class="mb-4"
                        icon    
                        @click="agregarCentro" >
                        <v-icon icon="mdi-text-box-edit-outline"></v-icon>
                    </v-btn>
                </div>
            </template>
        </EasyDataTable>



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
                        <!-- <template>
                            <EasyDataTable
                                :ref="centro.tramites"
                                v-model:items-selected="itemsSelected"
                                :headers="headers"
                                :items="items"
                            />
                            <br />
                           
                        </template> -->
                        
                        <div v-for="(tramite,index) in items" :key="index">
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
    import { ref } from "vue";
    // import { Header, Item } from "vue3-easy-data-table";
    // import type { Vue3EasyDataTable } from "vue3-easy-data-table";
    export default {
        data() {
            return {
                dialogAgregarCentro: false,
                // itemsSelected = ref<Item[]>([]),
               // itemsSelected:[],
                centro: {
                    nombre: '',
                    direccion: '',
                    telefono: '',
                    num_cajas: '',
                    // tramites:ref<centro.tramites>([])
                },  
                // itemsSelected: item[] = ref([item]),
                headers: [
                { 
                    text: "REQUISITO", value: "nombre" 
                },
                { 
                    text: "REQUISITO PADRE", value: "requi_padre"
                },
                { 
                    text: 'ACCIONES', value: 'actions'
                }
                ],
                dialogAgregarCentro: false,
                items:[
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