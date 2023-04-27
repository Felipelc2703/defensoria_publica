<?php

namespace App\Http\Controllers;

use App\Models\Juzgado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JuzgadoController extends Controller
{
    public function getJuzgados()
    {
        try {
            $juzgados = Juzgado::where('status', 1)->get();
            $array_juzgados = array();
            $cont =1;
            foreach ($juzgados as $juzgado) {
                $object = new \stdClass();
                $object->id = $juzgado->id;
                $object->prefijo = $juzgado->prefijo_folio;
                $object->num_registro = $cont;
                $object->nombre = $juzgado->nombre;
                $object->direccion = $juzgado->direccion;
                $object->materia_id = $juzgado->materia_id;
                $object->materia = $juzgado->materia->nombre;
                
                $jueces = $juzgado->jueces;
                $array_jueces = array();
                foreach ($jueces as $juez) {
                    $objectJuez = new \stdClass();
                    $objectJuez->id = $juez->id;
                    $objectJuez->nombre_completo = $juez->nombre . ' ' . $juez->apellido_paterno . ' ' . $juez->apellido_materno;

                    array_push($array_jueces, $objectJuez);
                }

                $object->jueces = $array_jueces;
                
                array_push($array_juzgados, $object);
                $cont++;
            }
            
            return response()->json([
                "status" => "ok",
                "message" => "Catalogo de juzgados para agendar citas obtenido con éxito.",
                "juzgados" => $array_juzgados
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => "error",
                "message" => "Ocurrió un error al obtener el catalogo de juzgados para agendar citas.",
                "error" => $th->getMessage(),
                "location" => $th->getFile(),
                "line" => $th->getLine(),
            ], 200);
        }
    }
    public function guardarJuzgado(Request $request)
    {
        $exito = false;

        DB::beginTransaction();
        try {
            $juzgado = new Juzgado;
            $juzgado->nombre = $request->nombre;
            $juzgado->prefijo_folio = $request->prefijo;
            $juzgado->direccion = $request->direccion;
            $juzgado->materia_id = $request->materia_id;
            $juzgado->save();

            DB::commit();
            $exito = true;

            $juzgados = Juzgado::where('status', 1)->get();
            $array_juzgados = array();
            $cont =1;
            foreach ($juzgados as $juzgado) {
                $object = new \stdClass();
                $object->id = $juzgado->id;
                $object->prefijo = $juzgado->prefijo_folio;
                $object->num_registro = $cont;
                $object->nombre = $juzgado->nombre;
                $object->direccion = $juzgado->direccion;
                $object->materia_id = $juzgado->materia_id;
                $object->materia = $juzgado->materia->nombre;
                
                             
                array_push($array_juzgados, $object);
                $cont++;
            }
        } catch (\Throwable $th) {
            DB::rollback();
            $exito = false;
            return response()->json([
                "status" => "error",
                "message" => "Ocurrió un error al guardar el nuevo juzgado.",
                "error" => $th->getMessage(),
                "location" => $th->getFile(),
                "line" => $th->getLine(),
            ], 200);
        }

        if ($exito) {
            return response()->json([
                "status" => "ok",
                "message" => "Nuevo juzgado guardado con éxito.",
                "juzgados" => $array_juzgados
            ], 200);
        }
    }

    public function actualizarJuzgado(Request $request)
    {
        $exito = false;

        DB::beginTransaction();
        try {
            $juzgado = Juzgado::find($request->id);
            $juzgado->nombre = $request->nombre;
            $juzgado->prefijo_folio = $request->prefijo;
            $juzgado->direccion = $request->direccion;
            $juzgado->materia_id = $request->materia_id;
            $juzgado->save();

            $juzgados = Juzgado::where('status', 1)->get();
            $array_juzgados = array();
            $cont =1;
            foreach ($juzgados as $juzgado) {
                $object = new \stdClass();
                $object->id = $juzgado->id;
                $object->prefijo = $juzgado->prefijo_folio;
                $object->num_registro = $cont;
                $object->nombre = $juzgado->nombre;
                $object->direccion = $juzgado->direccion;
                $object->materia_id = $juzgado->materia_id;
                $object->materia = $juzgado->materia->nombre;
                
                             
                array_push($array_juzgados, $object);
                $cont++;
            }

            DB::commit();
            $exito = true;
        
        } catch (\Throwable $th) {
            DB::rollback();
            $exito = false;
            return response()->json([
                "status" => "error",
                "message" => "Ocurrió un error al actualizar los datos del juzgado.",
                "error" => $th->getMessage(),
                "location" => $th->getFile(),
                "line" => $th->getLine(),
            ], 200);
        }

        if ($exito) {
            return response()->json([
                "status" => "ok",
                "message" => "Juzgado actualizado con éxito.",
                "juzgados" => $array_juzgados
            ], 200);
        }


    }

    public function eliminarJuzgado(Request $request)
    {
        $exito = false;

        DB::beginTransaction();
        try {
            $juzgado = Juzgado::find($request->id);
            $juzgado->status = false;
            $juzgado->save();

            $juzgados = Juzgado::where('status', 1)->get();
            $array_juzgados = array();
            $cont =1;
            foreach ($juzgados as $juzgado) {
                $object = new \stdClass();
                $object->id = $juzgado->id;
                $object->prefijo = $juzgado->prefijo_folio;
                $object->num_registro = $cont;
                $object->nombre = $juzgado->nombre;
                $object->direccion = $juzgado->direccion;
                $object->materia_id = $juzgado->materia_id;
                $object->materia = $juzgado->materia->nombre;
                
                             
                array_push($array_juzgados, $object);
                $cont++;
            }

            DB::commit();
            $exito = true;
        }catch (\Throwable $th) {
            DB::rollback();
            $exito = false;
            return response()->json([
                "status" => "error",
                "message" => "Ocurrió un error al eliminar a este juzgado.",
                "error" => $th->getMessage(),
                "location" => $th->getFile(),
                "line" => $th->getLine(),
            ], 200);
        }

        if ($exito) {
            return response()->json([
                "status" => "ok",
                "message" => "Juzgado eliminado con éxito.",
                "juzgados" => $array_juzgados
            ], 200);
        }
    }
}
