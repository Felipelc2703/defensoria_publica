<template>
    <v-container>
            <v-card-title>
                Reporte de graficas
            </v-card-title>
                        <v-row>
                            <v-col cols="3">
                                Fecha Inicio:
                                <v-text-field
                                    v-model="fecha.inicio"
                                    type="date"
                                    variant="underlined"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="3">
                                Fecha Fin:
                                <v-text-field
                                    v-model="fecha.final"
                                    type="date"
                                    variant="underlined"
                                ></v-text-field>
                            </v-col>
                            <v-col>
                                Oficina:
                                <v-select
                                    :items="['California', 'Colorado', 'Florida', 'Georgia', 'Texas', 'Wyoming']"
                                    variant="underlined"
                                ></v-select>
                            </v-col>
                        </v-row>
                        <v-col cols="6">
                            Tramite:
                            <v-select
                                :items="['California', 'Colorado', 'Florida', 'Georgia', 'Texas', 'Wyoming']"
                                variant="underlined"
                            ></v-select>
                        </v-col>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                    <v-btn
                                        variant="flat"
                                        color="error"
                                    >
                                        Generar Grafica
                                    </v-btn>
                            </v-card-actions>
                        
    </v-container>
</template>
<script>
  export default {
    data: () => ({
      fecha: {
        inicio: null,
        final: null,
      },
    }),
  }
</script>