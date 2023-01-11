<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nota;
use Illuminate\Support\Facades\DB;

class NotaController extends Controller
{
    public function getNota(){
        try {
            $notas = Nota::all();
             
            $array_nota = array();
            $cont = 1;
            foreach ($notas as $nota) {
                $objectNota = new \stdClass();
                $objectNota->id = $nota->id;
                $objectNota->numero_registro = $cont;
                $objectNota->nombre = $nota->nombre;
                $objectNota->descripcion = $nota->descripcion;
                array_push($array_nota, $objectNota);
                $cont++;
            }

            return response()->json([
                "status" => "ok",
                "message" => "Notas obtenidas con exito",
                "notas" => $array_nota
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => "error",
                "message" => "Ocurrió un error al obtener el catalogo de notas",
                "error" => $th->getMessage(),
                "location" => $th->getFile(),
                "line" => $th->getLine(),
            ], 200);
        }
    }
    public function guardarNuevaNota(Request $request)
    {
        $exito = false;

        DB::beginTransaction();
        try {
            $nota = new Nota;
            $nota->nombre = $request->nombre;
            $nota->descripcion = $request->descripcion;
            $nota->save();


            $notas = Nota::where('status', 1)->get();
             
            $array_nota = array();
            foreach ($notas as $nota) {
                $objectNota = new \stdClass();
                $objectNota->id = $nota->id;
                $objectNota->nombre = $nota->nombre;
                $objectNota->descripcion = $nota->descripcion;
                array_push($array_nota, $objectNota);
            }


            DB::commit();
            $exito = true;
        } catch (\Throwable $th) {
            DB::rollback();
            $exito = false;
            return response()->json([
                "status" => "error",
                "message" => "Ocurrió un error al generar la nueva nota.",
                "error" => $th->getMessage(),
                "location" => $th->getFile(),
                "line" => $th->getLine(),
            ], 200);
        }

        if ($exito) {
            return response()->json([
                "status" => "ok",
                "message" => "Nuevo nota guardada con exito.",
                "notas" => $array_nota
            ], 200);
        }
    }
    public function actualizarNota(Request $request)
    {
        $exito = false;

        DB::beginTransaction();
        try {
            $nota = Nota::find($request->id);
            $nota->nombre = $request->nombre;
            $nota->descripcion = $request->descripcion;
            $nota->save();

            
            $notas = Nota::where('status', 1)->get();

            $array_nota = array();
            foreach ($notas as $nota) {
                $objectNota = new \stdClass();
                $objectNota->id = $nota->id;
                $objectNota->nombre = $nota->nombre;
                $objectNota->descripcion = $nota->descripcion;
                array_push($array_nota, $objectNota);
            }
            
            DB::commit();
            $exito = true;
        } catch (\Throwable $th) {
            DB::rollback();
            $exito = false;
            return response()->json([
                "status" => "error",
                "message" => "Ocurrió un error al actualizar los datos de la nota.",
                "error" => $th->getMessage(),
                "location" => $th->getFile(),
                "line" => $th->getLine(),
            ], 200);
        }

        if ($exito) {
            return response()->json([
                "status" => "ok",
                "message" => "Nota actualizada con exito.",
                "notas" => $array_nota
            ], 200);
        }
    }
    public function eliminarNota(Request $request)
    {
        $exito = false;

        DB::beginTransaction();
        try {
            $nota = Nota::find($request->id);
            $nota->status = false;
            $nota->save();

            $notas = Nota::where('status', 1)->get();

            $array_nota = array();
            foreach ($notas as $nota) {
                $objectNota = new \stdClass();
                $objectNota->id = $nota->id;
                $objectNota->nombre = $nota->nombre;
                $objectNota->descripcion = $nota->descripcion;
                array_push($array_nota, $objectNota);
            }

            DB::commit();
            $exito = true;
        } catch (\Throwable $th) {
            DB::rollback();
            $exito = false;
            return response()->json([
                "status" => "error",
                "message" => "Ocurrió un error al eliminar esta nota.",
                "error" => $th->getMessage(),
                "location" => $th->getFile(),
                "line" => $th->getLine(),
            ], 200);
        }

        if ($exito) {
            return response()->json([
                "status" => "ok",
                "message" => "Nota eliminada con exito.",
                "notas" => $array_nota
            ], 200);
        }
    }
}
