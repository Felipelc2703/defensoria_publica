<template>
    <div>
        <v-dialog
            v-model="dialogRequisitos"
            max-width="800px"
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

        <div class="row justify-content-between">
            <div class="col-sm-9 col-12 border-uno">
                <div class="text-center border-dos py-2">
                    <img class="scale-logo-defensoria" width="200" height="75" src="../../../public/images/logo_defensoria_publica.svg" alt="">
                </div>
                <div class="text-center mt-4 mb-4 ml-10 mr-10">
                    <div class="container">
                        <div class="row justify-content-around">
                            <div class="col-sm-12 col-md-6 text-left">
                                <p class="titulo_tipo_tramite">{{tramiteSeleccionado.nombre}}</p>
                            </div>
                            <div class="col-sm-12 col-md-6 text-right">
                                <v-btn variant="text" prepend-icon="mdi-arrow-left" @click="volverInicio()">Regresar</v-btn>
                            </div>
                        </div>
                        <div class="mt-4">
                            <v-expansion-panels>
                                <v-expansion-panel>
                                    <v-expansion-panel-title v-slot="{ open }">
                                        <v-row no-gutters>
                                            <v-col cols="8" class="d-flex justify-start">
                                                PASO 1: Seleccione el centro de atención
                                            </v-col>
                                            <v-col cols="8" class="text--secondary">
                                                <v-fade-transition leave-absolute>
                                                    <span v-if="open" key="0"></span>
                                                    <span v-else key="1"></span>
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
                                                    variant="underlined"
                                                >
                                                </v-select>
                                            </v-col>

                                            <v-divider vertical class="mx-4"></v-divider>

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
                                            <v-col cols="8" class="text--secondary">
                                                <v-fade-transition leave-absolute>
                                                    <span v-if="open"></span>
                                                    <v-row v-else no-gutters style="width: 100%"></v-row>
                                                </v-fade-transition>
                                            </v-col>
                                        </v-row>
                                    </v-expansion-panel-title>
                                    <v-expansion-panel-text>
                                        <v-row justify="space-around" no-gutters>
                                            <v-col cols="3">
                                                Fecha:
                                                <div id="cal"> 
                                                    <div class="header"> 
                                                        <span class="left button" id="prev"> &lang; </span> 
                                                        <span class="left hook"></span> 
                                                        <span class="month-year" id="label"> June 20&0 </span> 
                                                        <span class="right hook"></span> 
                                                        <span class="right button" id="next"> &rang; </span>
                                            
                                                    </div> 
                                                    <table id="days"> 
                                                        <tr>
                                                            <td>Dom</td> 
                                                            <td>Lun</td> 
                                                            <td>Mar</td> 
                                                            <td>Mier</td> 
                                                            <td>Jue</td> 
                                                            <td>Vie</td> 
                                                            <td>Sab</td>
                                                        </tr>                        
                                                    </table> 
                                                    <div id="cal-frame"> 
                                                        <table class="curr"> 
                                                            <tbody> 
                                                                <tr><td class="nil"></td><td class="nil"></td><td>1</td><td>2</td><td>3</td><td>4</td><td>5</td></tr> 
                                                                <tr><td>6</td><td>7</td><td>8</td><td>9</td><td>10</td><td class="today">11</td><td>12</td></tr> 
                                                                <tr><td>13</td><td>14</td><td>15</td><td>16</td><td>17</td><td>18</td><td>19</td></tr> 
                                                                <tr><td>20</td><td>21</td><td>22</td><td>23</td><td>24</td><td>25</td><td>26</td></tr> 
                                                                <tr><td>27</td><td>28</td><td>29</td><td>30</td><td class="nil"></td><td class="nil"></td><td class="nil"></td></tr> 
                                                            </tbody> 
                                                        </table>
                                                    </div> 
                                                </div>
                                            </v-col>
                                            <v-col cols="2">
                                                Hora:
                                                <v-select
                                                v-model="trip.Hour"
                                                :items="Hour"
                                                flat
                                                variant="underlined"
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
                                        <v-form ref="form">
                                            Nombre:*
                                            <v-text-field
                                                ref="name"
                                                v-model="name"
                                                :rules="[rules.required]"
                                                variant="underlined"
                                            ></v-text-field>
                                            Correo Electrónico:*
                                            <v-text-field
                                                ref="email"
                                                v-model="email"
                                                :rules="[rules.required, rules.email]"
                                                variant="underlined"
                                            ></v-text-field>
                                            Teléfono:*
                                            <v-text-field
                                                counter="10"
                                                maxlength="10"
                                                ref="tel"
                                                v-model="tel"
                                                :rules="[rules.required]"
                                                variant="underlined"
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
                                                variant="underlined"
                                                :rules="[rules.required]"
                                            ></v-select>
                                            <v-card-actions>
                                                <v-spacer></v-spacer>
                                                <v-btn
                                                    color="primary"
                                                    variant="text"
                                                    @click="login"
                                                >
                                                    Enviar
                                                </v-btn>
                                            </v-card-actions>
                                        </v-form> 
                                    </v-expansion-panel-text>
                                </v-expansion-panel>
                            </v-expansion-panels>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3 col-12">
                <div class="text-center py-2 espacio-blanco"></div>
                <div class="text-center mt-4 mb-4 ml-4 mr-4">
                    <div>
                        <fieldset class="text-left">
                            <legend><h2 class="titulo-resumen-cita">Resumen de Cita:</h2></legend>
                        </fieldset>
                        <div>
                            <div class="row">
                                <div class="col-md-12 text-left">
                                    <span class="texto-estatico-resumen-cita">Centro de Atención:</span>
                                    <br>
                                    <span class="texto-dinamico-resumen-cita"></span>
                                    <br>
                                    <br>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-left">
                                    <span class="texto-estatico-resumen-cita">Día de la Cita:</span>
                                    <br>
                                    <span class="texto-dinamico-resumen-cita"></span>
                                    <br>
                                    <br>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-left">
                                    <span class="texto-estatico-resumen-cita">Hora de la Cita:</span>
                                    <br>
                                    <span class="texto-dinamico-resumen-cita"></span>
                                    <br>
                                    <br>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
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
                              variant="underlined"
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
                            <span v-if="open"></span>
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
                            Fecha:
                            <!-- <v-text-field
                            v-model="trip.fecha"
                            type="date"
                            variant="underlined"
                            ></v-text-field> -->
                            <!-- <div class="calendar">
                                <div class="calendar__info">
                                    <div class="calendar__prev" id="prev-month">&#9664;</div>
                                    <div class="calendar__month" id="month"></div>
                                    <div class="calendar__year" id="year"></div>
                                    <div class="calendar__next" id="next-month">&#9654;</div>
                                </div>

                                <div class="calendar__week">
                                    <div class="calendar__day calendar__item">Lunes</div>
                                    <div class="calendar__day calendar__item">Martes</div>
                                    <div class="calendar__day calendar__item">Miercoles</div>
                                    <div class="calendar__day calendar__item">Jueves</div>
                                    <div class="calendar__day calendar__item">Viernes</div>
                                    <div class="calendar__day calendar__item">Sabado</div>
                                    <div class="calendar__day calendar__item">Domingo</div>
                                </div>

                                <div class="calendar__dates" id="dates"></div>
                            </div> -->
                            <div id="cal"> 
                                <div class="header"> 
                                    <span class="left button" id="prev"> &lang; </span> 
                                    <span class="left hook"></span> 
                                    <span class="month-year" id="label"> June 20&0 </span> 
                                    <span class="right hook"></span> 
                                    <span class="right button" id="next"> &rang; </span>
                        
                                </div> 
                                <table id="days"> 
                                    <tr>
                                        <td>Dom</td> 
                                        <td>Lun</td> 
                                        <td>Mar</td> 
                                        <td>Mier</td> 
                                        <td>Jue</td> 
                                        <td>Vie</td> 
                                        <td>Sab</td>
                                    </tr>                        
                                </table> 
                                <div id="cal-frame"> 
                                    <table class="curr"> 
                                        <tbody> 
                                            <tr><td class="nil"></td><td class="nil"></td><td>1</td><td>2</td><td>3</td><td>4</td><td>5</td></tr> 
                                            <tr><td>6</td><td>7</td><td>8</td><td>9</td><td>10</td><td class="today">11</td><td>12</td></tr> 
                                            <tr><td>13</td><td>14</td><td>15</td><td>16</td><td>17</td><td>18</td><td>19</td></tr> 
                                            <tr><td>20</td><td>21</td><td>22</td><td>23</td><td>24</td><td>25</td><td>26</td></tr> 
                                            <tr><td>27</td><td>28</td><td>29</td><td>30</td><td class="nil"></td><td class="nil"></td><td class="nil"></td></tr> 
                                        </tbody> 
                                    </table>
                                </div> 
                            </div>
                        </v-col>
                        <v-col cols="2">
                            Hora:
                              <v-select
                              v-model="trip.Hour"
                              :items="Hour"
                              flat
                              variant="underlined"
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
                    <v-form ref="form">
                Nombre:*
                <v-text-field
                    ref="name"
                    v-model="name"
                    :rules="[rules.required]"
                    variant="underlined"
                ></v-text-field>
                Correo Electrónico:*
                <v-text-field
                    ref="email"
                    v-model="email"
                    :rules="[rules.required, rules.email]"
                    variant="underlined"
                ></v-text-field>
                Teléfono:*
                <v-text-field
                    counter="10"
                    maxlength="10"
                    ref="tel"
                    v-model="tel"
                    :rules="[rules.required]"
                    variant="underlined"
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
                              variant="underlined"
                              :rules="[rules.required]"
                              ></v-select>
                      
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="primary"
                        variant="text"
                        @click="login"
                    >
                        Enviar
                    </v-btn>
                </v-card-actions>
            </v-form> 
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

