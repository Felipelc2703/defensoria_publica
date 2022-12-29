<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Requisito;
use Illuminate\Support\Facades\DB;


class RequisitoController extends Controller
{
    public function getRequisitos()
    {
        try {
            $requisitos = Requisito::where('status',1)->get();

            $arrayRequisitos = array();
            foreach($requisitos as $requsito) 
            {
                $objetoRequisito = new \stdClass();
                $objetoRequisito->id = $requsito->id;
                $objetoRequisito->nombre = $requsito->nombre;
                $objetoRequisito->tipo_tramite = $requsito->tipo_tramite_id;

                array_push($arrayRequisitos,$objetoRequisito);
            }

            return response()->json([
                "status" => "ok",
                "message" => "Requisitos obtenidos con exito",
                "requisitos" => $arrayRequisitos
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

    public function guardarNuevoRequisito(Request $request)
    {
        $exito = false;

        DB::beginTransaction();

        try {
            $requisito = new Requisito;
            $requisito->id = $request->id;
            $requisito->nombre = $request->nombre;
            $requisito->tipo_tramite_id = $request->tipo_tramite_id;

            $requisito->save();

            $requisitos = Requisito::where('status',1)->get();

            $arrayRequisitos = array();
            foreach ($requisitos as $requsito) 
            {
                $objetoRequisito = new \stdClass();
                $objetoRequisito->id = $requsito->id;
                $objetoRequisito->nombre = $requsito->nombre;
                $objetoRequisito->tipo_tramite = $requsito->tipo_tramite_id;

                array_push($arrayRequisitos,$objetoRequisito);
            }

            DB::commit();
            $exito = true;
        } catch (\Throwable $th) {
            DB::rollback();
            $exito = false;
            return response()->json([
                "status" => "error",
                "message" => "Ocurrió un error al agregar un requisito nuevo.",
                "error" => $th->getMessage(),
                "location" => $th->getFile(),
                "line" => $th->getLine(),
            ], 200);
        }

        if ($exito) {
            return response()->json([
                "status" => "ok",
                "message" => "Nuevo Requisito agregado con exito.",
                "requisitos" => $arrayRequisitos
            ], 200);
        }
    }

    public function actualizarRequisito(Request $request)
    {
        $exito = false;

        DB::beginTransaction();

        try {
            $requisito = Requisito::find($request->id);
            $requisito->nombre = $request->nombre;
            $requisito->tipo_tramite_id = $request->tipo_tramite_id;
            $requisito->save();

            $requisitos = Requisito::where('status',1)->get();

            $arrayRequisitos = array();
            foreach ($requisitos as $requsito) 
            {
                $objetoRequisito = new \stdClass();
                $objetoRequisito->id = $requsito->id;
                $objetoRequisito->nombre = $requsito->nombre;
                $objetoRequisito->tipo_tramite = $requsito->tipo_tramite_id;

                array_push($arrayRequisitos,$objetoRequisito);
            }

            DB::commit();
            $exito = true;

        } catch (\Throwable $th) {
            DB::rollback();
            $exito = false;
            return response()->json([
                "status" => "error",
                "message" => "Ocurrió un error al actualizar requisito nuevo.",
                "req" => $requisito,
                "error" => $th->getMessage(),
                "location" => $th->getFile(),
                "line" => $th->getLine(),
            ], 200);
        }

        if ($exito) {
            return response()->json([
                "status" => "ok",
                "message" => "Requisito actualizado con exito.",
                "requisitos" => $arrayRequisitos
            ], 200);
        }
    }

    public function eliminarRequisito(Request $request)
    {
        $exito = false;

        DB::beginTransaction();
        
        try {
            $requisito = Requisito::find($request->id);
            $requisito->status = false;
            $requisito->save();

            $requisitos = Requisito::where('status',1)->get();

            $arrayRequisitos = array();
            foreach ($requisitos as $requsito) 
            {
                $objetoRequisito = new \stdClass();
                $objetoRequisito->id = $requsito->id;
                $objetoRequisito->nombre = $requsito->nombre;
                $objetoRequisito->tipo_tramite = $requsito->tipo_tramite_id;

                array_push($arrayRequisitos,$objetoRequisito);
            }

            DB::commit();
            $exito = true;


        } catch (\Throwable $th) {
            DB::rollback();
            $exito = false;
            return response()->json([
                "status" => "error",
                "message" => "Ocurrió un error al eliminar requisito.",
                "error" => $th->getMessage(),
                "location" => $th->getFile(),
                "line" => $th->getLine(),
            ], 200);
        }

        if ($exito) {
            return response()->json([
                "status" => "ok",
                "message" => "Requisito eliminado con exito.",
                "requisitos" => $arrayRequisitos
            ], 200);
        }
    }
}
