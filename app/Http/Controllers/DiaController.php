<?php

namespace App\Http\Controllers;

use App\Models\Dia;
use App\Models\Horario;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;

class DiaController extends Controller
{

    public function guardarDias(Request $request)
    {
        $exito = false;

        DB::beginTransaction();

        

        try
        {
            foreach($request->dias as $dia)
            {
                $existe_dia = Dia::where('fecha',$dia['date_string'])
                                 ->where('centro_atencion_id', $request->centro_atencion_id)
                                 ->first();
                if($existe_dia)
                {
                    $existe_dia->fecha = $dia['date_string'];
                    $existe_dia->hora_inicio = $dia['hora_inicio'];
                    $existe_dia->hora_fin = $dia['hora_fin'];
                    $existe_dia->duracion = $dia['duracion'];
                    $existe_dia->inhabil = $dia['inhabil'];
                    $existe_dia->save();
                }
                else {

                    
                    $day = new Dia;
                    $day->fecha = $dia['date_string'];
                    $day->hora_inicio = $dia['hora_inicio'];
                    $day->hora_fin = $dia['hora_fin'];
                    $day->duracion = $dia['duracion'];
                    $day->inhabil = $dia['inhabil'];
                    $day->mes = $dia['mes'];
                    $day->centro_atencion_id = $request->centro_atencion_id;
                    $day->save();

                    $anio = substr($day->fecha, 0, -6);
                    $dia_fecha = substr($day->fecha, -2, 2);

                    $h = substr($day->hora_inicio, 0, -3);
                    $m = substr($day->hora_inicio, 3, 2);

                    $hf = substr($day->hora_fin, 0, -3);
                    $mf = substr($day->hora_fin, 3, 2);


                    // return response()->json([
                    //     "status" => "ok",
                    //     "message" => "Dias agregados con exito.",
                    //     "ddd" => $anio
                    // ], 500);
                    // return response()->json([
                    //     "status" => "ok",
                    //     "message" => "Dias obtenidos con exito",
                    //     "año" => $anio,
                    //     "dia_mes" => $day->mes,
                    //     "dia_fecha" => $dia_fecha,
                    //     "h" => $h,
                    //     "m" => $m
                    // ], 500);

                    $date = Carbon::create($anio, $day->mes, $dia_fecha, $h,$m);
                    $datef = Carbon::create($anio, $day->mes, $dia_fecha, $hf,$mf);

                    $horario_final = $datef->toTimeString(); //fin del rango de horarios
                    $horario_insertar = $date->toTimeString(); //inicio rango de horarios

                    $cajas = $day->centroAtencion->numero_cajas;

                    while($horario_insertar < $horario_final)
                    {
                        $horario = new Horario;
                        $horario->hora_inicio = $horario_insertar;
                        $horario->citas_disponibles = $cajas;
                        $horario->dia_id = $day->id;
                        $horario->save();

                        $date->addMinutes($day->duracion);
                        $horario_insertar = $date->toTimeString();
                    }
                }
            }

            DB::commit();
            $exito = true;

        } catch (\Throwable $th) {
            return response()->json([
                "status" => "error",
                "message" => "Ocurrió un error guardar dias",
                "error" => $th->getMessage(),
                "location" => $th->getFile(),
                "line" => $th->getLine(),
            ], 200);
        }
        if ($exito) {
            return response()->json([
                "status" => "ok",
                "message" => "Dias agregados con éxito.",
                // "tramites" => $arrayTramites
            ], 200);
        }   
    }

