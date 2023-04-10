<?php

namespace App\Http\Controllers;

use App\Models\Juzgado;
use Illuminate\Http\Request;

class JuzgadoController extends Controller
{
    public function getJuzgados()
    {
        try {
            $juzgados = Juzgado::where('status', 1)->get();
            $array_juzgados = array();
            foreach ($juzgados as $juzgado) {
                $object = new \stdClass();
                $object->id = $juzgado->id;
                $object->nombre = $juzgado->nombre;
                $object->materia_id = $juzgado->materia_id;
                
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
}
