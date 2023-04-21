<?php

namespace App\Http\Controllers;

use App\Models\Materia;
use Illuminate\Http\Request;

class MateriaController extends Controller
{
    public function getMaterias()
    {
        try {
            $materias = Materia::all();
            $array_materias = array();
            // $cont =1;
            foreach ($materias as $materia) {
                $object = new \stdClass();
                $object->id = $materia->id;
                $object->nombre = $materia->nombre;
              
                
                array_push($array_materias, $object);
              
            }
            
            return response()->json([
                "status" => "ok",
                "message" => "Materias obtenidas con éxito.",
                "materias" => $array_materias
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => "error",
                "message" => "Ocurrió un error al obtener las materias.",
                "error" => $th->getMessage(),
                "location" => $th->getFile(),
                "line" => $th->getLine(),
            ], 200);
        }
    }

}
