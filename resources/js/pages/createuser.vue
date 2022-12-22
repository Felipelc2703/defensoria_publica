<template>
    <v-container>
        <v-col cols="7" class="mx-auto">
            <v-card-title>
                Crear Usuario
            </v-card-title>
                    Nombre usuario:
                    <v-text-field variant="underlined"></v-text-field>
                    Clave usuario:
                    <v-text-field variant="underlined"></v-text-field>
                    Contraseña:
                    <v-text-field variant="underlined"></v-text-field>
                    Confirmar contraseña:
                    <v-text-field variant="underlined"></v-text-field>
                Rol:
                <v-select
                    :items="['California', 'Colorado', 'Florida', 'Georgia', 'Texas', 'Wyoming']"
                    variant="underlined"  
                ></v-select>
                Centro de Atención:
                <v-select
                    :items="['California', 'Colorado', 'Florida', 'Georgia', 'Texas', 'Wyoming']"
                    variant="underlined"  
                ></v-select>
            </v-col>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        variant="flat"
                        color="amber darken-1"
                    >
                        Cancelar
                    </v-btn>
                    <v-btn
                        variant="flat"
                        color="error"
                    >
                        Aceptar
                    </v-btn>
                </v-card-actions>
    </v-container>
</template>
<!-- <script>
    export default {
        data: () => ({
               
        }),
        
        methods: {
            comparar(){
                if(this.pass == this.con.pass){
                    console.log("Contraseña valida")
                }else{
                    console.log("La contraseña no coincide")
                }
            }
        },
        
    }
   

</script> -->