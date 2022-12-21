<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TramiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tramites')->insert([
            'nombre' => 'Alimentos',
            'descripcion' => 'Es el procedimiento por el cual se obliga al deudor alimentario a proporcionarlos a quien por derecho le corresponde recibirlos comida, vestido, habitación y asistencia médica en caso de enfermedad.',
            'tipo_tramite_id' => 1,
        ]);
        DB::table('tramites')->insert([
            'nombre' => 'Guarda y custodia',
            'descripcion' => 'La guarda y custodia, se refiere a quién de los progenitores va a ser responsable de cuidar a los menores tras la separación.',
            'tipo_tramite_id' => 1,
        ]);
        DB::table('tramites')->insert([
            'nombre' => 'Divorcio unilateral o bilateral',
            'descripcion' => 'El divorcio es la disolución del vínculo matrimonial, dejando a los ex cónyuges en aptitud de contraer otro. Puede solicitarlo uno de los cónyuges o ambos.',
            'tipo_tramite_id' => 1,
        ]);
        DB::table('tramites')->insert([
            'nombre' => 'Visita y convivencia',
            'descripcion' => 'Niñas, niños y adolescentes cuyas familias estén separadas, tendrán derecho a convivir o mantener relaciones personales y contacto directo con sus familiares de modo regular, el derecho del menor a convivir con ambos progenitores, en fechas y horarios determinados por la ley.',
            'tipo_tramite_id' => 1,
        ]);
        DB::table('tramites')->insert([
            'nombre' => 'Recuperación de menor',
            'descripcion' => 'Procedimiento por el cual una de las partes recupera la posesión, la guarda y custodia de un menor.',
            'tipo_tramite_id' => 1,
        ]);
        DB::table('tramites')->insert([
            'nombre' => 'Paternidad',
            'descripcion' => 'Relación jurídica que se establece entre las personas a quienes el derecho coloca en la condición de padre y madre y las que sitúa en la de los hijos, de manera que aquella realidad biológica es recogida por el ordenamiento distribuyendo derechos y obligaciones entre ellos.',
            'tipo_tramite_id' => 1,
        ]);
        DB::table('tramites')->insert([
            'nombre' => 'Interdicción',
            'descripcion' => 'Procedimiento por el cual un Juez Familiar nombra un representante Legal a una persona mayor de edad que tenga algún padecimiento mental de tal manera que no pueda tomar decisiones o ejercer sus derechos por sí mismo.',
            'tipo_tramite_id' => 1,
        ]);
        DB::table('tramites')->insert([
            'nombre' => 'Ofrecimiento de pago de pensión alimenticia',
            'descripcion' => 'Procedimiento judicial por medio del cual se exhibe ante el juzgado el cumplimiento de la obligación alimentaria, cuando el acreedor alimentario se niega a recibirlo.',
            'tipo_tramite_id' => 1,
        ]);
        DB::table('tramites')->insert([
            'nombre' => 'Liquidación de la sociedad conyugal',
            'descripcion' => 'La Liquidación de la Sociedad Conyugal es aquel acto por el cual los ex cónyuges estando bajo dicho régimen inician el trámite de dividir los bienes comunes que adquirieron dentro del matrimonio.',
            'tipo_tramite_id' => 1,
        ]);
        DB::table('tramites')->insert([
            'nombre' => 'Juicio de rectificación de actas de nacimiento',
            'descripcion' => 'La rectificación de acta del Registro Civil en Puebla, es la enmienda que se solicita cuando un acta del Registro Civil presenta algún error que afecta de manera directa la personalidad jurídica del titular del documento; variando algún nombre u otro dato esencial que afecte el estado civil, la filiación, la nacionalidad, el sexo o la identidad de la persona',
            'tipo_tramite_id' => 1,
        ]);
        DB::table('tramites')->insert([
            'nombre' => 'Información testimonial AD-PERPETUAM de dependencia económica.',
            'descripcion' => 'La rectificación de acta del Registro Civil en Puebla, es la enmienda que se solicita cuando un acta del Registro Civil presenta algún error que afecta de manera directa la personalidad jurídica del titular del documento; variando algún nombre u otro dato esencial que afecte el estado civil, la filiación, la nacionalidad, el sexo o la identidad de la persona',
            'tipo_tramite_id' => 1,
        ]);
        DB::table('tramites')->insert([
            'nombre' => 'Información testimonial AD-PERPETUAM concubinato.',
            'descripcion' => 'La Información ad-perpetuam es un Acto de jurisdicción voluntaria que tiene por objeto llevar a cabo una averiguación o prueba destinada a justificar algún hecho o acreditar un derecho para que en lo sucesivo conste inequívocamente.',
            'tipo_tramite_id' => 1,
        ]);
        DB::table('tramites')->insert([
            'nombre' => 'Información testimonial AD-PERPETUAM variación de nombre.',
            'descripcion' => 'La Información ad-perpetuam es un Acto de jurisdicción voluntaria que tiene por objeto llevar a cabo una averiguación o prueba destinada a justificar algún hecho o acreditar un derecho para que en lo sucesivo conste inequívocamente.',
            'tipo_tramite_id' => 1,
        ]);
        DB::table('tramites')->insert([
            'nombre' => 'Perdida de la patria potestad.',
            'descripcion' => 'Es el procedimiento que conoce el juez familiar, dentro del cual determina privar de los derechos que un padre o madre ejercen sobre sus hijos, en virtud de su falta de interés en su crianza o alguna otra circunstancia que la ley prevea.',
            'tipo_tramite_id' => 1,
        ]);
        DB::table('tramites')->insert([
            'nombre' => 'Separación del domicilio familiar.',
            'descripcion' => 'La separación es una figura jurídica mediante la cual el que intente demandar, denunciar o querellarse contra su cónyuge, concubino o pariente, podrá solicitar al Juez de lo familiar la suspensión de la vida en común entre estos.',
            'tipo_tramite_id' => 1,
        ]);
        DB::table('tramites')->insert([
            'nombre' => 'Sucesión intestamentaria y testamentaria.',
            'descripcion' => 'Sucesión hereditaria que se difiere según lo dispuesto en la ley a falta de testamento. El orden de heredar es: descendientes, ascendientes, cónyuge viuda, colaterales y, en último lugar, el Estado.',
            'tipo_tramite_id' => 1,
        ]);
        DB::table('tramites')->insert([
            'nombre' => 'Cancelación y/o disminución de pensión alimenticia.',
            'descripcion' => 'Procedimiento judicial por medio del cual se demanda la cancelación de la pensión alimenticia decretada por un juez familiar, por haber cesado la obligación o por convenio.',
            'tipo_tramite_id' => 1,
        ]);
        DB::table('tramites')->insert([
            'nombre' => 'Filiación.',
            'descripcion' => 'La filiación es el vínculo jurídico que existe entre dos personas, en la que una desciende de la otra, lo que puede darse como consecuencia de hechos biológicos y/ o de actos jurídicos.',
            'tipo_tramite_id' => 1,
        ]);
        DB::table('tramites')->insert([
            'nombre' => 'Adopción.',
            'descripcion' => 'Se entiende como adopción o filiación adoptiva el acto jurídico mediante el cual se crea un vínculo de parentesco entre una o dos personas, de tal forma que establece entre ellas una relación de paternidad o de maternidad.',
            'tipo_tramite_id' => 1,
        ]);
        DB::table('tramites')->insert([
            'nombre' => 'Nulidad de acta de registro civil.',
            'descripcion' => 'Es un juicio que puede realizar el usuario para corregir la duplicidad que se haya hecho por el registro de su nacimiento.',
            'tipo_tramite_id' => 1,
        ]);
        DB::table('tramites')->insert([
            'nombre' => 'Petición de herencia.',
            'descripcion' => 'Es la que compete al heredero para reclamar de otra u otras personas el reconocimiento de su calidad de heredero y la restitución de los bienes hereditarios.',
            'tipo_tramite_id' => 1,
        ]);
        DB::table('tramites')->insert([
            'nombre' => 'Tutela.',
            'descripcion' => 'Autoridad conferida a un adulto para cuidar de una persona y de sus bienes porque esta no está capacitada para hacerlo por sí misma.',
            'tipo_tramite_id' => 1,
        ]);
        DB::table('tramites')->insert([
            'nombre' => 'Autorización para salir del país.',
            'descripcion' => 'Es el documento mediante el cual los menores de edad pueden viajar al extranjero, solos o en compañía de un tercero mayor de edad.',
            'tipo_tramite_id' => 1,
        ]);
        DB::table('tramites')->insert([
            'nombre' => 'Ofrecimiento de pago seguido de consignación (civil).',
            'descripcion' => 'Es el acto jurídico por el que el deudor manifiesta al acreedor que va a cumplir la obligación y le requiere para que coopere en la medida indispensable para que la prestación pueda realizarse en favor del acreedor. Este ofrecimiento puede consistir en la exhibición de la cantidad o del objeto que se debe.',
            'tipo_tramite_id' => 1,
        ]);
        DB::table('tramites')->insert([
            'nombre' => 'Diligencias de apeo y deslinde (civil).',
            'descripcion' => 'Tiene lugar cuando los límites que separan un predio de otro u otros no se han fijado, o bien, cuando habiéndose fijado, existe un motivo fundado para creer que estos no son exactos.',
            'tipo_tramite_id' => 1,
        ]);
        DB::table('tramites')->insert([
            'nombre' => 'Interpelación judicial (civil).',
            'descripcion' => 'Requerimiento para el pago de una deuda o para el cumplimiento de una obligación, que es dirigido por el acreedor o su representante al deudor suyo.',
            'tipo_tramite_id' => 1,
        ]);
        DB::table('tramites')->insert([
            'nombre' => 'Información testimonial (civil).',
            'descripcion' => 'Tiene como fin justificar algún hecho o acreditar algún derecho.',
            'tipo_tramite_id' => 1,
        ]);
        DB::table('tramites')->insert([
            'nombre' => 'Medios preparatorios a juicios (civil).',
            'descripcion' => 'Son aquellos procedimientos, anteriores al juicio que tienden a proporcionar a quien los promueve elementos de conocimiento o de prueba que le permitirán promover un juicio.',
            'tipo_tramite_id' => 1,
        ]);
        DB::table('tramites')->insert([
            'nombre' => 'Oral sumarisimo (civil).',
            'descripcion' => 'Es aquel procedimiento oral en el cual participan las partes y se realiza con pocas formalidades para que conlleve poco tiempo hasta su conclusión.',
            'tipo_tramite_id' => 1,
        ]);
        DB::table('tramites')->insert([
            'nombre' => 'Ejecutivo civil.',
            'descripcion' => 'Tiene como finalidad ejecutar de forma coactiva, fácil y rápidamente un documento trae aparejada ejecución, es decir, que obliga a alguien a dar algo o a hacer alguna cosa dentro de un plazo determinado, y en caso de no hacerlo se le podrá obligar por parte de un juzgador, siempre y cuando la Ley prevea que se pueda tramitar en esta vía.',
            'tipo_tramite_id' => 1,
        ]);
        DB::table('tramites')->insert([
            'nombre' => 'Acción confesoria y negatoria (civil).',
            'descripcion' => 'Acción Negatoria (para obtener la declaración de libertad, o de la reducción de gravámenes de bien inmueble y la demolición de obras o señales que importen gravámenes); la Acción Confesoria (sobre el titular del derecho real inmueble y al poseedor del predio dominante que esté interesado en la existencia de la servidumbre.',
            'tipo_tramite_id' => 1,
        ]);
        DB::table('tramites')->insert([
            'nombre' => 'División de cosa común (civil).',
            'descripcion' => 'Es una acción real que tiene como fin que la propiedad perteneciente a varias personas, se divida.',
            'tipo_tramite_id' => 1,
        ]);
        DB::table('tramites')->insert([
            'nombre' => 'Reivindicatorio (civil).',
            'descripcion' => 'Acción judicial otorgada a todo propietario para hacer que se reconozca su título como propietario de una cosa.',
            'tipo_tramite_id' => 1,
        ]);
        DB::table('tramites')->insert([
            'nombre' => 'Posesión (civil).',
            'descripcion' => 'Esta acción compete al adquirente con justo título y buena fe; tiene por objeto que se le restituya en la posesión definitiva de una cosa mueble o inmueble.',
            'tipo_tramite_id' => 1,
        ]);
        DB::table('tramites')->insert([
            'nombre' => 'Usucapión (civil).',
            'descripcion' => 'Modo de adquisición de la propiedad u otros derechos reales por la posesión durante el tiempo determinado por la ley.',
            'tipo_tramite_id' => 1,
        ]);
        DB::table('tramites')->insert([
            'nombre' => 'Otorgamiendo de escritura pública (civil).',
            'descripcion' => 'Es el procedimiento legal mediante el cual un propietario que adquirió un inmueble, no cuenta con el título legal respectivo, y el vendedor, no ha firmado o participado en la formalización de la escritura que justifique la operación y por ende la propiedad del nuevo comprador.',
            'tipo_tramite_id' => 1,
        ]);
        DB::table('tramites')->insert([
            'nombre' => 'Responsabilidad civil.',
            'descripcion' => 'Regula la obligación de resarcir o reparar los daños y perjuicios causados por incumplimiento de obligaciones asumidas (derivadas de un contrato), por virtud de un hecho ilícito o por riesgo creado (extracontractual).',
            'tipo_tramite_id' => 1,
        ]);
        DB::table('tramites')->insert([
            'nombre' => 'Cumplimiento de contrato (arrendamiento, comodato, prenda, etc) civil.',
            'descripcion' => 'Consiste en la acción que ejercita alguna de las partes para que se cumplan con alguna o alguna de las cláusulas contenidas en un contrato que fue celebrado previamente entre las dos partes.',
            'tipo_tramite_id' => 1,
        ]);
        DB::table('tramites')->insert([
            'nombre' => 'Rescisión de contrato (arrendamiento, comodato, prenda, depósito etc) civil.',
            'descripcion' => 'Consiste en dejar sin efecto un contrato o una obligación; es decir, escindir es la acción que busca impedir las consecuencias de un acto y cuyo objetivo es poner término de lo convenido.',
            'tipo_tramite_id' => 1,
        ]);
        DB::table('tramites')->insert([
            'nombre' => 'Terminación de contrato (arrendamiento, comodato, prenda, etc) civil.',
            'descripcion' => 'Acción que busca dar por terminada la vigencia de un contrato.',
            'tipo_tramite_id' => 1,
        ]);
        DB::table('tramites')->insert([
            'nombre' => 'Acción hipotecaria (civil).',
            'descripcion' => 'Acción que se ejercita para constituir, ampliar, registrar, dividir y cancelar una hipoteca.',
            'tipo_tramite_id' => 1,
        ]);
        DB::table('tramites')->insert([
            'nombre' => 'Ejecutivo mercantil (civil).',
            'descripcion' => 'Tiene como finalidad ejecutar de forma coactiva, fácil y rápidamente un documento que por sus características trae aparejada ejecución, los títulos de crédito, las pólizas de seguro, la decisión de los peritos designados en los seguros para fijar el importe del siniestro, las facturas, cuentas corrientes y cualesquiera otros contratos de comercio entre otros.',
            'tipo_tramite_id' => 1,
        ]);
        DB::table('tramites')->insert([
            'nombre' => 'Desocupación (civil).',
            'descripcion' => 'Procede por el incumplimiento o terminación del contrato de arrendamiento.',
            'tipo_tramite_id' => 1,
        ]);
        DB::table('tramites')->insert([
            'nombre' => 'Nulidad (civil).',
            'descripcion' => 'Es aquella destinada a obtener de la declaración de ineficacia de un acto, negocio jurídico o contrato, por carecer de algún elemento esencial (inexistencia), o por ser contrario a la ley (nulidad plena) o por adolecer de algún vicio o defecto que le hace susceptible de producir su ineficacia (nulidad relativa o anulabilidad).',
            'tipo_tramite_id' => 1,
        ]);
        DB::table('tramites')->insert([
            'nombre' => 'Amparo indirecto en materia civil, familiar, administrativa y penal (presuntos responsables).',
            'descripcion' => 'Otorgar el servicio gratuito de asesoría y patrocinio legal a las personas que sean objeto de actos de molestia por parte de autoridades municipales, estatales y jurisdiccionales del fuero común, (siempre y cuando no exista un conflicto de interés como lo maneja nuestro Código de Ética).',
            'tipo_tramite_id' => 1,
        ]);
        DB::table('tramites')->insert([
            'nombre' => 'Pago de finiquito.',
            'descripcion' => 'Le corresponde al trabajador cuando se da por terminada la relación laboral por decisión propia o mutuo consentimiento entre patrón y trabajador.',
            'tipo_tramite_id' => 3,
        ]);
        DB::table('tramites')->insert([
            'nombre' => 'Pago de indemnización constitucional por despido injustificado.',
            'descripcion' => 'Le corresponde al trabajador cuando el patrón rescinde la relación laboral sin que medie causa justificada, es decir que el trabajador no haya acaecido en alguno de los supuestos señalados por el artículo 47 de la Ley Federal del Trabajo.',
            'tipo_tramite_id' => 3,
        ]);
        DB::table('tramites')->insert([
            'nombre' => 'Reinstalación.',
            'descripcion' => 'Destinado a trabajadores particulares y de gobierno (estatal y/o municipal), que pretendan continuar con la relación laboral y busquen reincorporarse a su fuente de trabajo en las condiciones en que venía desempeñándose.',
            'tipo_tramite_id' => 3,
        ]);
        DB::table('tramites')->insert([
            'nombre' => 'Conciliación.',
            'descripcion' => 'La conciliación es el punto de partida ante la existencia de un conflicto laboral. Implica proponer a las partes en conflicto soluciones amistosas mediante el envío de citatorios hasta en dos ocasiones a la parte patronal, para que comparezcan a citas administrativas en las que con la intervención de un defensor público del área laboral, se trata de alcanzar un arreglo conciliatorio que ponga fin a la controversia laboral.',
            'tipo_tramite_id' => 3,
        ]);
        DB::table('tramites')->insert([
            'nombre' => 'Tramitación de un paraprocesal.',
            'descripcion' => 'Dirigido a los trabajadores que requieren la intervención de la autoridad laboral, sin que esté promovido jurisdiccionalmente conflicto alguno entre partes determinadas, señalando el trabajador únicamente la intervención que se requiere, como puede ser poner a disposición material y/o herramienta de trabajo.',
            'tipo_tramite_id' => 3,
        ]);
        DB::table('tramites')->insert([
            'nombre' => 'Tramitación de un procedimiento especial.',
            'descripcion' => 'Los posibles beneficiarios de los trabajadores ausentes o fallecidos, pueden solicitar se les designen como BENEFICIARIO por la autoridad laboral, con la finalidad de recibir los beneficios a los que el trabajador tenía derecho, con independencia de la causa del deceso o ausencia. Así como los conflictos que tengan por objeto el cobro de prestaciones que no excedan del importe de tres meses de salarios. Su finalidad es acreditar el vínculo filial con el asegurado o pensionado fallecido.',
            'tipo_tramite_id' => 3,
        ]);
        DB::table('tramites')->insert([
            'nombre' => 'Servicios para dar cumplimiento dentro de carpetas de ejecución.',
            'descripcion' => 'Persona sentenciada , la cual dará cumplimiento a los montos que fue condenado(sentencias que no rebasen 5 años).',
            'tipo_tramite_id' => 4,
        ]);
        DB::table('tramites')->insert([
            'nombre' => 'Escrito de nombramiento de defensor público.',
            'descripcion' => 'Solicitud para que el sentenciado sea representado por un Defensor Público.',
            'tipo_tramite_id' => 4,
        ]);
        DB::table('tramites')->insert([
            'nombre' => 'Solicitud de libertad anticipada.',
            'descripcion' => 'Sentenciado que haya compurgado el 70% de la sentencia, que tenga buen comportamiento durante su reclusión, cumplido el plan de actividades, ser primodelincuente y no ser un riesgo para la víctima, testigo y sociedad, haber cubierto la reparación del daño y la multa.',
            'tipo_tramite_id' => 4,
        ]);
        DB::table('tramites')->insert([
            'nombre' => 'Solicitud de libertad condicionada.',
            'descripcion' => 'Sentenciado que haya compurgado el 50% de la sentencia, que tenga buen comportamiento durante su reclusión, cumplido el plan de actividades, ser primodelincuente y no ser un riesgo para la víctima, testigo y sociedad, haber cubierto la reparación del daño y la multa.',
            'tipo_tramite_id' => 4,
        ]);
        DB::table('tramites')->insert([
            'nombre' => 'Cancelación del registro de antecedentes penales.',
            'descripcion' => 'De sentenciados que compurgaron o conmutaron la sentencia(dieron cumplimiento total).',
            'tipo_tramite_id' => 4,
        ]);
        DB::table('tramites')->insert([
            'nombre' => 'Rehabilitación de derechos electorales.',
            'descripcion' => 'De sentenciados que dieron cumplimiento con la sentencia.',
            'tipo_tramite_id' => 4,
        ]);
        DB::table('tramites')->insert([
            'nombre' => 'Cancelación de firma.',
            'descripcion' => 'Sentenciados que se encontraban en libertad bajo caución y ya dieron cumplimiento con la sentencia.',
            'tipo_tramite_id' => 4,
        ]);
        DB::table('tramites')->insert([
            'nombre' => 'Sustitutivo de pena.',
            'descripcion' => 'Sentenciado que por la edad avanzada, estado de salud, senilidad, sea innecesaria su estancia en prisión.',
            'tipo_tramite_id' => 4,
        ]);
        DB::table('tramites')->insert([
            'nombre' => 'Solicitud de copias.',
            'descripcion' => 'Sentenciados que solicitan copias certificadas de proceso o carpetas.',
            'tipo_tramite_id' => 4,
        ]);
        DB::table('tramites')->insert([
            'nombre' => 'Asesoría simple.',
            'descripcion' => 'Seguimiento de algún trámite o información en general.',
            'tipo_tramite_id' => 4,
        ]);
    }
}
