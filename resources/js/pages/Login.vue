<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-6 mt-4">

                <h2 class="text-center">Login</h2>

                <v-card class="mx-auto px-6 py-8 my-8" max-width="344">
                    <v-form ref="form">
                        <v-text-field
                            label="Usuario"
                            v-model="form.usuario"
                            :rules="usuarioRules"
                        ></v-text-field>
                        <v-text-field
                            label="Contraseña"
                            v-model="form.password"
                            :rules="passwordRules"
                            :append-icon="show ? 'mdi-eye' : 'mdi-eye-off'"
                            :type="show ? 'text' : 'password'"
                            @click:append="show = !show"
                            @keyup.enter="login"
                        ></v-text-field>
                        <br>
                        <v-btn
                            color="success"
                            variant="elevated"
                            :loading="loading"
                            block
                            @click="login"
                        >
                            Entrar
                        </v-btn>
                    </v-form>
                </v-card>
            </div>
        </div>
    </div>
</template>

<script>
    import { defineComponent } from 'vue'
    import { errorSweetAlert } from './../helpers/sweetAlertGlobals'

    export default defineComponent({
        name: 'login',
        data() {
            return {
                form: {
                    usuario: '',
                    password: '',
                },
                valid: true,
                show: false,
                loading: false,
                usuarioRules: [
                    v => !!v || 'El nombre de usuario es requerido'
                ],
                passwordRules: [
                    v => !!v || 'La contraseña es requerida'
                ],
            }
        },
        methods: {
            async login() {
                this.loading = true
                const { valid } = await this.$refs.form.validate()
                if (valid) {
                    try {
                        let response = await axios.post('/api/login', this.form)
                        if (response.status === 200) {
                            if (response.data.status === "ok") {
                                this.$store.dispatch('setToken', response.data.data.token)
                                this.$router.push({name: 'Dashboard'})
                            } else {
                                errorSweetAlert(response.data.message)
                            }
                        } else {
                            errorSweetAlert('Ocurrió un error al iniciar sesión')
                        }
                    } catch (error) {
                        errorSweetAlert('Ocurrió un error al iniciar sesión')
                    }
                }
                this.loading = false
            }
        }
    })
</script>