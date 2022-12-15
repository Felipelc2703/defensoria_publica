<template>
    <div class="container">
        <div class="text-center mt-4">
            <h2 class="text-left">Tipo de Juicio</h2>
        </div>
<v-card class="mt-4 mb-4"> 
    <v-row class="pa-4" justify="space-between">
        <v-col cols="8" sm="8">
            <v-expansion-panels>
                <v-expansion-panel>
                <v-expansion-panel-title v-slot="{ open }">
                    <v-row no-gutters>
                    <v-col cols="4" class="d-flex justify-start">
                        PASO 1 Seleccione el centro de atención
                    </v-col>
                    <v-col
                        cols="8"
                        class="text--secondary"
                    >
                        <v-fade-transition leave-absolute>
                        <span
                            v-if="open"
                            key="0"
                        >
                            Select trip destination
                        </span>
                        <span
                            v-else
                            key="1"
                        >
                            {{ trip.location }}
                        </span>
                        </v-fade-transition>
                    </v-col>
                    </v-row>
                </v-expansion-panel-title>
                <v-expansion-panel-text>
                    <v-row no-gutters>
                    <v-spacer></v-spacer>
                    <v-col cols="5">
                        <v-select
                        v-model="trip.location"
                        :items="locations"
                        chips
                        flat
                        variant="solo"
                        ></v-select>
                    </v-col>

                    <v-divider
                        vertical
                        class="mx-4"
                    ></v-divider>

                    <v-col cols="3">
                    Si requiere conocer la ubicación de cada uno de los lugares donde puede realizar el trámite, 
                        <br>
                        <a href="#"> de click aqui</a>
                    </v-col>
                    </v-row>
                </v-expansion-panel-text>
                </v-expansion-panel>
                <v-expansion-panel>
                <v-expansion-panel-title v-slot="{ open }">
                    <v-row no-gutters>
                    <v-col cols="4" class="d-flex justify-start">
                        PASO 2 Seleccione la fecha y hora de la cita 
                    </v-col>
                    <v-col
                        cols="8"
                        class="text--secondary"
                    >
                        <v-fade-transition leave-absolute>
                        <span v-if="open">When do you want to travel?</span>
                        <v-row
                            v-else
                            no-gutters
                            style="width: 100%"
                        >
                        </v-row>
                        </v-fade-transition>
                    </v-col>
                    </v-row>
                </v-expansion-panel-title>
                <v-expansion-panel-text>
                    <v-row
                    justify="space-around"
                    no-gutters
                    >
                    <v-col cols="3">
                        <v-text-field
                        v-model="trip.start"
                        label="Start date"
                        type="date"
                        ></v-text-field>
                    </v-col>

                    </v-row>
                </v-expansion-panel-text>
                </v-expansion-panel>
                <v-expansion-panel>
      <v-expansion-panel-title>
        <template v-slot:default="{ expanded }">
          <v-row no-gutters>
            <v-col cols="4" class="d-flex justify-start">
              PASO 3 Ingrese los datos del solicitante 
            </v-col>
            <v-col
              cols="8"
              class="text-grey"
            >
              <v-fade-transition leave-absolute>
                <span
                  v-if="expanded"
                  key="0"
                >
                </span>
                <span
                  v-else
                  key="1"
                >
                  {{ trip.name }}
                </span>
              </v-fade-transition>
            </v-col>
          </v-row>
        </template>
      </v-expansion-panel-title>
      <v-expansion-panel-text>
        Nombre:*
        <v-text-field
          v-model="trip.name"
          hide-details
          placeholder="Nombre"
        ></v-text-field>
        Correo Electrónico:*
        <v-text-field
          v-model="trip.email"
          hide-details
          placeholder="Correo Electrónico"
        ></v-text-field>
        Teléfono:*
        <v-text-field
          v-model="trip.tel"
          hide-details
          placeholder="Teléfono"
        ></v-text-field>
      </v-expansion-panel-text>
    </v-expansion-panel>
            </v-expansion-panels>
        </v-col> 

        <v-divider vertical></v-divider>
        
        <v-col class="d-flex">
            <div class="tittle grey--text text-red-lighten-1 font-weight-light">
                <v-col cols="3">                        
                    </v-col>           
            </div>
        </v-col>
    </v-row>
</v-card>
  
</div>
</template>

<script>
  export default {
    data: () => ({
      date: null,
      trip: {
        name: '',
        location: null,
        start: null,
        end: null,
      },
      locations: ['Seleccione', 'Dirección asuntos civiles, familiares y administrativos(Puebla Capital)', 'DISTRITO JUDICIAL ACATLÁN', 'DISTRITO JUDICIAL ALATRISTE', 'DISTRITO JUDICIAL ATLIXCO', 'DISTRITO JUDICIAL CHALCHICOMULA', 'DISTRITO JUDICIAL CHIAUTLA', 'DISTRITO JUDICIAL CHOLULA'],
    }),
  }
</script>