<style scoped>
    body { 
	    background: #e0e0e0; 
	} 
 
	#cal { 
	    -moz-box-shadow:0px 3px 3px rgba(0, 0, 0, 0.25); 
	    -webkit-box-shadow:0px 3px 3px rgba(0, 0, 0, 0.25); 
	    margin:50px auto; 
	    font: 13px/1.5 "Helvetica Neue", Helvatica, Arial, san-serif; 
	    display:table; 
	}
    #cal .header { 
	    cursor:default; 
	    background: #cd310d; 
	    background: -moz-linear-gradient(top, #b32b0c, #cd310d); 
	    background: -webkit-gradient(linear, left top, left bottom, from(#b32b0c), to(#cd310d)); 
	    height: 34px; 
	    position: relative; 
	    color:#fff; 
	    -webkit-border-top-left-radius: 5px; 
	    -webkit-border-top-right-radius: 5px; 
	    -moz-border-radius-topleft: 5px; 
	    -moz-border-radius-topright: 5px; 
	    border-top-left-radius: 5px; 
	    border-top-right-radius: 5px; 
	    font-weight:bold; 
	    text-shadow:0px -1px 0 #87260C; 
	    text-transform: uppercase; 
	} 
	#cal .header span { 
	    display:inline-block; 
	    line-height:34px; 
	}
    /* #cal .header .hook { 
	    width: 9px; 
	    height: 28px; 
	    position: absolute; 
	    bottom:60%; 
	    border-radius:10px; 
	    -moz-border-radius:10px; 
	    -webkit-border-radius:10px; 
	    background:#ececec; 
	    background: -moz-linear-gradient(right top, #fff, #827e7d); 
	    background: -webkit-gradient(linear, right top, right bottom, from(#fff), to(#827e7d)); 
	    box-shadow:0px -1px 2px rgba(0, 0, 0, 0.65 ); 
	    -moz-box-shadow:0px -1px 2px rgba(0, 0, 0, 0.65 ); 
	    -webkit-box-shadow:0px -1px 2px rgba(0, 0, 0, 0.65 ); 
	}  */
	/* .right.hook { 
	    right:15%; 
	} 
	.left.hook { 
	    left: 15%; 
	} */
    #cal .header .button { 
	    width:24px; 
	    text-align:center; 
	    position:absolute; 
	} 
	#cal .header .left.button { 
	    left:0; 
	    -webkit-border-top-left-radius: 5px; 
	    -moz-border-radius-topleft: 5px; 
	    border-top-left-radius: 5px; 
	    border-right:1px solid #ae2a0c; 
	} 
	#cal .header .right.button { 
	    right:0; 
	    top:0; 
	    border-left:1px solid #ae2a0c; 
	    -webkit-border-top-right-radius: 5px; 
	    -moz-border-radius-topright: 5px; 
	    border-top-right-radius: 5px; 
	} 
	#cal .header .button:hover { 
	    background: -moz-linear-gradient(top, #d94215, #bb330f); 
	    background: -webkit-gradient(linear, left top, left bottom, from(#d94215), to(#bb330f)); 
	}
    #cal .header .month-year { 
	    letter-spacing: 1px; 
	    width: 100%; 
	    text-align: center; 
	}
    #cal table { 
	    background:#fff; 
	    border-collapse:collapse; 
	} 
	#cal td { 
	    color:#2b2b2b; 
	    width:30px; 
	    height:30px; 
	    line-height:30px; 
	    text-align:center; 
	    border:1px solid #e6e6e6; 
	    cursor:default; 
	} 
	#cal #days td { 
	    height:26px; 
	    line-height: 26px; 
	    text-transform:uppercase; 
	    font-size:90%; 
	    color:#9e9e9e; 
	} 
	#cal #days td:not(:last-child) { 
	    border-right:1px solid #fff; 
	}
    #cal #cal-frame td.today { 
	    background:#ededed; 
	    color:#8c8c8c; 
	    box-shadow:1px 1px 0px #fff inset; 
	    -moz-box-shadow:1px 1px 0px #fff inset; 
	    -webkit-box-shadow:1px 1px 0px #fff inset; 
	} 
	#cal #cal-frame td:not(.nil):hover { 
	    color:#fff; 
	    text-shadow: #6C1A07 0px -1px; 
	    background:#CD310D; 
	    background: -moz-linear-gradient(top, #b32b0c, #cd310d); 
	    background: -webkit-gradient(linear, left top, left bottom, from(#b32b0c), to(#cd310d)); 
	    -moz-box-shadow:0px 0px 0px; 
	    -webkit-box-shadow:0px 0px 0px; 
	}
    #cal #cal-frame td span { 
	    font-size:80%; 
	    position:relative; 
	} 
	#cal #cal-frame td span:first-child { 
	    bottom:5px; 
	} 
	#cal #cal-frame td span:last-child { 
	    top:5px; 
	}
    #cal #cal-frame table.curr { 
	    float:left;      
	} 
	#cal #cal-frame table.temp { 
	    position:absolute; 
	}

    .border-uno {
        border-style: none solid none none;
        border-color: #adadad;
        border-width: 2px;
        padding: 0!important;
    }

    .border-dos {
        border-style: none none solid none;
        border-color: #adadad;
        border-width: 2px;
    }

    .scale-logo-defensoria {
        transform: scale(1.8);
    }

    .titulo_tipo_tramite {
        font-size: 20px;
        font-weight: bold;
        font-family: 'Lato', sans-serif;
    }

    .espacio-blanco {
        height: 93px;
    }

    .titulo-resumen-cita {
        font-size: 40;
        font-weight: bold;
    }

    .texto-estatico-resumen-cita {
        font-weight: bold;
    }

    .texto-dinamico-resumen-cita {
        color: #827e7d;
        font-weight: bold;
    }
