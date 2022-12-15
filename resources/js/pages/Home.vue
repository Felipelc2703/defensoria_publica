<template>
    <div class="container">
        Home page
        <v-card class="mt-10">
            <v-tabs
                v-model="tab"
                bg-color="primary"
            >
                <v-tab value="one">Item One</v-tab>
                <v-tab value="two">Item Two</v-tab>
                <v-tab value="three">Item Three</v-tab>
            </v-tabs>
        
            <v-card-text>
                <v-window v-model="tab">
                <v-window-item value="one">
                    One
                </v-window-item>
        
                <v-window-item value="two">
                    Two
                </v-window-item>
        
                <v-window-item value="three">
                    Three
                </v-window-item>
                </v-window>
            </v-card-text>
        </v-card>
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