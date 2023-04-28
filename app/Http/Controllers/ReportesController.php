<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Cita;

use App\Models\CitaJuzgado;
use App\Models\CitaConsejero;

use Illuminate\Http\Request;
use App\Exports\ReporteExport;
use App\Exports\ReporteJuezExport;

class ReportesController extends Controller
{
    public function generarReporte(Request $request)
    {
        try {
            if($request->oficina_id == 0 && $request->tramite_id == 0 && $request->estatus == 4)
            {
                $citas = Cita::where('fecha_cita', '>=', $request->fecha_inicio)
                            ->where('fecha_cita', '<=', $request->fecha_final)
                            ->orderBy('fecha_cita', 'asc')
                            ->orderBy('hora_cita', 'asc')
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

                    if($cita->tiene_discapacidad == 1)
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
                            ->orderBy('fecha_cita', 'asc')
                            ->orderBy('hora_cita', 'asc')
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

                    if($cita->tiene_discapacidad == 1)
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
                            ->orderBy('fecha_cita', 'asc')
                            ->orderBy('hora_cita', 'asc')
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

                    if($cita->tiene_discapacidad == 1)
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
                            ->orderBy('fecha_cita', 'asc')
                            ->orderBy('hora_cita', 'asc')
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

                    if($cita->tiene_discapacidad == 1)
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
                            ->orderBy('fecha_cita', 'asc')
                            ->orderBy('hora_cita', 'asc')
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

                    if($cita->tiene_discapacidad == 1)
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
                            ->orderBy('fecha_cita', 'asc')
                            ->orderBy('hora_cita', 'asc')
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

                    if($cita->tiene_discapacidad == 1)
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
                            ->orderBy('fecha_cita', 'asc')
                            ->orderBy('hora_cita', 'asc')
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

                    if($cita->tiene_discapacidad == 1)
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
                            ->orderBy('fecha_cita', 'asc')
                            ->orderBy('hora_cita', 'asc')
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

                    if($cita->tiene_discapacidad == 1)
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

    public function generarReporteJuez(Request $request)
    {
        try {
            if ($request->estatus == 4) {
                $citas = CitaJuzgado::where('fecha_cita', '>=', $request->fecha_inicio)
                                    ->where('fecha_cita', '<=', $request->fecha_final)
                                    ->orderBy('fecha_cita', 'asc')
                                    ->orderBy('hora_cita', 'asc')
                                    ->get();
            } else {
                $citas = CitaJuzgado::where('fecha_cita', '>=', $request->fecha_inicio)
                                    ->where('fecha_cita', '<=', $request->fecha_final)
                                    ->where('status', $request->estatus)
                                    ->orderBy('fecha_cita', 'asc')
                                    ->orderBy('hora_cita', 'asc')
                                    ->get();
            }

            $arrayReporte = array();
            $contador = 0;
            foreach($citas as $cita)
            {
                $objectCita = new \stdClass();
                $objectCita->id = $cita->id;
                $objectCita->folio = $cita->folio;
                $objectCita->nombre = $cita->usuario->nombre . ' ' . $cita->usuario->apellido_paterno . ' ' . $cita->usuario->apellido_materno;
                $objectCita->correo = $cita->usuario->email;
                $objectCita->telefono = $cita->usuario->telefono;
                $objectCita->fecha = $cita->fecha_cita;
                $objectCita->horario = $cita->hora_cita;
                $objectCita->sexo = $cita->usuario->sexo;
                $objectCita->expediente = $cita->expediente;
                $objectCita->asunto = $cita->asunto;

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

            return response()->json([
                "status" => "ok",
                "message" => "Reporte obtenido con exito",
                "reporte" => $arrayReporte
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => "error",
                "message" => "Ocurrió un error al obtener el reporte de citas",
                "error" => $th->getMessage(),
                "location" => $th->getFile(),
                "line" => $th->getLine(),
            ], 200);
        }
    }

    public function generarReporteConsejero(Request $request)
    {
        try {
            if ($request->estatus == 4) {
                $citas = CitaConsejero::where('fecha_cita', '>=', $request->fecha_inicio)
                                    ->where('fecha_cita', '<=', $request->fecha_final)
                                    ->orderBy('fecha_cita', 'asc')
                                    ->orderBy('hora_cita', 'asc')
                                    ->get();
            } else {
                $citas = CitaConsejero::where('fecha_cita', '>=', $request->fecha_inicio)
                                    ->where('fecha_cita', '<=', $request->fecha_final)
                                    ->where('status', $request->estatus)
                                    ->orderBy('fecha_cita', 'asc')
                                    ->orderBy('hora_cita', 'asc')
                                    ->get();
            }

            $arrayReporte = array();
            $contador = 0;
            foreach($citas as $cita)
            {
                $objectCita = new \stdClass();
                $objectCita->id = $cita->id;
                $objectCita->folio = $cita->folio;
                $objectCita->nombre = $cita->usuario->nombre . ' ' . $cita->usuario->apellido_paterno . ' ' . $cita->usuario->apellido_materno;
                $objectCita->correo = $cita->usuario->email;
                $objectCita->telefono = $cita->usuario->telefono;
                $objectCita->fecha = $cita->fecha_cita;
                $objectCita->horario = $cita->hora_cita;
                $objectCita->sexo = $cita->usuario->sexo;
                // $objectCita->expediente = $cita->expediente;
                $objectCita->asunto = $cita->asunto;

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

            return response()->json([
                "status" => "ok",
                "message" => "Reporte obtenido con exito",
                "reporte" => $arrayReporte
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => "error",
                "message" => "Ocurrió un error al obtener el reporte de citas",
                "error" => $th->getMessage(),
                "location" => $th->getFile(),
                "line" => $th->getLine(),
            ], 200);
        }
    }

    public function exportarExcelJuez(Request $request)
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
        return (new ReporteJuezExport($citas,$contador))->download('reporte.xlsx');
    }

    public function exportarExcelConsejero(Request $request)
    {
        return response()->json([
            "status" => "ok",
            "message" => $request->citas,
            // "reporte" => $citas
        ], 500);
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
        return (new ReporteJuezExport($citas,$contador))->download('reporte.xlsx');
    }
}