</style>

<script>
    //import { create } from 'domain'
    import { defineComponent } from 'vue'
    import { errorSweetAlert } from './../helpers/sweetAlertGlobals'

    export default defineComponent({
        name: 'crear-cita',
        data() {
            return {
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
                locations: ['Dirección asuntos civiles, familiares y administrativos(Puebla Capital)', 'DISTRITO JUDICIAL ACATLÁN', 'DISTRITO JUDICIAL ALATRISTE', 'DISTRITO JUDICIAL ATLIXCO', 'DISTRITO JUDICIAL CHALCHICOMULA', 'DISTRITO JUDICIAL CHIAUTLA', 'DISTRITO JUDICIAL CHOLULA'],
                dialogRequisitos: true,    
                trip: {
                    Hour: null,
                },
                Hour: ['8:00', '8:30', '9:00', '9:30', '10:00', '10:30', '11:00', '11:30'],
                dialogRequisitos: true,
                rules: {
                    required: value => !!value || 'Campo requerido',
                    email: value => {
                        const pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
                        return pattern.test(value) || 'El campo no contiene un correo electrónico valido'
                    },
                },
            }
        },
        created() {
            console.log("tramite: ", this.tramiteSeleccionado)
        },
        computed: {
            tramiteSeleccionado() {
                return this.$store.getters.getTramiteSeleccionado
            }
        },
        methods: {
            cancelar() {
                this.dialogRequisitos = false
                this.$router.push('/')
            },
            aceptar() {
              this.dialogRequisitos = false
            },
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
                            errorSweetAlert('Ocurrió un error')
                        }
                    } catch (error) {
                        errorSweetAlert('Ocurrió un error')
                    }
                }
                this.loading = false
            }
        },
    })

    var CALENDAR = function () { 
	    var wrap, label,  
	            months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"]; 
 
	    function init(newWrap) { 
            wrap     = $(newWrap || "#cal"); 
            label    = wrap.find("#label"); 
            wrap.find("#prev").bind("click.calendar", function () { switchMonth(false); }); 
            wrap.find("#next").bind("click.calendar", function () { switchMonth(true);  }); 
            label.bind("click", function () { switchMonth(null, new Date().getMonth(), new Date().getFullYear()); });        
            label.click();
 
	    } 
 
	    function switchMonth(next, month, year) { 
            var curr = label.text().trim().split(" "), calendar, tempYear =  parseInt(curr[1], 10); 
	month = month || ((next) ? ( (curr[0] === "December") ? 0 : months.indexOf(curr[0]) + 1 ) : ( (curr[0] === "January") ? 11 : months.indexOf(curr[0]) - 1 )); 
    year = year || ((next && month === 0) ? tempYear + 1 : (!next && month === 11)) ? tempYear - 1 : tempYear;
            calendar = createCal(year, month);
} 
 
	    function createCal(year, month) { 
            var day = 1, i, j , haveDays = true,
            startDay = new Date(year, month, day).getDay(),
            daysInMonth = [31,(((year%4===0)&&(year%100!==0))||(year%400===0)) ? 29 : 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31 ],
            calendar =[];
            if (createCal.cache[year]){
                if (createCal.cache[year][month]){
                    return createCal.cache[year][month];
                }
            }else {
                create.Cal.cache[year]={};
            }
            i = 0;
            while(haveDays){
                calendar[i] = [];
                for (j = 0; j < 7; j++) {
                    if (i === 0){
                        if (j === startDay){
                            calendar[i][j] = day++;
                            startDay++;
                        }
                    }else if ( day <=daysInMonth[month]){
                        calendar[i][j] = day++;
                    }else {
                        calendar[i][j] = "";
                        haveDays = false;
                    }if (day > daysInMonth[month]){
                        haveDays = false;
                    }
                }
                i++;
            }
            if (calendar[5]){
                for (i = 0; i < calendar[5].length; i++){
                    if (calendar[5][i] !== ""){
                        calendar[4][i] = "<span>" + calendar[4][i] + "</span><span>"+ calendar[5][i] + "</span>";
                    }
                }
                calendar = calendar.slice(0,5);
            }
for (i = 0; i< calendar.length; i++){
    calendar[i] = "<tr><td>" + calendar.join("</td><td>")+ "</td><td>"
}
calendar = $("<table>" + calendar.join("") + "</table").addClass("curr");
    $("")
            console.dir(calendar);
 
	    } 
	    createCal.cache = {}; 
	    return { 
	        init : init, 
	        switchMonth : switchMonth, 
	        createCal   : createCal 
	    }; 
	};
</script>