    public function getDiasMes(Request $request)
    {
        try
        {
            if($request->pmes)
            {
                $days = Carbon::createFromDate(2023, $request->mes, 1)->daysInMonth;

                $first = Carbon::createFromDate(2023, $request->mes, 1);
                $last = Carbon::createFromDate(2023, $request->mes, $days);
                $period = CarbonPeriod::create($first, $last);

                $arrayDias = array();

                $id = 1;

                foreach($period as $date)
                {
                    $objectDia = new \stdClass();
                    $objectDia->id = $id;
                    $objectDia->dia = $this->formatearFecha($date->dayOfWeek,$date->day, $date->month, $date->year);
                    $objectDia->hora_inicio = $request->hora_inicio;
                    $objectDia->hora_fin = $request->hora_fin;
                    $objectDia->duracion = $request->duracion;
                    // $objectDia->inhabil = false;
                    $objectDia->date_string = $date->toDateString();
                    $objectDia->mes = $date->month;

                    if ($date->dayOfWeek == 0 || $date->dayOfWeek == 6) {
                        $objectDia->inhabil = true;
                    } else {
                        $objectDia->inhabil = false;
                    }
                    if($date->day < 10)
                    {
                        $objectDia->fecha = '0'.$date->day.'/'.$date->month.'/'.$date->year;
                    }
                    else
                    {
                        $objectDia->fecha = $date->day.'/'.$date->month.'/'.$date->year;
                    }
                    array_push($arrayDias,$objectDia);
                    $id++;
                }
            }

            else
            {
                $period = CarbonPeriod::create($request->fecha_inicio, $request->fecha_fin);

                $arrayDias = array();

                $id = 1;

                foreach($period as $date)
                {
                    $objectDia = new \stdClass();
                    $objectDia->id = $id;
                    $objectDia->dia = $this->formatearFecha($date->dayOfWeek,$date->day, $date->month, $date->year);
                    $objectDia->hora_inicio = $request->hora_inicio;
                    $objectDia->hora_fin = $request->hora_fin;
                    $objectDia->duracion = $request->duracion;
                    $objectDia->inhabil = false;
                    $objectDia->date_string = $date->toDateString();
                    $objectDia->mes = $date->month;

                    if ($date->dayOfWeek == 0 || $date->dayOfWeek == 6) {
                        $objectDia->inhabil = true;
                    } else {
                        $objectDia->inhabil = false;
                    }
                    
                    if($date->day < 10)
                    {
                        $objectDia->fecha = '0'.$date->day.'/'.$date->month.'/'.$date->year;
                    }
                    else
                    {
                        $objectDia->fecha = $date->day.'/'.$date->month.'/'.$date->year;
                    }
                    array_push($arrayDias,$objectDia);
                    $id++;
                }
            }


            return response()->json([
                "status" => "ok",
                "message" => "Dias obtenidos con éxito",
                "dias" => $arrayDias
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => "error",
                "message" => "Ocurrió un error al obtener dias",
                "error" => $th->getMessage(),
                "location" => $th->getFile(),
                "line" => $th->getLine(),
            ], 200);
        }

    }

    public function getDiasEditar(Request $request)
    {
        try {
            $dias = Dia::where('mes',$request->mes)
                        ->where('centro_atencion_id', $request->centro_atencion_id)
                        ->get();

            $arrayDias = array();

            $id = 1;

            foreach($dias as $dia)
            {
                $objectDia = new \stdClass();
                $objectDia->id = $dia->id;
                $objectDia->dia = $dia->fecha;
                $objectDia->hora_inicio = $dia->hora_inicio;
                $objectDia->hora_fin = $dia->hora_fin;
                $objectDia->duracion = $dia->duracion;
                $objectDia->centro_atencion_id = $dia->centro_atencion_id;

                if($dia->inhabil == 0)
                    $objectDia->inhabil = false;
                else
                    $objectDia->inhabil = true;

                $objectDia->date_string = $dia->date_string;
                $objectDia->mes = $dia->mes;
                
                array_push($arrayDias,$objectDia);
                $id++;
            }

            return response()->json([
                "status" => "ok",
                "message" => "Dias obtenidos con éxito",
                "dias" => $arrayDias
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                "status" => "error",
                "message" => "Ocurrió un error al obtener dias",
                "error" => $th->getMessage(),
                "location" => $th->getFile(),
                "line" => $th->getLine(),
            ], 200);
        }
    }

