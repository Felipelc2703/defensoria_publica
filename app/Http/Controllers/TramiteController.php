<?php

namespace App\Http\Controllers;

use App\Models\Tramite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TramiteController extends Controller
{
    public function getTramites()
    {
        try {
            $tramites = Tramite::all();

            $arrayTramites = array();
            foreach($tramites as $tramite)
            {
                foreach($tramites as $tramite)
                {
                    $objectTramite = new \stdClass();
                    $objectTramite->id = $tramite->id;
                    $objectTramite->nombre = $tramite->nombre;
                    $objectTramite->descripcion = $tramite->descripcion;
                    $objectTramite->url_informacion = $tramite->url_informacion;
                    $objectTramite->tipo_tramite_id = $tramite->tipo_tramite_id;

                    array_push($arrayTramites,$objectTramite);
                }
            }

            return response()->json([
                "status" => "ok",
                "message" => "Tramites obtenidos con exito",
                "tramites" => $arrayTramites
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => "error",
                "message" => "Ocurrió un error al obtener el catalogo de tramites",
                "error" => $th->getMessage(),
                "location" => $th->getFile(),
                "line" => $th->getLine(),
            ], 200);
        }
    }

    public function getTramitesCitas()
    {
        try {
            $tramites1 = Tramite::where('tipo_tramite_id', 1)->get();
            $tramites_tipo_1 = array();
            foreach ($tramites1 as $tramite) {
                $object = new \stdClass();
                $object->id = $tramite->id;
                $object->nombre = $tramite->nombre;
                $object->descripcion = $tramite->descripcion;
                
                $requisitos = array();
                foreach ($tramite->requisitos as $requisito) {
                    $object2 = new \stdClass();
                    $object2->id = $requisito->id;
                    $object2->nombre = $requisito->nombre;
                    $object2->obligatorio = $requisito->pivot->obligatorio;
                    $object2->checked = '0';
                    array_push($requisitos, $object2);
                }

                $object->requisitos = $requisitos;

                array_push($tramites_tipo_1, $object);
            }

            $tramites2 = Tramite::where('tipo_tramite_id', 2)->get();
            $tramites_tipo_2 = array();
            foreach ($tramites2 as $tramite) {
                $object = new \stdClass();
                $object->id = $tramite->id;
                $object->nombre = $tramite->nombre;
                $object->descripcion = $tramite->descripcion;
                
                $requisitos = array();
                foreach ($tramite->requisitos as $requisito) {
                    $object2 = new \stdClass();
                    $object2->id = $requisito->id;
                    $object2->nombre = $requisito->nombre;
                    $object2->obligatorio = $requisito->pivot->obligatorio;
                    $object2->checked = '0';
                    array_push($requisitos, $object2);
                }

                $object->requisitos = $requisitos;

                array_push($tramites_tipo_2, $object);
            }

            $tramites3 = Tramite::where('tipo_tramite_id', 3)->get();
            $tramites_tipo_3 = array();
            foreach ($tramites3 as $tramite) {
                $object = new \stdClass();
                $object->id = $tramite->id;
                $object->nombre = $tramite->nombre;
                $object->descripcion = $tramite->descripcion;
                
                $requisitos = array();
                foreach ($tramite->requisitos as $requisito) {
                    $object2 = new \stdClass();
                    $object2->id = $requisito->id;
                    $object2->nombre = $requisito->nombre;
                    $object2->obligatorio = $requisito->pivot->obligatorio;
                    $object2->checked = '0';
                    array_push($requisitos, $object2);
                }

                $object->requisitos = $requisitos;

                array_push($tramites_tipo_3, $object);
            }

            $tramites4 = Tramite::where('tipo_tramite_id', 4)->get();
            $tramites_tipo_4 = array();
            foreach ($tramites4 as $tramite) {
                $object = new \stdClass();
                $object->id = $tramite->id;
                $object->nombre = $tramite->nombre;
                $object->descripcion = $tramite->descripcion;
                
                $requisitos = array();
                foreach ($tramite->requisitos as $requisito) {
                    $object2 = new \stdClass();
                    $object2->id = $requisito->id;
                    $object2->nombre = $requisito->nombre;
                    $object2->obligatorio = $requisito->pivot->obligatorio;
                    $object2->checked = '0';
                    array_push($requisitos, $object2);
                }

                $object->requisitos = $requisitos;

                array_push($tramites_tipo_4, $object);
            }

            return response()->json([
                "status" => "ok",
                "message" => "Catalogo de tramites para agendar citas obtenido con exito.",
                "tramites_tipo_1" => $tramites_tipo_1,
                "tramites_tipo_2" => $tramites_tipo_2,
                "tramites_tipo_3" => $tramites_tipo_3,
                "tramites_tipo_4" => $tramites_tipo_4,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => "error",
                "message" => "Ocurrió un error al obtener el catalogo de tramites para agendar citas.",
                "error" => $th->getMessage(),
                "location" => $th->getFile(),
                "line" => $th->getLine(),
            ], 200);
        }
    }

    public function guardarNuevoTramite(Request $request)
    {
        $exito = false;

        DB::beginTransaction();

        try {
            $tramite = new Tramite;
            $tramite->nombre = $request->nombre;
            $tramite->descripcion = $request->descripcion;
            $tramite->url_informacion = $request->url;
            $tramite->tipo_tramite_id = $request->tipo_tramite_id;
            $tramite->save();

            $tramites = Tramite::all();

            $arrayTramites = array();
            foreach($tramites as $tramite)
            {
                foreach($tramites as $tramite)
                {
                    $objectTramite = new \stdClass();
                    $objectTramite->id = $tramite->id;
                    $objectTramite->nombre = $tramite->nombre;
                    $objectTramite->descripcion = $tramite->descripcion;
                    $objectTramite->url_informacion = $tramite->url_informacion;
                    $objectTramite->tipo_tramite_id = $tramite->tipo_tramite_id;

                    array_push($arrayTramites,$objectTramite);
                }
            }

            DB::commit();
            $exito = true;

        } catch (\Throwable $th) {
            return response()->json([
                "status" => "error",
                "message" => "Ocurrió un error guardar nuevo tramite",
                "error" => $th->getMessage(),
                "location" => $th->getFile(),
                "line" => $th->getLine(),
            ], 200);
        }

        if ($exito) {
            return response()->json([
                "status" => "ok",
                "message" => "Nuevo Tramite agregado con exito.",
                "tramites" => $arrayTramites
            ], 200);
        }
    }
    public function actualizarTramite(Request $request)
    {

        $exito = false;
        DB::beginTransaction();
        try {
            $tramite = Tramite::find($request->id);
            $tramite->nombre = $request->nombre;
            $tramite->descripcion = $request->descripcion;
            $tramite->url_informacion = $request->url;
            $tramite->tipo_tramite_id = $request->tipo_tramite_id;
            $tramite->save();

            $tramites = Tramite::all();

            $arrayTramites = array();
            foreach($tramites as $tramite)
            {
                foreach($tramites as $tramite)
                {
                    $objectTramite = new \stdClass();
                    $objectTramite->id = $tramite->id;
                    $objectTramite->nombre = $tramite->nombre;
                    $objectTramite->descripcion = $tramite->descripcion;
                    $objectTramite->url_informacion = $tramite->url_informacion;
                    $objectTramite->tipo_tramite_id = $tramite->tipo_tramite_id;

                    array_push($arrayTramites,$objectTramite);
                }
            }

            DB::commit();
            $exito = true;
        }catch (\Throwable $th) {
            DB::rollback();
            $exito = false;
            return response()->json([
                "status" => "error",
                "message" => "Ocurrió un error al actualizar tramite.",
                "error" => $th->getMessage(),
                "location" => $th->getFile(),
                "line" => $th->getLine(),
            ], 200);
        }
        if ($exito) {
            return response()->json([
                "status" => "ok",
                "message" => "Tramite actualizado con exito.",
                "tramites" => $arrayTramites
            ], 200);
        }
    }


}
