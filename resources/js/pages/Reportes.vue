<template>
    <v-container>
        <v-card-title>
            Reportes
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
                    <v-row>
                        <v-col>
                        Trámite:
                        <v-select
                            :items="['California', 'Colorado', 'Florida', 'Georgia', 'Texas', 'Wyoming']"
                            variant="underlined"  
                        ></v-select>
                    </v-col>
                    <v-col>
                        Estatus:
                        <v-select
                            :items="['California', 'Colorado', 'Florida', 'Georgia', 'Texas', 'Wyoming']"
                            variant="underlined"  
                        ></v-select>
                    </v-col>
                    </v-row>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn
                                variant="flat"
                                color="error"
                            >
                                Generar Reporte
                            </v-btn>
                        </v-card-actions>
                    
    </v-container>
</template>
<script>
  export default {
    data: () => ({
        tramite: null,
        oficina: null,
        estatus: null,
      fecha: {
        incio: null,
        final: null,
      },
    }),
  }
</script>