    public function actualizarHorario(Request $request) 
    {
        try {

            $exito = false;

            DB::beginTransaction();

            $dia = Dia::find($request->id);

            $dia->id = $request->id;
            $dia->fecha = $request->dia;
            $dia->hora_inicio = $request->hora_inicio;
            $dia->hora_fin = $request->hora_fin;
            $dia->duracion = $request->duracion;
            $dia->inhabil = $request->inhabil;
            $dia->save();

            foreach($dia->horarios as $horario)
            {
                $horario->delete();
            }

            //Se agregan los horarios en horarios

            $anio = intval(substr($dia->fecha, 0, -6));
            $dia_fecha = intval(substr($dia->fecha, -2, 2));

            $h = intval(substr($dia->hora_inicio, 0, -3));
            $m = intval(substr($dia->hora_inicio, 3, 2));

            $hf = intval(substr($dia->hora_fin, 0, -3));
            $mf = intval(substr($dia->hora_fin, 3, 2));



            $mes = intval($dia->mes);
            // return response()->json([
            //     "status" => "ok",
            //     "message" => "Dias obtenidos con exito",
            //     "año" => $anio,
            //     "dia_mes" => $mes,
            //     "dia_fecha" => $dia_fecha,
            //     "h" => $h,
            //     "m" => $m

            // ], 500);

            $date = Carbon::create($anio, $mes, $dia_fecha, $h,$m);
            $datef = Carbon::create($anio, $mes, $dia_fecha, $hf,$mf);

            // return response()->json([
            //     "status" => "ok",
            //     "message" => "Dias obtenidos con exito",
            //     "dias" => $date
            // ], 500);

            $horario_final = $datef->toTimeString(); //fin del rango de horarios
            $horario_insertar = $date->toTimeString(); //inicio rango de horarios


            $cajas = $dia->centroAtencion->numero_cajas;
            while($horario_insertar < $horario_final)
            {
                $horario = new Horario;
                $horario->hora_inicio = $horario_insertar;
                $horario->citas_disponibles = $cajas;
                $horario->dia_id = $dia->id;
                $horario->save();

                $date->addMinutes($dia->duracion);
                $horario_insertar = $date->toTimeString();
            }


            // $horario = Horario::where('dia_id',$dia->id)->first();
            // $horario->hora_inicio = $dia->hora_inicio;
            // $horario->save();


            $dias = Dia::where('mes',$request->mes)
                        ->where('centro_atencion_id', $request->centro_atencion_id)
                        ->get();

            $arrayDias = array();
            $id = 1;

            foreach($dias as $dia)
            {
                $objectDia = new \stdClass();
                $objectDia->id = $dia->id;
                $objectDia->dia = $dia->fecha;
                $objectDia->hora_inicio = $dia->hora_inicio;
                $objectDia->hora_fin = $dia->hora_fin;
                $objectDia->duracion = $dia->duracion;
                $objectDia->centro_atencion_id = $dia->centro_atencion_id;
                if($dia->inhabil == 0)
                    $objectDia->inhabil = false;
                else
                    $objectDia->inhabil = true;

                $objectDia->date_string = $dia->date_string;
                $objectDia->mes = $dia->mes;
                
                array_push($arrayDias,$objectDia);
                $id++;
            }

            DB::commit();
            $exito = true;

           

        } catch (\Throwable $th) {
            return response()->json([
                "status" => "error",
                "message" => "Ocurrió un error al actuzlizar dias",
                "error" => $th->getMessage(),
                "location" => $th->getFile(),
                "line" => $th->getLine(),
            ], 200);
        }
        if($exito) {
            return response()->json([
                "status" => "ok",
                "message" => "Dias obtenidos con éxito",
                "dias" => $arrayDias
            ], 200);
        }
    }


