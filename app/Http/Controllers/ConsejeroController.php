<?php

namespace App\Http\Controllers;

use App\Models\Consejero;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConsejeroController extends Controller
{
    public function getConsejeros()
    {
        try {
            $consejeros = Consejero::where('status', 1)->get();
            $array_consejeros = array();
            $cont =1;
            foreach ($consejeros as $consejero) {
                $object = new \stdClass();
                $object->id = $consejero->id;
                $nombre = $consejero->nombre;
                $apellidop = $consejero->apellido_paterno;
                $apellidom = $consejero->apellido_materno;
                $object-> apellidop = $consejero->apellido_paterno;
                $object-> apellidom = $consejero->apellido_materno;
                $object-> nombre = $consejero->nombre;
                $object->num_registro = $cont;
                $object->nombrecompleto = $nombre.' '.$apellidop.' '.$apellidom;
                array_push($array_consejeros, $object);
                $cont++;
            }
            
            return response()->json([
                "status" => "ok",
                "message" => "Consejeros obtenidos con éxito.",
                "consejeros" => $array_consejeros
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => "error",
                "message" => "Ocurrió un error al obtener los consejeros.",
                "error" => $th->getMessage(),
                "location" => $th->getFile(),
                "line" => $th->getLine(),
            ], 200);
        }
    }

    public function guardarConsejero(Request $request)
    {
        $exito = false;

        DB::beginTransaction();
        try {
            $consejero = new Consejero;
            $consejero->nombre = $request->nombre;
            $consejero->apellido_paterno = $request->apellido_paterno;
            $consejero->apellido_materno = $request->apellido_materno;
            $consejero->save();

            DB::commit();
            $exito = true;

            $consejeros = Consejero::where('status', 1)->get();
            $array_consejeros = array();
            $cont =1;
            foreach ($consejeros as $consejero) {
                $object = new \stdClass();
                $object->id = $consejero->id;
                $nombre = $consejero->nombre;
                $apellidop = $consejero->apellido_paterno;
                $apellidom = $consejero->apellido_materno;
                $object-> apellidop = $consejero->apellido_paterno;
                $object-> apellidom = $consejero->apellido_materno;
                $object-> nombre = $consejero->nombre;
                $object->num_registro = $cont;
                $object->nombrecompleto = $nombre.' '.$apellidop.' '.$apellidom;
                array_push($array_consejeros, $object);
                $cont++;
            }
        } catch (\Throwable $th) {
            DB::rollback();
            $exito = false;
            return response()->json([
                "status" => "error",
                "message" => "Ocurrió un error al guardar el nuevo consejero.",
                "error" => $th->getMessage(),
                "location" => $th->getFile(),
                "line" => $th->getLine(),
            ], 200);
        }

        if ($exito) {
            return response()->json([
                "status" => "ok",
                "message" => "Nuevo consejero guardado con éxito.",
                "consejeros" => $array_consejeros
            ], 200);
        }
    }
    public function actualizarConsejero(Request $request)
    {
        $exito = false;

        DB::beginTransaction();
        try {
            $consejero = Consejero::find($request->id);
            $consejero->nombre = $request->nombre;
            $consejero->apellido_paterno = $request->apellido_paterno;
            $consejero->apellido_materno = $request->apellido_materno;
            $consejero->save();

            $consejeros = Consejero::where('status', 1)->get();
            $array_consejeros = array();
            $cont =1;
            foreach ($consejeros as $consejero) {
                $object = new \stdClass();
                $object->id = $consejero->id;
                $nombre = $consejero->nombre;
                $apellidop = $consejero->apellido_paterno;
                $apellidom = $consejero->apellido_materno;
                $object-> apellidop = $consejero->apellido_paterno;
                $object-> apellidom = $consejero->apellido_materno;
                $object-> nombre = $consejero->nombre;
                $object->num_registro = $cont;
                $object->nombrecompleto = $nombre.' '.$apellidop.' '.$apellidom;
                array_push($array_consejeros, $object);
                $cont++;
            }

            DB::commit();
            $exito = true;
        
        } catch (\Throwable $th) {
            DB::rollback();
            $exito = false;
            return response()->json([
                "status" => "error",
                "message" => "Ocurrió un error al actualizar los datos del consejero.",
                "error" => $th->getMessage(),
                "location" => $th->getFile(),
                "line" => $th->getLine(),
            ], 200);
        }

        if ($exito) {
            return response()->json([
                "status" => "ok",
                "message" => "Consejero actualizado con éxito.",
                "consejeros" => $array_consejeros
            ], 200);
        }


    }

    public function eliminarConsejero(Request $request)
    {
        $exito = false;

        DB::beginTransaction();
        try {
            $consejero = Consejero::find($request->id);
            $consejero->status = false;
            $consejero->save();

            $consejeros = Consejero::where('status', 1)->get();
            $array_consejeros = array();
            $cont =1;
            foreach ($consejeros as $consejero) {
                $object = new \stdClass();
                $object->id = $consejero->id;
                $nombre = $consejero->nombre;
                $apellidop = $consejero->apellido_paterno;
                $apellidom = $consejero->apellido_materno;
                $object-> apellidop = $consejero->apellido_paterno;
                $object-> apellidom = $consejero->apellido_materno;
                $object-> nombre = $consejero->nombre;
                $object->num_registro = $cont;
                $object->nombrecompleto = $nombre.' '.$apellidop.' '.$apellidom;
                array_push($array_consejeros, $object);
                $cont++;
            }
           
            DB::commit();
            $exito = true;
        }catch (\Throwable $th) {
            DB::rollback();
            $exito = false;
            return response()->json([
                "status" => "error",
                "message" => "Ocurrió un error al eliminar a este consejero.",
                "error" => $th->getMessage(),
                "location" => $th->getFile(),
                "line" => $th->getLine(),
            ], 200);
        }

        if ($exito) {
            return response()->json([
                "status" => "ok",
                "message" => "Consejero eliminado con éxito.",
                "consejeros" => $array_consejeros
            ], 200);
        }
    }

}
