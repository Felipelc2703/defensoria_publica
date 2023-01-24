<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Tramite;
use App\Models\TipoTramite;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Dia;
use App\Models\Horario;
use App\Models\RequisitoTramite;

class TramiteController extends Controller
{
    public function getTramites()
    {
        try {
            $tramites = Tramite::where('status', 1)->get();

            // $tramites = Tramite::all();

            $arrayTramites = array();
            $cont = 1;
            foreach($tramites as $tramite)
            {
                $objectTramite = new \stdClass();
                $objectTramite->id = $tramite->id;
                $objectTramite->numero_registro = $cont;
                $objectTramite->nombre = $tramite->nombre;
                $objectTramite->descripcion = $tramite->descripcion;
                $objectTramite->url_informacion = $tramite->url_informacion;
                $objectTramite->tipo_tramite_id = $tramite->tipo_tramite_id;

                $requisitos = array();

                foreach($tramite->requisitos as $requisito)
                {
                    $objectRequisitoTramite = new \stdClass();
                    $objectRequisitoTramite->id = $requisito->id;
                    $objectRequisitoTramite->nombre = $requisito->nombre;

                    array_push($requisitos, $objectRequisitoTramite);
                }

                array_push($arrayTramites,$objectTramite);
                $cont++;
            }
            

            return response()->json([
                "status" => "ok",
                "message" => "Tramites obtenidos con éxito",
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

                $centros_atencion = array();
                foreach ($tramite->centrosAtencion->where('status', 1) as $centro) {
                    $object3 = new \stdClass();
                    $object3->id = $centro->id;
                    $object3->nombre = $centro->nombre;
                    $object3->direccion = $centro->direccion;
                    array_push($centros_atencion, $object3);
                }

                $object->centrosAtencion = $centros_atencion;

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

                $centros_atencion = array();
                foreach ($tramite->centrosAtencion->where('status', 1) as $centro) {
                    $object3 = new \stdClass();
                    $object3->id = $centro->id;
                    $object3->nombre = $centro->nombre;
                    $object3->direccion = $centro->direccion;
                    array_push($centros_atencion, $object3);
                }

                $object->centrosAtencion = $centros_atencion;

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

                $centros_atencion = array();
                foreach ($tramite->centrosAtencion->where('status', 1) as $centro) {
                    $object3 = new \stdClass();
                    $object3->id = $centro->id;
                    $object3->nombre = $centro->nombre;
                    $object3->direccion = $centro->direccion;
                    array_push($centros_atencion, $object3);
                }

                $object->centrosAtencion = $centros_atencion;

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

                $centros_atencion = array();
                foreach ($tramite->centrosAtencion->where('status', 1) as $centro) {
                    $object3 = new \stdClass();
                    $object3->id = $centro->id;
                    $object3->nombre = $centro->nombre;
                    $object3->direccion = $centro->direccion;
                    array_push($centros_atencion, $object3);
                }

                $object->centrosAtencion = $centros_atencion;

                array_push($tramites_tipo_4, $object);
            }


            return response()->json([
                "status" => "ok",
                "message" => "Catalogo de tramites para agendar citas obtenido con éxito.",
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


            foreach($request->requisitos as $requisito)
            {
                $requ_tram = new RequisitoTramite;
                $requ_tram->requisito_id = $requisito;
                $requ_tram->tramite_id = $tramite->id;

                foreach($request->obligatorios as $obligatorio)
                {
                    if($requisito == $obligatorio)
                    {
                        $requ_tram->obligatorio = true;
                        break;
                    }
                    else {
                        $requ_tram->obligatorio = false;
                        // break;
                    }
                }

                $requ_tram->save();
            }
            
            $tramites = Tramite::all();

            $arrayTramites = array();
            
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
                "message" => "Nuevo Tramite agregado con éxito.",
                "tramites" => $arrayTramites
            ], 200);
        }
    }

    public function formatearFecha($week_day, $day, $month, $year)
    {
        $nombre_dia = '';
        switch ($week_day) {
            case 0:
                $nombre_dia = 'Domingo';
                break;
            case 1:
                $nombre_dia = 'Lunes';
                break;
            case 2:
                $nombre_dia = 'Martes';
                break;
            case 3:
                $nombre_dia = 'Miércoles';
                break;
            case 4:
                $nombre_dia = 'Jueves';
                break;
            case 5:
                $nombre_dia = 'Viernes';
                break;
            case 6:
                $nombre_dia = 'Sabado';
                break;
        }

        $nombre_mes = '';
        switch ($month) {
            case 1:
                $nombre_mes = 'Enero';
                break;
            case 2:
                $nombre_mes = 'Febrero';
                break;
            case 3:
                $nombre_mes = 'Marzo';
                break;
            case 4:
                $nombre_mes = 'Abril';
                break;
            case 5:
                $nombre_mes = 'Mayo';
                break;
            case 6:
                $nombre_mes = 'Junio';
                break;
            case 7:
                $nombre_mes = 'Julio';
                break;
            case 8:
                $nombre_mes = 'Agosto';
                break;
            case 9:
                $nombre_mes = 'Septiembre';
                break;
            case 10:
                $nombre_mes = 'Octubre';
                break;
            case 11:
                $nombre_mes = 'Noviembre';
                break;
            case 12:
                $nombre_mes = 'Diciembre';
                break;
        }

        $fecha_formateada = $nombre_dia . ', ' . $day . ' de ' . $nombre_mes . ' de ' . $year;
        return $fecha_formateada;
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

            $requisitos = $tramite->requisitos;

            foreach($requisitos as $requisito)
            {
                $requisito->pivot->delete();
            }


            foreach($request->requisitos as $requisito)
            {
                $requ_tram = new RequisitoTramite;
                $requ_tram->requisito_id = $requisito;
                $requ_tram->tramite_id = $tramite->id;

                foreach($request->obligatorios as $obligatorio)
                {
                    if($requisito == $obligatorio)
                    {
                        $requ_tram->obligatorio = true;
                        break;
                    }
                    else {
                        $requ_tram->obligatorio = false;
                        // break;
                    }
                }

                $requ_tram->save();
            }

            $tramites = Tramite::all();

            $arrayTramites = array();
            
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
        

            DB::commit();
            $exito = true;
        }catch (\Throwable $th) {
            DB::rollback();
            $exito = false;
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
                "message" => "Nuevo Tramite agregado con éxito.",
                "tramites" => $arrayTramites
            ], 200);
        }
    }
    public function eliminarTramite(Request $request)
    {
        $exito = false;

        DB::beginTransaction();
        try {
            $tramite = Tramite::find($request->id);
            $tramite->status = false;
            $tramite->save();

            $tramites = Tramite::where('status', 1)->get();

            $arrayTramites = array();
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

            DB::commit();
            $exito = true;
        } catch (\Throwable $th) {
            DB::rollback();
            $exito = false;
            return response()->json([
                "status" => "error",
                "message" => "Ocurrió un error al eliminar este tramite.",
                "error" => $th->getMessage(),
                "location" => $th->getFile(),
                "line" => $th->getLine(),
            ], 200);
        }

        if ($exito) {
            return response()->json([
                "status" => "ok",
                "message" => "Tramite eliminado con éxito.",
                "tramites" => $arrayTramites
            ], 200);
        }
    }

    public function getRequisitosTramite(Request $request)
    {
        try {

            if($request->id != Null)
            {
                $tipo_tramite_id = $request->tipo_tramite_id;
                $tramite = TipoTramite::find($tipo_tramite_id);

                $tramite_s = $tramite->tramites->where('id',$request->id)->first();

                $requisitos = array();

            
                foreach($tramite->requisitos as $requisito)
                {
                    $objectRequisito = new \stdClass();
                    $objectRequisito->id = $requisito->id;
                    $objectRequisito->nombre = $requisito->nombre;
                    // $objectRequisito->obligatorio = false;
                    array_push($requisitos,$objectRequisito);

                }

                $obligatorios = array();
                $requisitos_s = array();
                $requisitos_r = $tramite_s->requisitos;

                
                foreach($requisitos_r as $requisito)
                {

                    array_push($requisitos_s, $requisito->pivot->requisito_id);

                    if($requisito->pivot->obligatorio == 1)
                    {
                        array_push($obligatorios,$requisito->pivot->requisito_id);
                    }
                }

                return response()->json([
                    "status" => "ok",
                    "message" => "Requisitos asociados.",
                    "seleccionados" => $requisitos_s,
                    "obligatorios" => $obligatorios,
                    "requisitos" => $requisitos
                ], 200);
            }

            else {
                $tipo_tramite_id = $request->tipo_tramite_id;
                $tramite = TipoTramite::find($tipo_tramite_id);
                
                $requisitos = array();
                if($tramite){
                foreach($tramite->requisitos as $requisito)
                {
                    $objectRequisito = new \stdClass();
                    $objectRequisito->id = $requisito->id;
                    $objectRequisito->nombre = $requisito->nombre;
                    $objectRequisito->obligatorio = false;

                    array_push($requisitos,$objectRequisito);

                }
            }
                return response()->json([
                    "status" => "ok",
                    "message" => "Requisitos asociados.",
                    "requisitos" => $requisitos
                ], 200);
                
            }

        } catch (\Throwable $th) {
            return response()->json([
                "status" => "error",
                "message" => "Ocurrió un error al obtener requisitos asociados",
                "error" => $th->getMessage(),
                "location" => $th->getFile(),
                "line" => $th->getLine(),
            ], 200);
        }
    }

    public function getRequisitosTramiteEditar(Request $request)
    {   


        // $tipoTramite = TipoTramite::find($tipo_tramite_id);
        // $tramite = $tipoTramite->tramite->where('id',$request->id);

        $tramite = Tramite::find($request->id);


        $requisitos = array();
        $obligatorios = array();
        $requisitosSeleccionado = array();
         
        foreach($tramite->requisitos as $requisito)
        {
            $objectRequisito = new \stdClass();
            $objectRequisito->id = $requisito->id;
            $objectRequisito->nombre = $requisito->nombre;

            array_push($requisitos,$objectRequisito);

            if($requisito->pivot->obligatorio === 1)
            {
                array_push($obligatorios,$requisito->id);
            }
            array_push($requisitosSeleccionado,$requisito->pivot->requisito_id);

        }

        return response()->json([
            "status" => "ok",
            "message" => "Requisitos asociados.",
            "requisitos" => $requisitos,
            "req_seleccionados" => $requisitosSeleccionado,
            "obligatorios" => $obligatorios
        ], 200);

    }

   
}