    public function formatearFecha($week_day, $day, $month, $year)
    {
        $nombre_dia = '';
        switch ($week_day) {
            case 0:
                $nombre_dia = 'Domingo';
                break;
            case 1:
                $nombre_dia = 'Lunes';
                break;
            case 2:
                $nombre_dia = 'Martes';
                break;
            case 3:
                $nombre_dia = 'Miércoles';
                break;
            case 4:
                $nombre_dia = 'Jueves';
                break;
            case 5:
                $nombre_dia = 'Viernes';
                break;
            case 6:
                $nombre_dia = 'Sábado';
                break;
        }

        $nombre_mes = '';
        switch ($month) {
            case 1:
                $nombre_mes = 'Enero';
                break;
            case 2:
                $nombre_mes = 'Febrero';
                break;
            case 3:
                $nombre_mes = 'Marzo';
                break;
            case 4:
                $nombre_mes = 'Abril';
                break;
            case 5:
                $nombre_mes = 'Mayo';
                break;
            case 6:
                $nombre_mes = 'Junio';
                break;
            case 7:
                $nombre_mes = 'Julio';
                break;
            case 8:
                $nombre_mes = 'Agosto';
                break;
            case 9:
                $nombre_mes = 'Septiembre';
                break;
            case 10:
                $nombre_mes = 'Octubre';
                break;
            case 11:
                $nombre_mes = 'Noviembre';
                break;
            case 12:
                $nombre_mes = 'Diciembre';
                break;
        }

        $fecha_formateada = $nombre_dia . ', ' . $day . ' de ' . $nombre_mes . ' de ' . $year;
        return $fecha_formateada;
    }

