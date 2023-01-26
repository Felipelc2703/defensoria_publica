<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cita;

use App\Exports\ReporteExport;

class ReportesController extends Controller
{
    public function generarReporte(Request $request)
    {
        try {
            if($request->oficina_id == 0 && $request->tramite_id == 0 && $request->estatus == 4)
            {
                $citas = Cita::where('fecha_cita', '>=', $request->fecha_inicio)
                            ->where('fecha_cita', '<=', $request->fecha_final)
                            ->get();

                $arrayReporte = array();
                $contador = 0;
                foreach($citas as $cita)
                {
                    $objectCita = new \stdClass();
                    $objectCita->id = $cita->id;
                    $objectCita->folio = $cita->folio;
                    $objectCita->nombre_contribuyente = $cita->nombre;
                    $objectCita->correo = $cita->email;
                    $objectCita->telefono = $cita->telefono;
                    $objectCita->tramite = $cita->tramite->nombre;
                    $objectCita->fecha = $cita->fecha_cita;
                    $objectCita->horario = $cita->hora_cita;
                    $objectCita->centro_atencion = $cita->centroAtencion->nombre;
                    $objectCita->tipo_discapacidad = $cita->discapacidad;
                    $objectCita->sexo = $cita->sexo;

                    if($cita->tiene_discapacidad == 0)
                    {
                        $objectCita->discapacidad = "SI";
                    }
                    else {
                        $objectCita->discapacidad = "NO";
                    }

                    switch($cita->status)
                    {
                        case 1:
                            $objectCita->estatus = 'Reservada';
                            break;
                        case 2:
                            $objectCita->estatus = 'Confirmada';
                            break;
                        case 3: 
                            $objectCita->estatus = 'Cancelada';
                    }
                    array_push($arrayReporte,$objectCita);
                    $contador++;
                }
            }
            if($request->oficina_id == 0 && $request->tramite_id == 0 && $request->estatus != 4)
            {
                $citas = Cita::where('fecha_cita', '>=', $request->fecha_inicio)
                            ->where('fecha_cita', '<=', $request->fecha_final)
                            ->where('status',$request->estatus)
                            ->get();

                $arrayReporte = array();
                $contador = 0;
                foreach($citas as $cita)
                {
                    $objectCita = new \stdClass();
                    $objectCita->id = $cita->id;
                    $objectCita->folio = $cita->folio;
                    $objectCita->nombre_contribuyente = $cita->nombre;
                    $objectCita->correo = $cita->email;
                    $objectCita->telefono = $cita->telefono;
                    $objectCita->tramite = $cita->tramite->nombre;
                    $objectCita->fecha = $cita->fecha_cita;
                    $objectCita->horario = $cita->hora_cita;
                    $objectCita->centro_atencion = $cita->centroAtencion->nombre;
                    $objectCita->tipo_discapacidad = $cita->discapacidad;

                    if($cita->tiene_discapacidad == 0)
                    {
                        $objectCita->discapacidad = "SI";
                    }
                    else {
                        $objectCita->discapacidad = "NO";
                    }

                    switch($cita->status)
                    {
                        case 1:
                            $objectCita->estatus = 'Reservada';
                            break;
                        case 2:
                            $objectCita->estatus = 'Confirmada';
                            break;
                        case 3: 
                            $objectCita->estatus = 'Cancelada';
                    }
                    array_push($arrayReporte,$objectCita);
                    $contador++;
                }

            }
            if($request->oficina_id == 0 && $request->tramite_id != 0 && $request->estatus == 4)
            {
                $citas = Cita::where('fecha_cita', '>=', $request->fecha_inicio)
                            ->where('fecha_cita', '<=', $request->fecha_final)
                            ->where('tramite_id',$request->tramite_id)
                            ->get();

                $arrayReporte = array();
                $contador = 0;
                foreach($citas as $cita)
                {
                    $objectCita = new \stdClass();
                    $objectCita->id = $cita->id;
                    $objectCita->folio = $cita->folio;
                    $objectCita->nombre_contribuyente = $cita->nombre;
                    $objectCita->correo = $cita->email;
                    $objectCita->telefono = $cita->telefono;
                    $objectCita->tramite = $cita->tramite->nombre;
                    $objectCita->fecha = $cita->fecha_cita;
                    $objectCita->horario = $cita->hora_cita;
                    $objectCita->centro_atencion = $cita->centroAtencion->nombre;
                    $objectCita->tipo_discapacidad = $cita->discapacidad;

                    if($cita->tiene_discapacidad == 0)
                    {
                        $objectCita->discapacidad = "SI";
                    }
                    else {
                        $objectCita->discapacidad = "NO";
                    }

                    switch($cita->status)
                    {
                        case 1:
                            $objectCita->estatus = 'Reservada';
                            break;
                        case 2:
                            $objectCita->estatus = 'Confirmada';
                            break;
                        case 3: 
                            $objectCita->estatus = 'Cancelada';
                    }
                    array_push($arrayReporte,$objectCita);
                    $contador++;
                }

            }
            if($request->oficina_id == 0 && $request->tramite_id != 0 && $request->estatus != 4)
            {
                $citas = Cita::where('fecha_cita', '>=', $request->fecha_inicio)
                            ->where('fecha_cita', '<=', $request->fecha_final)
                            ->where('tramite_id',$request->tramite_id)
                            ->where('status',$request->estatus)
                            ->get();

                $arrayReporte = array();
                $contador = 0;
                foreach($citas as $cita)
                {
                    $objectCita = new \stdClass();
                    $objectCita->id = $cita->id;
                    $objectCita->folio = $cita->folio;
                    $objectCita->nombre_contribuyente = $cita->nombre;
                    $objectCita->correo = $cita->email;
                    $objectCita->telefono = $cita->telefono;
                    $objectCita->tramite = $cita->tramite->nombre;
                    $objectCita->fecha = $cita->fecha_cita;
                    $objectCita->horario = $cita->hora_cita;
                    $objectCita->centro_atencion = $cita->centroAtencion->nombre;
                    $objectCita->tipo_discapacidad = $cita->discapacidad;

                    if($cita->tiene_discapacidad == 0)
                    {
                        $objectCita->discapacidad = "SI";
                    }
                    else {
                        $objectCita->discapacidad = "NO";
                    }

                    switch($cita->status)
                    {
                        case 1:
                            $objectCita->estatus = 'Reservada';
                            break;
                        case 2:
                            $objectCita->estatus = 'Confirmada';
                            break;
                        case 3: 
                            $objectCita->estatus = 'Cancelada';
                    }
                    array_push($arrayReporte,$objectCita);
                    $contador++;
                }

            }
            if($request->oficina_id != 0 && $request->tramite_id == 0 && $request->estatus == 4)
            {
                $citas = Cita::where('fecha_cita', '>=', $request->fecha_inicio)
                            ->where('fecha_cita', '<=', $request->fecha_final)
                            ->where('centro_atencion_id',$request->oficina_id)
                            ->get();

                $arrayReporte = array();
                $contador = 0;
                foreach($citas as $cita)
                {
                    $objectCita = new \stdClass();
                    $objectCita->id = $cita->id;
                    $objectCita->folio = $cita->folio;
                    $objectCita->nombre_contribuyente = $cita->nombre;
                    $objectCita->correo = $cita->email;
                    $objectCita->telefono = $cita->telefono;
                    $objectCita->tramite = $cita->tramite->nombre;
                    $objectCita->fecha = $cita->fecha_cita;
                    $objectCita->horario = $cita->hora_cita;
                    $objectCita->centro_atencion = $cita->centroAtencion->nombre;
                    $objectCita->tipo_discapacidad = $cita->discapacidad;

                    if($cita->tiene_discapacidad == 0)
                    {
                        $objectCita->discapacidad = "SI";
                    }
                    else {
                        $objectCita->discapacidad = "NO";
                    }

                    switch($cita->status)
                    {
                        case 1:
                            $objectCita->estatus = 'Reservada';
                            break;
                        case 2:
                            $objectCita->estatus = 'Confirmada';
                            break;
                        case 3: 
                            $objectCita->estatus = 'Cancelada';
                    }
                    array_push($arrayReporte,$objectCita);
                    $contador++;
                }

            }
            if($request->oficina_id != 0 && $request->tramite_id == 0 && $request->estatus != 4)
            {
                $citas = Cita::where('fecha_cita', '>=', $request->fecha_inicio)
                            ->where('fecha_cita', '<=', $request->fecha_final)
                            ->where('centro_atencion_id',$request->oficina_id)
                            ->where('status',$request->estatus)
                            ->get();

                $arrayReporte = array();
                $contador = 0;
                foreach($citas as $cita)
                {
                    $objectCita = new \stdClass();
                    $objectCita->id = $cita->id;
                    $objectCita->folio = $cita->folio;
                    $objectCita->nombre_contribuyente = $cita->nombre;
                    $objectCita->correo = $cita->email;
                    $objectCita->telefono = $cita->telefono;
                    $objectCita->tramite = $cita->tramite->nombre;
                    $objectCita->fecha = $cita->fecha_cita;
                    $objectCita->horario = $cita->hora_cita;
                    $objectCita->centro_atencion = $cita->centroAtencion->nombre;
                    $objectCita->tipo_discapacidad = $cita->discapacidad;

                    if($cita->tiene_discapacidad == 0)
                    {
                        $objectCita->discapacidad = "SI";
                    }
                    else {
                        $objectCita->discapacidad = "NO";
                    }

                    switch($cita->status)
                    {
                        case 1:
                            $objectCita->estatus = 'Reservada';
                            break;
                        case 2:
                            $objectCita->estatus = 'Confirmada';
                            break;
                        case 3: 
                            $objectCita->estatus = 'Cancelada';
                    }
                    array_push($arrayReporte,$objectCita);
                    $contador++;
                }

            }
            if($request->oficina_id != 0 && $request->tramite_id != 0 && $request->estatus == 4)
            {
                $citas = Cita::where('fecha_cita', '>=', $request->fecha_inicio)
                            ->where('fecha_cita', '<=', $request->fecha_final)
                            ->where('centro_atencion_id',$request->oficina_id)
                            ->where('tramite_id',$request->tramite_id)
                            ->get();

                $arrayReporte = array();
                $contador = 0;
                foreach($citas as $cita)
                {
                    $objectCita = new \stdClass();
                    $objectCita->id = $cita->id;
                    $objectCita->folio = $cita->folio;
                    $objectCita->nombre_contribuyente = $cita->nombre;
                    $objectCita->correo = $cita->email;
                    $objectCita->telefono = $cita->telefono;
                    $objectCita->tramite = $cita->tramite->nombre;
                    $objectCita->fecha = $cita->fecha_cita;
                    $objectCita->horario = $cita->hora_cita;
                    $objectCita->centro_atencion = $cita->centroAtencion->nombre;
                    $objectCita->tipo_discapacidad = $cita->discapacidad;

                    if($cita->tiene_discapacidad == 0)
                    {
                        $objectCita->discapacidad = "SI";
                    }
                    else {
                        $objectCita->discapacidad = "NO";
                    }

                    switch($cita->status)
                    {
                        case 1:
                            $objectCita->estatus = 'Reservada';
                            break;
                        case 2:
                            $objectCita->estatus = 'Confirmada';
                            break;
                        case 3: 
                            $objectCita->estatus = 'Cancelada';
                    }
                    array_push($arrayReporte,$objectCita);
                    $contador++;
                }

            }
            if($request->oficina_id != 0 && $request->tramite_id != 0 && $request->estatus != 4)
            {
                $citas = Cita::where('fecha_cita', '>=', $request->fecha_inicio)
                            ->where('fecha_cita', '<=', $request->fecha_final)
                            ->where('centro_atencion_id',$request->oficina_id)
                            ->where('tramite_id',$request->tramite_id)
                            ->where('status',$request->estatus)
                            ->get();

                $arrayReporte = array();
                $contador = 0;
                foreach($citas as $cita)
                {
                    $objectCita = new \stdClass();
                    $objectCita->id = $cita->id;
                    $objectCita->folio = $cita->folio;
                    $objectCita->nombre_contribuyente = $cita->nombre;
                    $objectCita->correo = $cita->email;
                    $objectCita->telefono = $cita->telefono;
                    $objectCita->tramite = $cita->tramite->nombre;
                    $objectCita->fecha = $cita->fecha_cita;
                    $objectCita->horario = $cita->hora_cita;
                    $objectCita->centro_atencion = $cita->centroAtencion->nombre;
                    $objectCita->tipo_discapacidad = $cita->discapacidad;

                    if($cita->tiene_discapacidad == 0)
                    {
                        $objectCita->discapacidad = "SI";
                    }
                    else {
                        $objectCita->discapacidad = "NO";
                    }

                    switch($cita->status)
                    {
                        case 1:
                            $objectCita->estatus = 'Reservada';
                            break;
                        case 2:
                            $objectCita->estatus = 'Confirmada';
                            break;
                        case 3: 
                            $objectCita->estatus = 'Cancelada';
                    }
                    array_push($arrayReporte,$objectCita);
                    $contador++;
                }

            }
            return response()->json([
                "status" => "ok",
                "message" => "Reporte obtenido con exito",
                "reporte" => $arrayReporte
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                "status" => "error",
                "message" => "Ocurrió un error al obtener el catalogo de requisitos",
                "error" => $th->getMessage(),
                "location" => $th->getFile(),
                "line" => $th->getLine(),
            ], 200);
        } 
    }

    public function exportarExcel(Request $request)
    {
        $citas = $request->citas;

        $contador = 0;
        foreach($citas as $cita)
        {
            $contador++;
        }

        // return response()->json([
        //     "status" => "ok",
        //     "message" => "Reporte obtenido con exito",
        //     "reporte" => $citas
        // ], 500);
        return (new ReporteExport($citas,$contador))->download('reporte.xlsx');
    }
}
