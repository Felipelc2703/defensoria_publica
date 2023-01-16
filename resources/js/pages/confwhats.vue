<template>
    <v-container>
        <v-col cols="7" class="mx-auto">
            <v-card-title>
                Configurar WhatsApp
            </v-card-title>
                Número de teléfono*
                <v-text-field label="" variant="underlined"></v-text-field>
                Hora inicial(hh:mm)*
                <v-text-field label="" variant="underlined"></v-text-field>
                Hora final(hh:mm)*
                <v-text-field label="" variant="underlined"></v-text-field>
                Días disponibles:
                <br>
                <input type="checkbox">Lunes
                <br>
                <input type="checkbox">Martes
                <br>
                <input type="checkbox">Miercoles
                <br>
                <input type="checkbox">Jueves
                <br>
                <input type="checkbox">Viernes
                <br>
                <input type="checkbox">Sabado
                <br>
                <input type="checkbox">Domingo   
            </v-col>

                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        variant="flat"
                        color="error"
                    >
                        Aceptar
                    </v-btn>
                </v-card-actions>
    </v-container>
</template>
