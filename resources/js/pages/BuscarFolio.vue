<template>
    <div class="container">
        <div class="tex-center mt 4">
            <h2 class="text-left">Citas en Linea</h2>
        </div>

        <div>
            <div v-if="folio.clave != ''">
                <h4 class="text-left"> Confirmación de Cita</h4>
                <p class="font-weight-bold">Información Importante</p>

                <p>Estimado(a) <strong> FELIPE LOPEZ CORTES:</strong> su cita para el trámite <strong>NULIDAD (CIVIL)</strong>  ha quedado agendada
                    para el <strong> viernes, 16 de diciembre de 2022</strong>, a las <strong> 08:30:00 </strong> horas.
                    <br>
                    Por lo que le reiteramos debe presentarse en el Centro de atención de DISTRITO JUDICIAL ZACATLÁN
                    ubicado en LIBRAMIENTO CARRETERO TRAMO ZACATLÁN EL TEJOCOTAL No. 300, BARRIO DE
                    MAQUIXTLA, ZACATLÁN, PUEBLA. en la fecha y hora antes mencionadas.
                    <br>
                </p>
                <v-divider
                    color="black"
                    thickness="2"
                >
                </v-divider>
                <p>Le recordamos que el <strong>Folio</strong> de su Cita es:</p>
                <h1 class="text-center">{{folio.clave}}</h1>
                <v-divider
                    color="black"
                    thickness="2"
                >
                </v-divider>

               <div class="d-flex justify-space-around align-center flex-column flex-sm-row fill-height">

                    <v-btn
                    variant="flat"
                    color="error"
                    @click="cancelar()"
                    >
                    Cancelar Cita
                    </v-btn>

                    <v-btn
                    variant="flat"
                    color="error"
                    >
                    Imprimir
                    </v-btn>

                </div>
                <br>
            </div>
            <div v-else>
                <v-alert
                    color = "#F5E79E"
                    variant="flat"
                >
                ATENCIÓN: La búsqueda no devolvió resultados. Intente con otros parámetros.
                </v-alert>
                
            </div>
            <div>
            <p>calendario</p>
                <v-date-picker v-model="picker"></v-date-picker>
            </div>
        </div>

    </div>
    
    
</template>

<script>
export default {
    data() {
        return {
            datos: {
                h: false
            },
            

        }
    },
    computed: {
        folio(){
            return this.$store.getters.getClave
        }
    },
    methods: {
        cancelar() {
            console.log('cancelar')
            // lsuccessSweetAlert('hola')
            const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: true
            })

            swalWithBootstrapButtons.fire({
                title: 'Seguro desea cancelar su cita?',
                // text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Si, Cancelar Cita',
                cancelButtonText: 'No!',
                reverseButtons: true
            }).then((result) => {
            if (result.isConfirmed) {
                swalWithBootstrapButtons.fire(
                'Cita Cancelada!',
                this.$router.push('/')
                )
            } else if (
                /* Read more about handling dismissals below */
                result.dismiss === Swal.DismissReason.cancel
            ) {
                swalWithBootstrapButtons.fire(
                'Cancelled',
                'Your imaginary file is safe :)',
                'error'
                )
            }
            })

        }
    }
}
</script>