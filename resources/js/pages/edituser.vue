<template>
    <v-container>
        <v-col cols="7" class="mx-auto">
        <v-card-title>
            Editar usuario
        </v-card-title>
                Nombre Usuario:
                <v-text-field variant="underlined"></v-text-field>
                Clave Usuario:
                <v-text-field variant="underlined"></v-text-field>
                <v-text-field
                    variant="underlined"
                    v-model="password"
                    :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
                    :type="show1 ? 'text' : 'password'"
                    name="input-10-1"
                    label="Mostrar contraseña"
                    @click:append="show1 = !show1"
                ></v-text-field>
                <br>
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
<script>
  export default {
    data () {
      return {
        show1: false,
        password: 'Password',
        rules: {
          required: value => !!value || 'Required.',
          min: v => v.length >= 8 || 'Min 8 characters',
          emailMatch: () => (`The email and password you entered don't match`),
        },
      }
    },
  }
</script>