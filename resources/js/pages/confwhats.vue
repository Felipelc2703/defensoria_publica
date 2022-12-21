<template>
    <v-container>
        <v-card>
            <v-card-title>
                Configurar WhatsApp
            </v-card-title>
                Número de teléfono*
                <v-text-field label="" variant="outlined"></v-text-field>
                Hora inicial(hh:mm)*
                <v-text-field label="" variant="outlined"></v-text-field>
                Hora final(hh:mm)*
                <v-text-field label="" variant="outlined"></v-text-field>
                Días disponibles:
                <v-checkbox label="Lunes"></v-checkbox>
                <v-checkbox label="Martes"></v-checkbox>
                <v-checkbox label="Miércoles"></v-checkbox>
                <v-checkbox label="Jueves"></v-checkbox>
                <v-checkbox label="Viernes"></v-checkbox>
                <v-checkbox label="Sábado"></v-checkbox>
                <v-checkbox label="Domingo"></v-checkbox>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        variant="flat"
                        color="error"
                    >
                        Aceptar
                    </v-btn>
                </v-card-actions>
        </v-card>         
    </v-container>
</template>
