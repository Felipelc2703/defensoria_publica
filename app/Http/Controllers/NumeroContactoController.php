<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NumeroContacto;
use Illuminate\Support\Facades\DB;

class NumeroContactoController extends Controller
{
    public function getNumero()
    {
        try {
            $numero = NumeroContacto::first();

            if (!$numero) {
                return response()->json([
                    "status" => "no-data",
                    "message" => "No existe ningún registro de número de contacto de WhatsApp",
                ], 200);
            }

            $object = new \stdClass();
            $object->id = $numero->id;
            $object->telefono = $numero->telefono;
            $object->hora_inicio = $numero->hora_inicio;
            $object->hora_fin = $numero->hora_fin;
            $object->dia1 = $numero->dia1 ? true : false;
            $object->dia2 = $numero->dia2 ? true : false;
            $object->dia3 = $numero->dia3 ? true : false;
            $object->dia4 = $numero->dia4 ? true : false;
            $object->dia5 = $numero->dia5 ? true : false;
            $object->dia6 = $numero->dia6 ? true : false;
            $object->dia7 = $numero->dia7 ? true : false;

            return response()->json([
                "status" => "ok",
                "message" => "Número de contacto de WhatsApp obtenido con éxito.",
                "registro" => $object
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => "error",
                "message" => "Ocurrió un error al obtener el número de contacto de WhatsApp.",
                "error" => $th->getMessage(),
                "location" => $th->getFile(),
                "line" => $th->getLine(),
            ], 200);
        }
    }

    public function guardarNumero(Request $request) {
        $exito = false;

        DB::beginTransaction();
        try {
            if ($request->id != null) {
                $contacto = NumeroContacto::find($request->id);
                $contacto->telefono = $request->telefono;
                $contacto->hora_inicio = $request->hora_inicio;
                $contacto->hora_fin = $request->hora_fin;
                $contacto->dia1 = $request->dia1;
                $contacto->dia2 = $request->dia2;
                $contacto->dia3 = $request->dia3;
                $contacto->dia4 = $request->dia4;
                $contacto->dia5 = $request->dia5;
                $contacto->dia6 = $request->dia6;
                $contacto->dia7 = $request->dia7;
                $contacto->save();
            } else {
                $contacto = new NumeroContacto;
                $contacto->telefono = $request->telefono;
                $contacto->hora_inicio = $request->hora_inicio;
                $contacto->hora_fin = $request->hora_fin;
                $contacto->dia1 = $request->dia1;
                $contacto->dia2 = $request->dia2;
                $contacto->dia3 = $request->dia3;
                $contacto->dia4 = $request->dia4;
                $contacto->dia5 = $request->dia5;
                $contacto->dia6 = $request->dia6;
                $contacto->dia7 = $request->dia7;
                $contacto->save();
            }

            DB::commit();
            $exito = true;
        } catch (\Throwable $th) {
            DB::rollback();
            $exito = false;
            return response()->json([
                "status" => "error",
                "message" => "Ocurrió un error al guardaro número de contacto de WhatsApp.",
                "error" => $th->getMessage(),
                "location" => $th->getFile(),
                "line" => $th->getLine(),
            ], 200);
        }

        if ($exito) {
            return response()->json([
                "status" => "ok",
                "message" => "Número de contacto de WhatsApp guardado con éxito.",
            ], 200);
        }
    }
}
