<template>
    <html style="font-size: 10px!important;">

        <div class="conteiner-seg">
            <div class="imagen animate__animated animate__slideInLeft">
                <div>
                    <img style="height: 5rem; widht: 10rem;" src="../../../public/images/logo_poder_judical_blanco.png" alt="">
                </div>
            </div>
            <div class="custom-border-login-1"></div>
            <div class="custom-border-login-2"></div>
            <div class="app animate__animated animate__zoomIn">
                <div class="div-titulo-login">
                    <img src="../../../public/images/login-titulo.jpg" alt="">
                </div>
                <form class="form-login" autocomplete="off" @submit.prevent>
                    <br>
                    <h1 class="titulo-bienvenido">Bienvenido</h1>
                    <div class="principal-class mt-8">
                        <div class="div-custom-input-login">
                            <img src="../../../public/icons/user.png" alt="">
                        </div>
                        <div>
                            <input type="text" name="usuario" id="usuario" class="custom-input-login" autocomplete="off" placeholder="Usuario" required autofocus v-model="form.usuario">
                        </div>
                    </div>
                    <div class="principal-class mt-2">
                        <div class="div-custom-input-login">
                            <img src="../../../public/icons/key.png" alt="">
                        </div>
                        <div>
                            <input type="password" name="password" id="password" class="custom-input-login" autocomplete="off" placeholder="Contraseña" required v-model="form.password" @keydown.enter.prevent="login()">
                        </div>
                    </div>
                    <div class="form-group mt-2 text-center" style="margin-left: 5rem; transform: scale(0.9)">
                        <vue-recaptcha 
                            v-show="showRecaptcha"
                            sitekey="6LezEU8kAAAAACsCltCp5tc6FpUU9cr7Gt1JxdfC"
                            @verify="recaptchaVerified"
                            @expire="recaptchaExpired"
                            ref="vueRecaptcha">
                        </vue-recaptcha>
                        <label v-if="mostrarlabel" style="color: white">Porfavor verifica que no seas UN ROBOT</label>
                    </div>
                    <div class="col-md-12 form-group mb-12">
                        <button class="btn-login" type="submit" @click="login()">Entrar</button>
                    </div>
                </form>
            </div>
        </div>
    </html>
    <!-- <div class="conteiner-seg" style="background-color: #353535;">
        <div class="imagen animate__animated animate__slideInLeft"></div>
        <div class="app animate__animated animate__zoomIn">
            <form class="form-login" autocomplete="off" @submit.prevent>    
                <br>
                <h1 class="titulo-bienvenido" style="font-weight: 700;">Bienvenido</h1> 
                <p class="titulo-bienvenido">Citas en línea<br></p>    
                <div class="col-md-12 form-group">
                    <div class="inner-addon left-addon">
                        <i class="fa fa-user"></i>   
                        <input type="text" name="usuario" id="usuario"  class="form-control form-control-lg user" autocomplete="off" placeholder="Usuario" required autofocus v-model="form.usuario">
                    </div>
                </div>
                <div class="col-md-12 form-group">
                    <div class="inner-addon left-addon">
                        <i class="fa fa-lock"></i>                                    
                        <input type="password" name="password" id="password" class="form-control form-control-lg pass" autocomplete="off" placeholder="Contraseña" required v-model="form.password" @keyup.enter="login()">
                    </div>       
                </div>
                <div class="form-group" style="margin-left: 5rem; transform: scale(0.9)">
                    <vue-recaptcha v-show="showRecaptcha" sitekey="6LdY6ygkAAAAAC3dL13YHpsc75y12t31MKfRMnn4"
                            @verify="recaptchaVerified"
                            @expire="recaptchaExpired"
                            ref="vueRecaptcha">
                    </vue-recaptcha> 
                    <label v-if="mostrarlabel" style="color: white">Porfavor verifica que no seas UN ROBOT</label>       
                </div>
                <div class="col-md-12 form-group">
                    <button class="btn" type="submit" @click="login()">Ingresar</button>
                </div>
            </form>
        </div>
    </div> -->
</template>

<script>
    import { defineComponent } from 'vue'
    import { errorSweetAlert } from './../helpers/sweetAlertGlobals'
    import  vueRecaptcha  from 'vue3-recaptcha2';

    export default defineComponent({
        name: 'login',
        components: {
            vueRecaptcha
        },
        data() {
            return {
                mostrarlabel: false,
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
        computed: {
            showRecaptcha() {
                return this.$store.getters.getShowRecaptcha
            },
            cont() {
                return this.$store.getters.getContRecaptcha
            },
        },
        methods: {
            recaptchaVerified(response) {
                this.vueRecaptcha = response
            },
            recaptchaExpired() {
                this.$refs.vueRecaptcha.reset();
            },
            async login() {
                this.loading = true
                if(this.cont < 3){
                    this.$store.dispatch('login', {
                        usuario: this.form.usuario,
                        password: this.form.password
                    }).then(() => {
                        // this.$router.push('/citas-del-dia')
                    }).catch(err => {
                        console.log(err)
                    })
                }else{
                    if(this.vueRecaptcha){
                        this.$store.dispatch('login', {
                            usuario: this.form.usuario,
                            password: this.form.password
                        }).then(() => {
                            // this.$router.push('/citas-del-dia')
                        }).catch(err => {
                            console.log(err)
                        })
                    }else{
                        this.mostrarlabel = true
                    }   
                }
                this.loading = false
            }

        }
    })
</script>