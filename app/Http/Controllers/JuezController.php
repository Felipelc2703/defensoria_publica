<?php

namespace App\Http\Controllers;

use App\Models\Juez;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JuezController extends Controller
{
    public function getJueces()
    {
        try {
            $jueces = Juez::where('status', 1)->get();
            $array_jueces = array();
            $cont =1;
            foreach ($jueces as $juez) {
                $object = new \stdClass();
                $object->id = $juez->id;
                $nombre = $juez->nombre;
                $apellidop = $juez->apellido_paterno;
                $apellidom = $juez->apellido_materno;
                $object-> apellidop = $juez->apellido_paterno;
                $object-> apellidom = $juez->apellido_materno;
                $object-> nombre = $juez->nombre;
                $object->num_registro = $cont;
                $object->nombrecompleto = $nombre.' '.$apellidop.' '.$apellidom;
                
                $object->juzgado_id = $juez->juzgado_id;
                $object->juzgado = $juez->juzgado->nombre;
                
              
                    array_push($array_jueces, $object);
               
                $cont++;
            }
            
            return response()->json([
                "status" => "ok",
                "message" => "Catalogo de jueces obtenido con éxito.",
                "jueces" => $array_jueces
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => "error",
                "message" => "Ocurrió un error al obtener el catalogo de jueces.",
                "error" => $th->getMessage(),
                "location" => $th->getFile(),
                "line" => $th->getLine(),
            ], 200);
        }
    }

    public function guardarJuez(Request $request)
    {
        $exito = false;

        DB::beginTransaction();
        try {
            $juez = new Juez;
            $juez->nombre = $request->nombre;
            $juez->apellido_paterno = $request->apellido_paterno;
            $juez->apellido_materno = $request->apellido_materno;
            $juez->juzgado_id = $request->juzgado_id;
            $juez->save();

            DB::commit();
            $exito = true;

            $jueces = Juez::where('status', 1)->get();
            $array_jueces = array();
            $cont =1;
            foreach ($jueces as $juez) {
                $object = new \stdClass();
                $object->id = $juez->id;
                $nombre = $juez->nombre;
                $apellidop = $juez->apellido_paterno;
                $apellidom = $juez->apellido_materno;
                $object-> apellidop = $juez->apellido_paterno;
                $object-> apellidom = $juez->apellido_materno;
                $object-> nombre = $juez->nombre;
                $object->num_registro = $cont;
                $object->nombrecompleto = $nombre.' '.$apellidop.' '.$apellidom;
                
                $object->juzgado_id = $juez->juzgado_id;
                $object->juzgado = $juez->juzgado->nombre;
                

                    array_push($array_jueces, $object);
               
                $cont++;
            }
        } catch (\Throwable $th) {
            DB::rollback();
            $exito = false;
            return response()->json([
                "status" => "error",
                "message" => "Ocurrió un error al guardar el nuevo juez.",
                "error" => $th->getMessage(),
                "location" => $th->getFile(),
                "line" => $th->getLine(),
            ], 200);
        }

        if ($exito) {
            return response()->json([
                "status" => "ok",
                "message" => "Nuevo juez guardado con éxito.",
                "jueces" => $array_jueces
            ], 200);
        }
    }

    public function actualizarJuez(Request $request)
    {
        $exito = false;

        DB::beginTransaction();
        try {
            $juez = Juez::find($request->id);
            $juez->nombre = $request->nombre;
            $juez->apellido_paterno = $request->apellido_paterno;
            $juez->apellido_materno = $request->apellido_materno;
            $juez->juzgado_id = $request->juzgado_id;
            $juez->save();

            $jueces = Juez::where('status', 1)->get();
            $array_jueces = array();
            $cont =1;
            foreach ($jueces as $juez) {
                $object = new \stdClass();
                $object->id = $juez->id;
                $nombre = $juez->nombre;
                $apellidop = $juez->apellido_paterno;
                $apellidom = $juez->apellido_materno;
                $object-> apellidop = $juez->apellido_paterno;
                $object-> apellidom = $juez->apellido_materno;
                $object-> nombre = $juez->nombre;
                $object->num_registro = $cont;
                $object->nombrecompleto = $nombre.' '.$apellidop.' '.$apellidom;
                
                $object->juzgado_id = $juez->juzgado_id;
                $object->juzgado = $juez->juzgado->nombre;
                

                    array_push($array_jueces, $object);
               
                $cont++;
            }
           

            DB::commit();
            $exito = true;
        
        } catch (\Throwable $th) {
            DB::rollback();
            $exito = false;
            return response()->json([
                "status" => "error",
                "message" => "Ocurrió un error al actualizar los datos del juez.",
                "error" => $th->getMessage(),
                "location" => $th->getFile(),
                "line" => $th->getLine(),
            ], 200);
        }

        if ($exito) {
            return response()->json([
                "status" => "ok",
                "message" => "Juez actualizado con éxito.",
                "jueces" => $array_jueces
            ], 200);
        }


    }

    public function eliminarJuez(Request $request)
    {
        $exito = false;

        DB::beginTransaction();
        try {
            $juez = Juez::find($request->id);
            $juez->status = false;
            $juez->save();

            $jueces = Juez::where('status', 1)->get();
            $array_jueces = array();
            $cont =1;
            foreach ($jueces as $juez) {
                $object = new \stdClass();
                $object->id = $juez->id;
                $nombre = $juez->nombre;
                $apellidop = $juez->apellido_paterno;
                $apellidom = $juez->apellido_materno;
                $object-> apellidop = $juez->apellido_paterno;
                $object-> apellidom = $juez->apellido_materno;
                $object-> nombre = $juez->nombre;
                $object->num_registro = $cont;
                $object->nombrecompleto = $nombre.' '.$apellidop.' '.$apellidom;
                
                $object->juzgado_id = $juez->juzgado_id;
                $object->juzgado = $juez->juzgado->nombre;
                

                    array_push($array_jueces, $object);
               
                $cont++;
            }

            DB::commit();
            $exito = true;
        }catch (\Throwable $th) {
            DB::rollback();
            $exito = false;
            return response()->json([
                "status" => "error",
                "message" => "Ocurrió un error al eliminar a este juez.",
                "error" => $th->getMessage(),
                "location" => $th->getFile(),
                "line" => $th->getLine(),
            ], 200);
        }

        if ($exito) {
            return response()->json([
                "status" => "ok",
                "message" => "Juez eliminado con éxito.",
                "jueces" => $array_jueces
            ], 200);
        }
    }


}
