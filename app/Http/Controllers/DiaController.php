<?php

namespace App\Http\Controllers;

use App\Models\Dia;
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
                "message" => "Dias agregados con exito.",
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



                    // if($dia->inhabil == 0)
                    //     $objectDia->inhabil = false;
                    // else
                    //     $objectDia->inhabil = true;

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
                "message" => "Dias obtenidos con exito",
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
                "message" => "Dias obtenidos con exito",
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
                "message" => "Dias obtenidos con exito",
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
                $nombre_dia = 'Sabado';
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
}
