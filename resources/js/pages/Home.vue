<template>
    <div class="container">
        <div class="text-center mt-4">
            <h2 class="text-left">Defensoría Pública</h2>
            <h3 class="text-left">Citas en Linea</h3>
        </div>
        <div class="text-center mt-4 mb-4">
            <div class="row justify-content-around" v-if="showFirstOptions">
                <div class="col-sm-12 col-md-6 col-lg-3 mt-4">
                    <v-card variant="tonal" height="120" @click="mostrarTipoCitas(1)">
                        <div class="m-2">
                            <p><span>Asuntos Civiles y Familiares</span></p>
                            <v-icon icon="mdi-account-child"></v-icon>
                        </div>
                    </v-card>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-3 mt-4">
                    <v-card variant="tonal" height="120" @click="mostrarTipoCitas(2)">
                        <div class="m-2">
                            <p><span>Asuntos Administrativos</span></p>
                            <v-icon icon="mdi-folder"></v-icon>
                        </div>
                    </v-card>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-3 mt-4">
                    <v-card variant="tonal" height="120" @click="mostrarTipoCitas(3)">
                        <div class="m-2">
                            <p><span>Asuntos Laborales</span></p>
                            <v-icon icon="mdi-account-hard-hat"></v-icon>
                        </div>
                    </v-card>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-3 mt-4">
                    <v-card variant="tonal" height="120" @click="mostrarTipoCitas(4)">
                        <div class="m-2">
                            <p><span>Ejecución de Sentencias</span></p>
                            <v-icon icon="mdi-account-tie"></v-icon>
                        </div>
                    </v-card>
                </div>
            </div>
            <div v-if="showSecondOptions">
                <div class="text-left">
                    <v-btn variant="text" prepend-icon="mdi-arrow-left" @click="volverFirstOptions">Regresar</v-btn>
                </div>
                <div class="mt-4">
                    <v-expansion-panels>
                        <template v-for="(tipo_cita, index) in tipos_citas" :key="index">
                            <v-expansion-panel>
                                <v-expansion-panel-title>
                                    <v-row no-gutters>
                                        <h6 class="font-weight-bold text-uppercase">
                                            <span class="text-red-custom">{{tipo_cita.nombre}}</span>
                                        </h6>
                                    </v-row>
                                </v-expansion-panel-title>
                                <v-expansion-panel-text>
                                    <v-row no-gutters class="text-left">
                                        {{tipo_cita.descripcion}}
                                    </v-row>
                                    <v-card-actions>
                                        <v-spacer></v-spacer>
                                        <v-btn
                                            variant="flat"
                                            color="error"
                                            @click="agendar(tipo_cita)"
                                        >
                                            Agendar
                                        </v-btn>
                                    </v-card-actions>
                                </v-expansion-panel-text>
                            </v-expansion-panel>
                        </template>
                    </v-expansion-panels>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { defineComponent } from "@vue/runtime-core"

    export default defineComponent({
        name: 'home',
        data() {
            return {
                showFirstOptions: true,
                showSecondOptions: false,
                tipos_citas: [],
                tipos_citas_1: [
                    {
                        id: 1,
                        nombre: 'Alimentos',
                        descripcion: 'Es el procedimiento por el cual se obliga al deudor alimentario a proporcionarlos a quien por derecho le corresponde recibirlos comida, vestido, habitación y asistencia médica en caso de enfermedad.'
                    },
                    {
                        id: 2,
                        nombre: 'Guarda y Custodia',
                        descripcion: 'La guarda y custodia, se refiere a quién de los progenitores va a ser responsable de cuidar a los menores tras la separación.'
                    },
                    {
                        id: 3,
                        nombre: 'Divorcio unilateral o bilateral',
                        descripcion: 'El divorcio es la disolución del vínculo matrimonial, dejando a los ex cónyuges en aptitud de contraer otro. Puede solicitarlo uno de los cónyuges o ambos.'
                    },
                    {
                        id: 4,
                        nombre: 'Visita y convivencia',
                        descripcion: 'Niñas, niños y adolescentes cuyas familias estén separadas, tendrán derecho a convivir o mantener relaciones personales y contacto directo con sus familiares de modo regular, el derecho del menor a convivir con ambos progenitores, en fechas y horarios determinados por la ley.'
                    },
                    {
                        id: 5,
                        nombre: 'Recuperación de menor',
                        descripcion: 'Procedimiento por el cual una de las partes recupera la posesión, la guarda y custodia de un menor.'
                    },
                    {
                        id: 6,
                        nombre: 'Paternidad',
                        descripcion: 'Relación jurídica que se establece entre las personas a quienes el derecho coloca en la condición de padre y madre y las que sitúa en la de los hijos, de manera que aquella realidad biológica es recogida por el ordenamiento distribuyendo derechos y obligaciones entre ellos.'
                    },
                    {
                        id: 7,
                        nombre: 'Interdicción',
                        descripcion: 'Procedimiento por el cual un Juez Familiar nombra un representante Legal a una persona mayor de edad que tenga algún padecimiento mental de tal manera que no pueda tomar decisiones o ejercer sus derechos por sí mismo.'
                    },
                    {
                        id: 8,
                        nombre: 'Ofrecimiento de pago de pensión alimenticia',
                        descripcion: 'Procedimiento judicial por medio del cual se exhibe ante el juzgado el cumplimiento de la obligación alimentaria, cuando el acreedor alimentario se niega a recibirlo.'
                    },
                    {
                        id: 9,
                        nombre: 'Liquidación de la sociedad conyugal',
                        descripcion: 'La Liquidación de la Sociedad Conyugal es aquel acto por el cual los ex cónyuges estando bajo dicho régimen inician el trámite de dividir los bienes comunes que adquirieron dentro del matrimonio.'
                    },
                    {
                        id: 10,
                        nombre: 'Juicio de rectificación de actas de nacimiento',
                        descripcion: 'La rectificación de acta del Registro Civil en Puebla, es la enmienda que se solicita cuando un acta del Registro Civil presenta algún error que afecta de manera directa la personalidad jurídica del titular del documento; variando algún nombre u otro dato esencial que afecte el estado civil, la filiación, la nacionalidad, el sexo o la identidad de la persona.'
                    },
                    {
                        id: 11,
                        nombre: 'Información testimonial ad-perpetuam de dependencia económica.',
                        descripcion: 'Es un Acto de jurisdicción voluntaria que tiene por objeto llevar a cabo una averiguación o prueba destinada a justificar algún hecho o acreditar un derecho, para que en lo sucesivo conste inequívocamente, respecto de la dependencia económica.'
                    },
                    {
                        id: 12,
                        nombre: 'Información testimonial ad-perpetuam concubinato',
                        descripcion: 'La Información ad-perpetuam es un Acto de jurisdicción voluntaria que tiene por objeto llevar a cabo una averiguación o prueba destinada a justificar algún hecho o acreditar un derecho para que en lo sucesivo conste inequívocamente.'
                    },
                    {
                        id: 13,
                        nombre: 'Información testimonial ad-perpetuam variación de nombre',
                        descripcion: 'La Información ad-perpetuam es un Acto de jurisdicción voluntaria que tiene por objeto llevar a cabo una averiguación o prueba destinada a justificar algún hecho o acreditar un derecho para que en lo sucesivo conste inequívocamente.'
                    },
                    {
                        id: 14,
                        nombre: 'Perdida de la patria potestad',
                        descripcion: 'Es el procedimiento que conoce el juez familiar, dentro del cual determina privar de los derechos que un padre o madre ejercen sobre sus hijos, en virtud de su falta de interés en su crianza o alguna otra circunstancia que la ley prevea.'
                    },
                    {
                        id: 15,
                        nombre: 'Separación del domicilio familiar',
                        descripcion: 'La separación es una figura jurídica mediante la cual el que intente demandar, denunciar o querellarse contra su cónyuge, concubino o pariente, podrá solicitar al Juez de lo familiar la suspensión de la vida en común entre estos.'
                    },
                    {
                        id: 16,
                        nombre: 'Suseción intestamentaria y testamentaria',
                        descripcion: 'Sucesión hereditaria que se difiere según lo dispuesto en la ley a falta de testamento. El orden de heredar es: descendientes, ascendientes, cónyuge viuda, colaterales y, en último lugar, el Estado.'
                    },
                    {
                        id: 17,
                        nombre: 'Cancelación y/o disminución de pensión alimenticia',
                        descripcion: 'Procedimiento judicial por medio del cual se demanda la cancelación de la pensión alimenticia decretada por un juez familiar, por haber cesado la obligación o por convenio.'
                    },
                    {
                        id: 18,
                        nombre: 'Filiación',
                        descripcion: 'La filiación es el vínculo jurídico que existe entre dos personas, en la que una desciende de la otra, lo que puede darse como consecuencia de hechos biológicos y/ o de actos jurídicos.'
                    },
                    {
                        id: 19,
                        nombre: 'Adopción',
                        descripcion: 'Se entiende como adopción o filiación adoptiva el acto jurídico mediante el cual se crea un vínculo de parentesco entre una o dos personas, de tal forma que establece entre ellas una relación de paternidad o de maternidad.'
                    },
                    {
                        id: 20,
                        nombre: 'Nulidad de acta de registro civil',
                        descripcion: 'Es un juicio que puede realizar el usuario para corregir la duplicidad que se haya hecho por el registro de su nacimiento.'
                    },
                    {
                        id: 21,
                        nombre: 'Petición de herencia',
                        descripcion: 'Es la que compete al heredero para reclamar de otra u otras personas el reconocimiento de su calidad de heredero y la restitución de los bienes hereditarios.'
                    },
                    {
                        id: 22,
                        nombre: 'Tutela',
                        descripcion: 'Autoridad conferida a un adulto para cuidar de una persona y de sus bienes porque esta no está capacitada para hacerlo por sí misma.'
                    },
                    {
                        id: 23,
                        nombre: 'Autorización para salir del país',
                        descripcion: 'Es el documento mediante el cual los menores de edad pueden viajar al extranjero, solos o en compañía de un tercero mayor de edad.'
                    },
                    {
                        id: 24,
                        nombre: 'Ofrecimiento de pago seguido de consignación (civil)',
                        descripcion: 'Es el acto jurídico por el que el deudor manifiesta al acreedor que va a cumplir la obligación y le requiere para que coopere en la medida indispensable para que la prestación pueda realizarse en favor del acreedor. Este ofrecimiento puede consistir en la exhibición de la cantidad o del objeto que se debe.'
                    },
                    {
                        id: 25,
                        nombre: 'Diligencias de apeo y deslinde (civil)',
                        descripcion: 'Tiene lugar cuando los límites que separan un predio de otro u otros no se han fijado, o bien, cuando habiéndose fijado, existe un motivo fundado para creer que estos no son exactos.'
                    },
                    {
                        id: 26,
                        nombre: 'Interpelación judicial (civil)',
                        descripcion: 'Requerimiento para el pago de una deuda o para el cumplimiento de una obligación, que es dirigido por el acreedor o su representante al deudor suyo.'
                    },
                    {
                        id: 26,
                        nombre: 'Información testimonial (civil)',
                        descripcion: 'Tiene como fin justificar algún hecho o acreditar algún derecho.'
                    },
                    {
                        id: 27,
                        nombre: 'Medios preparatorios a juicios (civil)',
                        descripcion: 'Son aquellos procedimientos, anteriores al juicio que tienden a proporcionar a quien los promueve elementos de conocimiento o de prueba que le permitirán promover un juicio.'
                    },
                    {
                        id: 28,
                        nombre: 'Oral sumarisimo (civil)',
                        descripcion: 'Es aquel procedimiento oral en el cual participan las partes y se realiza con pocas formalidades para que conlleve poco tiempo hasta su conclusión.'
                    },
                    {
                        id: 29,
                        nombre: 'Ejecutivo civil',
                        descripcion: 'Tiene como finalidad ejecutar de forma coactiva, fácil y rápidamente un documento trae aparejada ejecución, es decir, que obliga a alguien a dar algo o a hacer alguna cosa dentro de un plazo determinado, y en caso de no hacerlo se le podrá obligar por parte de un juzgador, siempre y cuando la Ley prevea que se pueda tramitar en esta vía.'
                    },
                    {
                        id: 30,
                        nombre: 'Acción confesoria y negatoria (civil)',
                        descripcion: 'Acción Negatoria (para obtener la declaración de libertad, o de la reducción de gravámenes de bien inmueble y la demolición de obras o señales que importen gravámenes); la Acción Confesoria (sobre el titular del derecho real inmueble y al poseedor del predio dominante que esté interesado en la existencia de la servidumbre.'
                    },
                    {
                        id: 30,
                        nombre: 'División de cosa común (civil)',
                        descripcion: 'Es una acción real que tiene como fin que la propiedad perteneciente a varias personas, se divida.'
                    },
                    {
                        id: 31,
                        nombre: 'Reivindicatorio (civil)',
                        descripcion: 'Acción judicial otorgada a todo propietario para hacer que se reconozca su título como propietario de una cosa.'
                    },
                    {
                        id: 32,
                        nombre: 'Posesión (civil)',
                        descripcion: 'Esta acción compete al adquirente con justo título y buena fe; tiene por objeto que se le restituya en la posesión definitiva de una cosa mueble o inmueble.'
                    },
                    {
                        id: 33,
                        nombre: 'Usucapión (civil)',
                        descripcion: 'Modo de adquisición de la propiedad u otros derechos reales por la posesión durante el tiempo determinado por la ley.'
                    },
                    {
                        id: 34,
                        nombre: 'Otorgamiento de escritura pública (civil)',
                        descripcion: 'Es el procedimiento legal mediante el cual un propietario que adquirió un inmueble, no cuenta con el título legal respectivo, y el vendedor, no ha firmado o participado en la formalización de la escritura que justifique la operación y por ende la propiedad del nuevo comprador.'
                    },
                    {
                        id: 35,
                        nombre: 'Responsabilidad civil',
                        descripcion: 'Regula la obligación de resarcir o reparar los daños y perjuicios causados por incumplimiento de obligaciones asumidas (derivadas de un contrato), por virtud de un hecho ilícito o por riesgo creado (extracontractual).'
                    },
                    {
                        id: 36,
                        nombre: 'Cumplimiento de contrato (arrendamiento, comodato, prenda, etc) Civil',
                        descripcion: 'Consiste en la acción que ejercita alguna de las partes para que se cumplan con alguna o alguna de las cláusulas contenidas en un contrato que fue celebrado previamente entre las dos partes.'
                    },
                    {
                        id: 37,
                        nombre: 'Rescisión de contrato (arrendamiento, comodato, prenda, depósito, etc) Civil',
                        descripcion: 'Consiste en dejar sin efecto un contrato o una obligación; es decir, escindir es la acción que busca impedir las consecuencias de un acto y cuyo objetivo es poner término de lo convenido.'
                    },
                    {
                        id: 38,
                        nombre: 'Terminación de contrato (arrendamiento, comodato, prenda, depósito, etc) Civil',
                        descripcion: 'Acción que busca dar por terminada la vigencia de un contrato.'
                    },
                    {
                        id: 39,
                        nombre: 'Acción hipotecaria (civil)',
                        descripcion: 'Acción que se ejercita para constituir, ampliar, registrar, dividir y cancelar una hipoteca.'
                    },
                    {
                        id: 40,
                        nombre: 'Ejecutivo mercantil (civil)',
                        descripcion: 'Tiene como finalidad ejecutar de forma coactiva, fácil y rápidamente un documento que por sus características trae aparejada ejecución, los títulos de crédito, las pólizas de seguro, la decisión de los peritos designados en los seguros para fijar el importe del siniestro, las facturas, cuentas corrientes y cualesquiera otros contratos de comercio entre otros.'
                    },
                    {
                        id: 41,
                        nombre: 'Desocupación (civil)',
                        descripcion: 'Procede por el incumplimiento o terminación del contrato de arrendamiento.'
                    },
                    {
                        id: 42,
                        nombre: 'Nulidad (civil)',
                        descripcion: 'Es aquella destinada a obtener de la declaración de ineficacia de un acto, negocio jurídico o contrato, por carecer de algún elemento esencial (inexistencia), o por ser contrario a la ley (nulidad plena) o por adolecer de algún vicio o defecto que le hace susceptible de producir su ineficacia (nulidad relativa o anulabilidad).'
                    },
                    {
                        id: 43,
                        nombre: 'Amparo indirecto en materia civil, familiar, administrativa y penal (presuntos responsables)',
                        descripcion: 'Otorgar el servicio gratuito de asesoría y patrocinio legal a las personas que sean objeto de actos de molestia por parte de autoridades municipales, estatales y jurisdiccionales del fuero común, (siempre y cuando no exista un conflicto de interés como lo maneja nuestro Código de Ética).'
                    },
                ],
                tipos_citas_2: [

                ],
                tipos_citas_3: [
                    {
                        id: 44,
                        nombre: 'Pago de finiquito',
                        descripcion: 'Le corresponde al trabajador cuando se da por terminada la relación laboral por decisión propia o mutuo consentimiento entre patrón y trabajador.'
                    },
                    {
                        id: 45,
                        nombre: 'Pago de indemnización constitucional por despido injustificado',
                        descripcion: 'Le corresponde al trabajador cuando el patrón rescinde la relación laboral sin que medie causa justificada, es decir que el trabajador no haya acaecido en alguno de los supuestos señalados por el artículo 47 de la Ley Federal del Trabajo.'
                    },
                    {
                        id: 46,
                        nombre: 'Reinstalación',
                        descripcion: 'Destinado a trabajadores particulares y de gobierno (estatal y/o municipal), que pretendan continuar con la relación laboral y busquen reincorporarse a su fuente de trabajo en las condiciones en que venía desempeñándose.'
                    },
                    {
                        id: 47,
                        nombre: 'Conciliación',
                        descripcion: 'La conciliación es el punto de partida ante la existencia de un conflicto laboral. Implica proponer a las partes en conflicto soluciones amistosas mediante el envío de citatorios hasta en dos ocasiones a la parte patronal, para que comparezcan a citas administrativas en las que con la intervención de un defensor público del área laboral, se trata de alcanzar un arreglo conciliatorio que ponga fin a la controversia laboral.'
                    },
                    {
                        id: 48,
                        nombre: 'Tramitación de un paraprocesal',
                        descripcion: 'Dirigido a los trabajadores que requieren la intervención de la autoridad laboral, sin que esté promovido jurisdiccionalmente conflicto alguno entre partes determinadas, señalando el trabajador únicamente la intervención que se requiere, como puede ser poner a disposición material y/o herramienta de trabajo.'
                    },
                    {
                        id: 49,
                        nombre: 'Tramitación de un procedimiento especial',
                        descripcion: 'Los posibles beneficiarios de los trabajadores ausentes o fallecidos, pueden solicitar se les designen como BENEFICIARIO por la autoridad laboral, con la finalidad de recibir los beneficios a los que el trabajador tenía derecho, con independencia de la causa del deceso o ausencia. Así como los conflictos que tengan por objeto el cobro de prestaciones que no excedan del importe de tres meses de salarios. Su finalidad es acreditar el vínculo filial con el asegurado o pensionado fallecido.'
                    },
                ],
                tipos_citas_4: [
                    {
                        id: 50,
                        nombre: 'Servicios para dar cumplimiento dentro de carpetas de ejecución',
                        descripcion: 'Persona sentenciada , la cual dará cumplimiento a los montos que fue condenado(sentencias que no rebasen 5 años).'
                    },
                    {
                        id: 51,
                        nombre: 'Escrito de nombramiento de defensor público',
                        descripcion: 'Solicitud para que el sentenciado sea representado por un Defensor Público.'
                    },
                    {
                        id: 52,
                        nombre: 'Solicitud de libertad anticipada',
                        descripcion: 'Sentenciado que haya compurgado el 70% de la sentencia, que tenga buen comportamiento durante su reclusión, cumplido el plan de actividades, ser primodelincuente y no ser un riesgo para la víctima, testigo y sociedad, haber cubierto la reparación del daño y la multa.'
                    },
                    {
                        id: 53,
                        nombre: 'Solicitud de libertad condicionada',
                        descripcion: 'Sentenciado que haya compurgado el 50% de la sentencia, que tenga buen comportamiento durante su reclusión, cumplido el plan de actividades, ser primodelincuente y no ser un riesgo para la víctima, testigo y sociedad, haber cubierto la reparación del daño y la multa.'
                    },
                    {
                        id: 54,
                        nombre: 'Cancelación del registro de antecedentes penales',
                        descripcion: 'De sentenciados que compurgaron o conmutaron la sentencia(dieron cumplimiento total).'
                    },
                    {
                        id: 55,
                        nombre: 'Rehabilitación de derechos electorales',
                        descripcion: 'De sentenciados que dieron cumplimiento con la sentencia.'
                    },
                    {
                        id: 56,
                        nombre: 'Cancelación de firma',
                        descripcion: 'Sentenciados que se encontraban en libertad bajo caución y ya dieron cumplimiento con la sentencia.'
                    },
                    {
                        id: 57,
                        nombre: 'Sustitutivo de pena',
                        descripcion: 'Sentenciado que por la edad avanzada, estado de salud, senilidad, sea innecesaria su estancia en prisión.'
                    },
                    {
                        id: 58,
                        nombre: 'Solicitud de copias',
                        descripcion: 'Sentenciados que solicitan copias certificadas de proceso o carpetas.'
                    },
                    {
                        id: 59,
                        nombre: 'Asesoría simple',
                        descripcion: 'Seguimiento de algún trámite o información en general.'
                    },
                ]
            }
        },
        methods: {
            mostrarTipoCitas(asunto) {
                switch (asunto) {
                    case 1:
                        this.tipos_citas = this.tipos_citas_1
                        break
                    case 2:
                        this.tipos_citas = this.tipos_citas_2
                        break
                    case 3:
                        this.tipos_citas = this.tipos_citas_3
                        break
                    case 4:
                        this.tipos_citas = this.tipos_citas_4
                        break
                }
                this.tipos_citas
                this.showFirstOptions = false
                this.showSecondOptions = true
            },
            volverFirstOptions() {
                this.showSecondOptions = false
                this.showFirstOptions = true
            },
            agendar(tipo_cita) {
                console.log(tipo_cita)
                this.$router.push('/crear-cita')
            }
        }
    })
</script>

<style scoped>
    .text-red-custom {
        color: #691C32;
    }
</style>