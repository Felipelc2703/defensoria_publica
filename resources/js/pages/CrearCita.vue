<template>
    <div class="container">
    <v-dialog
            v-model="dialogRequisitos"
            max-width="600px"
        >
            <v-card>
                <v-card-title>
                    Sistema de Citas
                </v-card-title>
                <v-divider></v-divider>
                <v-card-text>
                    <div class="m-1">
                        <p><span>Estimado ciudadano:</span></p>
                        <v-divider></v-divider>
                        <p>A continuación se muestran los requisitos que deberá presentar ante el Centro de Atención para realizar el trámite; favor de seleccionar aquéllos con los que cuenta:</p>
                        <v-card class="mb-14">
                            <v-toolbar color="#691C32">
                                <v-toolbar-title class="text-white">Requisitos</v-toolbar-title>
                            </v-toolbar>
                            <v-list lines="three" select-strategy="multiple">
                                <v-list-item value="notifications">
                                    <v-list-item-title>Acta de matrimonio (en su caso de existir).</v-list-item-title>

                                    <!-- <v-list-item-subtitle>
                                    Notify me about updates to apps or games that I downloaded
                                    </v-list-item-subtitle> -->

                                    <template v-slot:prepend="{ isActive }">
                                        <v-list-item-action end>
                                            <v-checkbox-btn :model-value="isActive"></v-checkbox-btn>
                                        </v-list-item-action>
                                    </template>
                                </v-list-item>

                                <v-list-item value="sound">
                                    

                                    <v-list-item-title>Acta de nacimiento de sus hijos.</v-list-item-title>

                                    <!-- <v-list-item-subtitle>
                                    Auto-update apps at any time. Data charges may apply
                                    </v-list-item-subtitle> -->

                                    <template v-slot:prepend="{ isActive }">
                                        <v-list-item-action end>
                                            <v-checkbox-btn :model-value="isActive"></v-checkbox-btn>
                                        </v-list-item-action>
                                    </template>
                                </v-list-item>

                                <v-list-item value="domicilio">

                                    <v-list-item-title>Domicilio de la persona que se va a demandar (calle, número, colonia).</v-list-item-title>

                                    <!-- <v-list-item-subtitle>
                                    Automatically add home screen widgets when downloads complete
                                    </v-list-item-subtitle> -->

                                    <template v-slot:prepend="{ isActive }">
                                        <v-list-item-action end>
                                            <v-checkbox-btn :model-value="isActive"></v-checkbox-btn>
                                        </v-list-item-action>
                                    </template>
                                </v-list-item>

                                <v-list-item value="testigos">

                                    <v-list-item-title>Nombre y domicilio de 2 testigos con copia de credencial de elector, (pueden ser familiares y una vez propuestos no los puede cambiar) traerlos a los testigos hasta que se les indique</v-list-item-title>

                                    <!-- <v-list-item-subtitle>
                                    Automatically add home screen widgets when downloads complete
                                    </v-list-item-subtitle> -->

                                    <template v-slot:prepend="{ isActive }">
                                        <v-list-item-action end>
                                            <v-checkbox-btn :model-value="isActive"></v-checkbox-btn>
                                        </v-list-item-action>
                                    </template>
                                </v-list-item>

                                <v-list-item value="hechos">

                                    <v-list-item-title>Descripción detallada de los hechos (por escritos señalando circunstancia de tiempo, modo y lugar)</v-list-item-title>

                                    <!-- <v-list-item-subtitle>
                                    Automatically add home screen widgets when downloads complete
                                    </v-list-item-subtitle> -->

                                    <template v-slot:prepend="{ isActive }">
                                        <v-list-item-action end>
                                            <v-checkbox-btn :model-value="isActive"></v-checkbox-btn>
                                        </v-list-item-action>
                                    </template>
                                </v-list-item>
                            </v-list>
                        </v-card>
                        <p>Si usted ya cuenta con una cita agendada y desea consultarla, dé click aquí. Todos los trámites son personales. Para verificar las especificaciones de los requisitos dé click <span class="text-red">aquí</span>.</p>
                    </div>
                </v-card-text>
                <v-divider></v-divider>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        variant="flat"
                        color="error"
                        @click="cancelar()"
                    >
                        Cancelar
                    </v-btn>
                    <v-btn
                        variant="flat"
                        color="error"
                        @click="aceptar()"
                    >
                        Aceptar
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        
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
                            <v-col cols="8" class="d-flex justify-start">
                                PASO 1: Seleccione el centro de atención
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
                                </span>
                                <span
                                    v-else
                                    key="1"
                                >
                                    
                                </span>
                                </v-fade-transition>
                            </v-col>
                        </v-row>
                    </v-expansion-panel-title>
                    <v-expansion-panel-text>
                        <v-row no-gutters>
                          <v-col cols="6">
                              <v-select
                              v-model="trip.location"
                              :items="locations"
                              flat
                              variant="solo"
                              ></v-select>
                          </v-col>

                          <v-divider
                              vertical
                              class="mx-4"
                          ></v-divider>

                          <v-col cols="4">
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
                        <v-col cols="8" class="d-flex justify-start">
                            PASO 2: Seleccione la fecha y hora de la cita 
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
                            v-model="trip.fecha"
                            label="date"
                            type="date" 
                            ></v-text-field>
                            
                        </v-col>
                        <v-col cols="2">
                            Hora:
                              <v-select
                              v-model="trip.Hour"
                              :items="Hour"
                              flat
                              variant="solo"
                              ></v-select>
                          </v-col>

                        </v-row>
                    </v-expansion-panel-text>
                    </v-expansion-panel>
                    <v-expansion-panel>
          <v-expansion-panel-title>
            <template v-slot:default="{ expanded }">
              <v-row no-gutters>
                <v-col cols="8" class="d-flex justify-start">
                  PASO 3: Ingrese los datos del solicitante 
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
                    </span>
                  </v-fade-transition>
                </v-col>
              </v-row>
            </template>
          </v-expansion-panel-title>
            <v-expansion-panel-text>
                <v-card >
                    <v-form ref="form">
                Nombre:*
                <v-text-field
                    ref="name"
                    v-model="name"
                    :rules="[rules.required]"
                    label="Nombre"
                ></v-text-field>
                Correo Electrónico:*
                <v-text-field
                    ref="email"
                    v-model="email"
                    :rules="[rules.required, rules.email]"
                    label="E-mail"
                    requerid
                ></v-text-field>
                Teléfono:*
                <v-text-field
                    ref="tel"
                    v-model="tel"
                    :rules="[rules.required, rules.counter]"
                    label="Teléfono"
                ></v-text-field>
                Seleccione sexo:*
                <v-radio-group ref="sexo" v-model="sexo" inline :rules="[rules.required]">
                    <v-radio
                        label="Masculino"
                        value="M"
                    ></v-radio>
                    <v-radio
                        label="Femenino"
                        value="F"
                    ></v-radio>
                </v-radio-group>
            ¿Presenta alguna discapacidad?*
                <v-radio-group ref="disc" v-model="disc" inline :rules="[rules.required]">
                    <v-radio label="Si" v-model="disc" value="si"></v-radio>
                    <v-radio label="No" v-model="disc" value="no"></v-radio>
                </v-radio-group>

            <!--si la respuesta es si-->
                <v-select v-if="disc == 'si'" label="¿Cual?"
                              v-model="trip.disca"
                              :items="disca"
                              flat
                              variant="solo"
                              :rules="[rules.required]"
                              ></v-select>
                      
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="primary"
                        variant="text"
                        @click="Enviar()"
                    >
                        Enviar
                    </v-btn>
                </v-card-actions>
            </v-form> 
            </v-card>
          </v-expansion-panel-text>
        </v-expansion-panel>
                </v-expansion-panels>
            </v-col> 

            <v-divider vertical></v-divider>
            <v-col class="d-flex">
                <div>
                    <v-col>     
                        <div>
                            <p class="font-weight-bold"><span>Centro de Atención:</span></p>
                            <p>{{trip.location}}</p>
                            <p class="font-weight-bold"><span>Día de la cita:</span></p>
                            <p>{{trip.fecha}}</p>
                            <p class="font-weight-bold"><span>Hora de la cita:</span></p>
                            <p>{{trip.Hour}}</p>
                        </div>
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
                name: '',
                email: '',
                tel: '',
                sexo: null,
                disc: null,
                   
                trip: {
                    disca: null,
                    },
                    disca: ['Motriz', 'Auditiva', 'Visual', 'Intelectual', 'Psicosocial'],
                    dialogRequisitos: true,
                
                    trip: {
                    location: null,
                    },
                    locations: ['Seleccione', 'Dirección asuntos civiles, familiares y administrativos(Puebla Capital)', 'DISTRITO JUDICIAL ACATLÁN', 'DISTRITO JUDICIAL ALATRISTE', 'DISTRITO JUDICIAL ATLIXCO', 'DISTRITO JUDICIAL CHALCHICOMULA', 'DISTRITO JUDICIAL CHIAUTLA', 'DISTRITO JUDICIAL CHOLULA'],
                    dialogRequisitos: true,
                    
                    trip: {
                    Hour: null,
                    },
                    Hour: ['8:00', '8:30', '9:00', '9:30', '10:00', '10:30', '11:00', '11:30'],
                    dialogRequisitos: true,
       
                rules: {
                    required: value => !!value || 'Campo requerido',
                    counter: value => value.lenght <=10 || 'Max 10 characters',
                    email: value => {
                        const pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
                        return pattern.test(value) || 'El campo no contiene un correo electrónico valido'
                    },
                },
        }),
        
        methods: {
            cancelar() {
                this.dialogRequisitos = false
                this.$router.push('/')
            },
            aceptar() {
              this.dialogRequisitos = false
            },
        },
        
    }
   

</script>
