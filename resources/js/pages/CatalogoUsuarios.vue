<template>
    <div class="container">
        <div class="text-center">
            <h2>USUARIOS</h2>
            <v-btn class="mb-4"
                @click="openModal" >
                <v-icon icon="mdi-text-box-edit-outline"></v-icon>
            </v-btn>
        </div>
        <EasyDataTable 
            :headers="headers" 
            :items="items"
            alternating
        >
            <template #item-actions="item">
                <div class="operation-wrapper">
                    
                    <v-btn class="mb-4"
                        icon
                        @click="editarUsuario" >
                        <v-icon icon="mdi-pencil-outline"></v-icon>
                    </v-btn>
                    <v-btn class="mb-4"
                        icon    
                        @click="eliminarUsuario" >
                        <v-icon icon="mdi-trash-can"></v-icon>
                    </v-btn>
                </div>
            </template>
        </EasyDataTable>

        <!-- modal para agregar usuario -->
        <v-dialog
            v-model="dialogAgregarUsuarios"
            max-width="700px"
            >
            <v-card>
                <v-card-title>
                    <h3>Agregar Usuario</h3>
                </v-card-title>
                <v-divider></v-divider>
                <v-form>
                    <v-card-text>
                    
                        <v-text-field
                            variant="solo"
                            v-model="usuario.nombre"
                            label="Nombre Usuario"
                        ></v-text-field>

                        <v-text-field
                            variant="solo"
                            v-model="usuario.clave"
                            label="Clave Usuario"
                        ></v-text-field>

                        <v-text-field
                            variant="solo"
                            v-model="usuario.contrasena"
                            label="Contraseña"
                        ></v-text-field>

                        <v-text-field
                            variant="solo"
                            v-model="usuario.conf_contra"
                            label="Confirmar Contraseña"
                        ></v-text-field>

                        <v-text-field
                            variant="solo"
                            v-model="usuario.rol"
                            label="Rol"
                        ></v-text-field>

                        <v-select
                            v-model = "usuario.centro_atencion"
                            :items="['1', '2', '3', '4', '5', '6']"
                            variant="solo" 
                            label="Centro de Atencion" 
                        >
                        </v-select>

                        <v-divider>
                        </v-divider>

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
    export default {
        data() {
            return {
                dialogAgregarUsuarios: false,
                usuario: {
                    nombre: '',
                    clave: '',
                    contrasena: '',
                    conf_contra: '',
                    rol: '',
                    centro_atencion:''
                },  
                headers: [
                { 
                    text: "USUARIO", value: "usuario" 
                },
                { 
                    text: "CENTRO DE ATENCION", value: "centro_atencion"
                },
                { 
                    text: 'ACCIONES', value: 'actions'
                }
                ],
                dialogAgregarCentro: false,
                items:[
                    {
                        id:1,
                        usuario: 'USUARIO',
                        centro_atencion:'',
                    },
                    {
                        id:1,
                        usuario: 'USUARIO',
                        centro_atencion:'',
                    },
                    {
                        id:1,
                        usuario: 'USUARIO',
                        centro_atencion:'',
                    },
                    {
                        id:1,
                        usuario: 'USUARIO',
                        centro_atencion:'',
                    },
                    {
                        id:1,
                        usuario: 'USUARIO',
                        centro_atencion:'',
                    },
                    {
                        id:1,
                        usuario: 'USUARIO',
                        centro_atencion:'',
                    },
                ]
            }
        },
        methods: {
            openModal() {
                console.log('agregar centro')
                this.dialogAgregarUsuarios = true
            },
            async aceptar() {
                try {
                    let response = await axios.post('/api/agregar-usuario', this.usuario)
                    if (response.status === 200) 
                    {
                        console.log("usuario agregado con exito")
                        //successSweetAlert("Usuario Agregado con Exito")
                    } else {
                        console.log("usuario no agregado ")
                    }
                } catch (error) {
                    console.log("error catch")
                }

            },
            editarUsuario() {

            },
            eliminarUsuario() {

            }
        },
    }
</script>