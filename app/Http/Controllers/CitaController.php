<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use Illuminate\Http\Request;
use App\Mail\ConfirmacionCita;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class CitaController extends Controller
{
    public function agendarCita(Request $request)
    {
        $exito = false;

        DB::beginTransaction();
        try {
            $cita = new Cita;
            $cita->folio = 'FDEA3C';
            $cita->fecha_cita = $request->dia_cita;
            $cita->fecha_formateada = $request->fecha_formateada;
            $cita->hora_cita = $request->hora_cita;
            $cita->nombre = $request->nombre;
            $cita->email = $request->email;
            $cita->telefono = $request->telefono;
            $cita->sexo = $request->sexo;
            $cita->tiene_discapacidad = $request->tiene_discapacidad == 'Si' ? true : false;
            $cita->tramite_id = $request->tramite;
            $cita->centro_atencion_id = $request->centro_atencion;
            $cita->save();
        
            $citaAgendada = new \stdClass();
            $citaAgendada->id = $cita->id;
            $citaAgendada->folio = $cita->folio;
            $citaAgendada->nombre = $cita->nombre;
            $citaAgendada->tramite = $cita->tramite->nombre;
            $citaAgendada->fecha = $cita->fecha_formateada;
            $citaAgendada->hora = $cita->hora_cita;
            $citaAgendada->centro_atencion = $cita->centroAtencion->nombre;
            $citaAgendada->direccion_centro_atencion = $cita->centroAtencion->direccion;

            Mail::to($cita->email)->send(new ConfirmacionCita($cita));

            DB::commit();
            $exito = true;
        } catch (\Throwable $th) {
            DB::rollback();
            $exito = false;
            return response()->json([
                "status" => "error",
                "message" => "Ocurrió un error al agendar la cita.",
                "error" => $th->getMessage(),
                "location" => $th->getFile(),
                "line" => $th->getLine(),
            ], 200);
        }

        if ($exito) {
            return response()->json([
                "status" => "ok",
                "message" => "Cita agendada con exito.",
                "cita_agendada" => $citaAgendada,
            ], 200);
        }
    }
}