    public function getCalendarioCitas(Request $request)
    {
        try {
            $current_date = Carbon::now();

            $year = $request->year;
            $month = $request->mes;

            // Primer dia del mes
            $first = Carbon::createFromDate($year, $month, 1);
            // Numero de dias en el mes
            $days = $first->month($month)->daysInMonth;
            // Ultimo dia del mes
            $last = Carbon::createFromDate($year, $month, $days);
            // Arregle con todas las fechas del mes
            $period = CarbonPeriod::create($first, $last);

            // Se declara un arreglo por semana a dibujar en el calendario en la vista.
            $semana_uno = array();
            $semana_dos = array();
            $semana_tres = array();
            $semana_cuatro = array();
            $semana_cinco = array();
            $semana_seis = array();

            $objectVacio = new \stdClass();
            $objectVacio->fecha_completa = '';
            $objectVacio->dia = '';
            $objectVacio->numero_dia_semana = '';
            $objectVacio->fecha_formateada = '';
            $objectVacio->hora_inicio = '';
            $objectVacio->hora_fin = '';
            $objectVacio->duracion = '';
            $objectVacio->centro_atencion_id = null;
            $objectVacio->dia_disponible = false;
            $objectVacio->dia_sin_servicio = false;

            $contador = $first->dayOfWeek+1;

            // Comparacion con dias que se tienen en la tabla 
            foreach ($period as $date) {
                // Obtenemos solo parte de la fecha de $date 
                $fecha = $date->toDateString();
                // Buscamos el día en la base de datos
                $dia =  Dia::where('fecha', $fecha)->where('centro_atencion_id', $request->centro_atencion_id)->first();

                if($dia) {
                    // Creamos nuestro objeto para cada día
                    $object = new \stdClass();
                    $object->fecha_completa = $dia->fecha;
                    $object->dia = $date->day;
                    $object->numero_dia_semana = $date->dayOfWeek;
                    $object->fecha_formateada = $this->formatearFecha($date->dayOfWeek, $date->day, $date->month, $date->year);
                    $object->hora_inicio = $dia->hora_inicio;
                    $object->hora_fin = $dia->hora_fin;
                    $object->duracion = $dia->duracion;
                    $object->centro_atencion_id = $dia->centro_atencion_id;
                
                    // Obtenemos los horarios relacionados al registro dia en la base de datos
                    $horarios = $dia->horarios;

                    // Recorremos los horarios y si el campo citas disponibles es mayor a cero agregamos el horario a un arreglo
                    $horariosAtencion = [];
                    foreach ($horarios as $horario) {
                        if ($horario->citas_disponibles > 0) {
                            array_push($horariosAtencion, $horario);
                        }
                    }

                    // El arreglo donde guardamos los horarios lo agregamos a nuestro objeto dia
                    $object->horarios_disponibles = $horariosAtencion;

                    // Si el arreglo de horarios esta vacio indicamos dia sin disponibilidad
                    if($horariosAtencion == []) {
                        $object->dia_disponible = false;
                    } else {
                        if ($date < $current_date) {
                            $object->dia_disponible = false;
                        } else {
                            $object->dia_disponible = true;
                        }    
                    }

                    // Verificamos si el registro dia en la base de datos en el campo inhabil es true o false para ponerlo como dia sin servicio
                    if ($dia->inhabil) {
                        $object->dia_sin_servicio = true;
                    } else {
                        $object->dia_sin_servicio = false;
                    }
                } else {
                    $object = new \stdClass();
                    $object->fecha_completa = '';
                    $object->dia = $date->day;
                    $object->numero_dia_semana = $date->dayOfWeek;
                    $object->fecha_formateada = $this->formatearFecha($date->dayOfWeek, $date->day, $date->month, $date->year);
                    $object->hora_inicio = '';
                    $object->hora_fin = '';
                    $object->duracion = '';
                    $object->centro_atencion_id = null;

                    if ($date->dayOfWeek == 0 || $date->dayOfWeek == 6) {
                        $object->dia_sin_servicio = true;
                    } else {
                        $object->dia_sin_servicio = false;
                    }
                }

                // Agregamos el día a su correspondiente arreglo
                if ($contador > 0 && $contador <= 7) {
                    array_push($semana_uno, $object);
                } else if ($contador > 7 && $contador <= 14) {
                    array_push($semana_dos, $object);
                } else if ($contador > 14 && $contador <= 21) {
                    array_push($semana_tres, $object);
                } else if ($contador > 21 && $contador <= 28) {
                    array_push($semana_cuatro, $object);
                } else if ($contador > 28 && $contador <= 35) {
                    array_push($semana_cinco, $object);
                } else if ($contador > 35) {
                    array_push($semana_seis, $object);
                }

                $contador++;
            }

            $array_aux_1 = array();
            $dias_faltantes_semana_uno = 7 - count($semana_uno);
            if ($dias_faltantes_semana_uno > 0) {
                for ($i = 0; $i < $dias_faltantes_semana_uno; $i++) {
                    array_push($array_aux_1, $objectVacio);
                }
                $semana_uno = array_merge($array_aux_1, $semana_uno);
            }
            
            $array_aux_2 = array();
            $dias_faltantes_semana_seis = 7 - count($semana_seis);
            if ($dias_faltantes_semana_seis > 0) {
                for ($i = 0; $i < $dias_faltantes_semana_seis; $i++) {
                    array_push($array_aux_2, $objectVacio);
                }
                $semana_seis = array_merge($semana_seis, $array_aux_2);
            }

            $array_aux_3 = array();
            $dias_faltantes_semana_cinco = 7 - count($semana_cinco);
            if ($dias_faltantes_semana_cinco > 0) {
                for ($i = 0; $i < $dias_faltantes_semana_cinco; $i++) {
                    array_push($array_aux_3, $objectVacio);
                }
                $semana_cinco = array_merge($semana_cinco, $array_aux_3);
            }

            $objectCalendarioCitas = new \stdClass();
            $objectCalendarioCitas->semana_uno = $semana_uno;
            $objectCalendarioCitas->semana_dos = $semana_dos;
            $objectCalendarioCitas->semana_tres = $semana_tres;
            $objectCalendarioCitas->semana_cuatro = $semana_cuatro;
            $objectCalendarioCitas->semana_cinco = $semana_cinco;
            $objectCalendarioCitas->semana_seis = $semana_seis;
            
            return response()->json([
                "status" => "ok",
                "message" => "Calendario de citas obtenido con éxito.",
                "calendario_citas" => $objectCalendarioCitas,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => "error",
                "message" => "Ocurrió un error al obtener el calendario de citas disponibles.",
                "error" => $th->getMessage(),
                "location" => $th->getFile(),
                "line" => $th->getLine(),
            ], 200);
        }
    }
}
