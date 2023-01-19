<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TipoTramite;

class TipoTramiteController extends Controller
{
    public function getTipoTramite()
    {
        try {
            $tipoTramites = TipoTramite::all();

            $arrayTipoTramites = array();

            foreach($tipoTramites as $tipo)
            {
                $objectTipoTramite = new \stdClass();
                $objectTipoTramite->id = $tipo->id;
                $objectTipoTramite->nombre = $tipo->nombre;

                array_push($arrayTipoTramites,$objectTipoTramite);
            }

            return response()->json([
                "status" => "ok",
                "message" => "Tipos de tramite obtenidos con éxito",
                "tiposTramites" => $arrayTipoTramites
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                "status" => "error",
                "message" => "Ocurrió un error al obtener el catalogo de tipos de tramite",
                "error" => $th->getMessage(),
                "location" => $th->getFile(),
                "line" => $th->getLine(),
            ], 200);
        }
    }
}
