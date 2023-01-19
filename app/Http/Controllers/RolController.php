<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rol;
use Illuminate\Support\Facades\DB;

class RolController extends Controller
{
    public function getRoles(){
        try {
            $Roles = Rol::all();
             
            $array_Roles = array();
            foreach ($Roles as $Rol) {
                $objectRol = new \stdClass();
                $objectRol->rol_id = $Rol->id;
                $objectRol->nombre = $Rol->nombre;
                $objectRol->nivel = $Rol->nivel;
                array_push($array_Roles, $objectRol);
            }

            return response()->json([
                "status" => "ok",
                "message" => "Roles obtenidos con éxito",
                "roles" => $array_Roles
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => "error",
                "message" => "Ocurrió un error al obtener el catalogo de Roles",
                "error" => $th->getMessage(),
                "location" => $th->getFile(),
                "line" => $th->getLine(),
            ], 200);
        }
    }
}
