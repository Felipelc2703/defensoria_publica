<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CentroAtencion;
use Illuminate\Support\Facades\DB;

class CentroAtencionController extends Controller
{
    public function getCentrosAtencion()
    {
        try {
            $centros = CentroAtencion::where('status', 1)->get();
             
            $array_centros = array();
            
            foreach ($centros as $centro) {
                $objectCentro = new \stdClass();
                $objectCentro->id = $centro->id;
                $objectCentro->nombre = $centro->nombre;
                $objectCentro->direccion = $centro->direccion;
                $objectCentro->telefono = $centro->telefono;
                $objectCentro->numero_cajas = $centro->numero_cajas;
                $tramites = array();
                foreach ($centro->tramites as $tramite) {
                    array_push($tramites, $tramite->id);
                }
                $objectCentro->tramites = $tramites;

                array_push($array_centros, $objectCentro);
            }

            return response()->json([
                "status" => "ok",
                "message" => "Centros de atención obtenidos con exito",
                "centros_atencion" => $array_centros
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => "error",
                "message" => "Ocurrió un error al obtener el catalogo de centros de atención",
                "error" => $th->getMessage(),
                "location" => $th->getFile(),
                "line" => $th->getLine(),
            ], 200);
        }
    }

    public function guardarNuevoCentro(Request $request)
    {
        $exito = false;

        DB::beginTransaction();
        try {
            $centro = new CentroAtencion;
            $centro->nombre = $request->nombre;
            $centro->direccion = $request->direccion;
            $centro->telefono = $request->telefono;
            $centro->numero_cajas = $request->numero_cajas;
            $centro->save();

            foreach ($request->tramites as $id_tramite) {
                $centro->tramites()->attach($id_tramite);
            }

            $centros = CentroAtencion::where('status', 1)->get();

            $array_centros = array();
            foreach ($centros as $centro) {
                $objectCentro = new \stdClass();
                $objectCentro->id = $centro->id;
                $objectCentro->nombre = $centro->nombre;
                $objectCentro->direccion = $centro->direccion;
                $objectCentro->telefono = $centro->telefono;
                $objectCentro->numero_cajas = $centro->numero_cajas;
                $tramites = array();
                foreach ($centro->tramites as $tramite) {
                    array_push($tramites, $tramite->id);
                }
                $objectCentro->tramites = $tramites;

                array_push($array_centros, $objectCentro);
            }

            DB::commit();
            $exito = true;
        } catch (\Throwable $th) {
            DB::rollback();
            $exito = false;
            return response()->json([
                "status" => "error",
                "message" => "Ocurrió un error al generar nuevo centro de atención.",
                "error" => $th->getMessage(),
                "location" => $th->getFile(),
                "line" => $th->getLine(),
            ], 200);
        }

        if ($exito) {
            return response()->json([
                "status" => "ok",
                "message" => "Nuevo Centro de Atención guardado con exito.",
                "centros_atencion" => $array_centros
            ], 200);
        }
    }

    public function actualizarCentroAtencion(Request $request)
    {
        $exito = false;

        DB::beginTransaction();
        try {
            $centro = CentroAtencion::find($request->id);
            $centro->nombre = $request->nombre;
            $centro->direccion = $request->direccion;
            $centro->telefono = $request->telefono;
            $centro->numero_cajas = $request->numero_cajas;
            $centro->save();

            $tramites_antiguos = $centro->tramites;
            foreach ($tramites_antiguos as $tramite) {
                $centro->tramites()->detach($tramite);
            }

            foreach ($request->tramites as $id_tramite) {
                $centro->tramites()->attach($id_tramite);
            }

            $centros = CentroAtencion::where('status', 1)->get();

            $array_centros = array();
            foreach ($centros as $centro) {
                $objectCentro = new \stdClass();
                $objectCentro->id = $centro->id;
                $objectCentro->nombre = $centro->nombre;
                $objectCentro->direccion = $centro->direccion;
                $objectCentro->telefono = $centro->telefono;
                $objectCentro->numero_cajas = $centro->numero_cajas;
                $tramites = array();
                foreach ($centro->tramites as $tramite) {
                    array_push($tramites, $tramite->id);
                }
                $objectCentro->tramites = $tramites;

                array_push($array_centros, $objectCentro);
            }
            
            DB::commit();
            $exito = true;
        } catch (\Throwable $th) {
            DB::rollback();
            $exito = false;
            return response()->json([
                "status" => "error",
                "message" => "Ocurrió un error al actualizar centro de atención.",
                "error" => $th->getMessage(),
                "location" => $th->getFile(),
                "line" => $th->getLine(),
            ], 200);
        }

        if ($exito) {
            return response()->json([
                "status" => "ok",
                "message" => "Centro de Atención actualizado con exito.",
                "centros_atencion" => $array_centros
            ], 200);
        }
    }

    public function eliminarCentroAtencion(Request $request)
    {
        $exito = false;

        DB::beginTransaction();
        try {
            $centro = CentroAtencion::find($request->id);
            $centro->status = false;
            $centro->save();

            $centros = CentroAtencion::where('status', 1)->get();

            $array_centros = array();
            foreach ($centros as $centro) {
                $objectCentro = new \stdClass();
                $objectCentro->id = $centro->id;
                $objectCentro->nombre = $centro->nombre;
                $objectCentro->direccion = $centro->direccion;
                $objectCentro->telefono = $centro->telefono;
                $objectCentro->numero_cajas = $centro->numero_cajas;
                $tramites = array();
                foreach ($centro->tramites as $tramite) {
                    array_push($tramites, $tramite->id);
                }
                $objectCentro->tramites = $tramites;

                array_push($array_centros, $objectCentro);
            }

            DB::commit();
            $exito = true;
        } catch (\Throwable $th) {
            DB::rollback();
            $exito = false;
            return response()->json([
                "status" => "error",
                "message" => "Ocurrió un error al eliminar centro de atención.",
                "error" => $th->getMessage(),
                "location" => $th->getFile(),
                "line" => $th->getLine(),
            ], 200);
        }

        if ($exito) {
            return response()->json([
                "status" => "ok",
                "message" => "Centro de Atención eliminado con exito.",
                "centros_atencion" => $array_centros
            ], 200);
        }
    }
}
