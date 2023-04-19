<?php

namespace App\Http\Controllers;

use PDF;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Models\Juez;
use App\Models\Juzgado;
use App\Models\Horario;
use App\Models\Usuario;
use App\Models\CitaJuzgado;
use Illuminate\Http\Request;
use App\Mail\ConfirmacionCitaJuez;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;

class CitaJuzgadoController extends Controller
{
    public function consultarCurp(Request $request)
    {
        try {
            $usuario = Usuario::where('curp', $request->curp)->first();

            if ($usuario) {
                return response()->json([
                    "status" => "ok",
                    "message" => "Usuario obtenido con exito",
                    "usuario" => $usuario
                ], 200);
            } else {
                return response()->json([
                    "status" => "exists",
                    "message" => "No hay registros de citas con este curp",
                ], 200);
            }
        } catch (\Throwable $th) {
            return response()->json([
                "status" => "error",
                "message" => "Ocurrió un error al consultar CURP.",
                "error" => $th->getMessage(),
                "location" => $th->getFile(),
                "line" => $th->getLine(),
            ], 200);
        }
    }

    public function agendarCitaJuez(Request $request)
    {
        $exito = false;

        DB::beginTransaction();
        try {
            $usuario = Usuario::where('curp', $request->curp)->first();

            $juez = Juez::find($request->juez);
            $juzgado = $juez->juzgado;
            $current_date = Carbon::now();

            if ($usuario) {
                $num_jueces = $juzgado->jueces->count();
                
                if ($num_jueces > 1) {
                    $cita_juez = CitaJuzgado::where('usuario_id', $usuario->id)->where('status', 1)->where('juzgado_id', $juzgado->id)->where('juez_id', $juez->id)->exists();
                    if ($cita_juez) {
                        return response()->json([
                            "status" => "no-data",
                            "message" => "Usted ya cuenta con una cita agendada con este mismo juez en este juzgado",
                        ], 200);
                    }
                    $cita_hora = CitaJuzgado::where('usuario_id', $usuario->id)->where('status', 1)->where('juzgado_id', $juzgado->id)->where('hora_cita', $request->horario)->where('juez_id', '!=', $juez->id)->exists();
                    if ($cita_hora) {
                        return response()->json([
                            "status" => "no-data",
                            "message" => "Usted ya cuenta con una cita agendada con otro juez de este juzgado a la misma hora"
                        ], 200);
                    }
                } else if ($num_jueces == 1) {
                    $cita = CitaJuzgado::where('usuario_id', $usuario->id)->where('status', 1)->where('juzgado_id', $juzgado->id)->exists();
                    
                    if ($cita) {
                        return response()->json([
                            "status" => "no-data",
                            "message" => "Usted ya cuenta con una cita agendada con este juez en este juzgado",
                        ], 200);
                    }
                }


                $ultimo_registro = CitaJuzgado::where('juzgado_id', $juzgado->id)->get()->last();
                $consecutivo = 0;
                if ($ultimo_registro) {
                    $consecutivo = $ultimo_registro->consecutivo + 1;
                } else {
                    $consecutivo = 1;
                }

                $cita = new CitaJuzgado;
                $cita->consecutivo = $consecutivo;
                $cita->anio = $current_date->year;
                $cita->folio = $juzgado->prefijo_folio . $this->formatearNumero($consecutivo) . substr($current_date->year, -2);
                $cita->fecha_cita = $request->dia_cita;
                $cita->fecha_formateada = $request->fecha_formateada;
                $cita->hora_cita = $request->horario;
                $cita->expediente = $request->expediente;
                $cita->asunto = $request->asunto;
                $cita->usuario_id = $usuario->id;
                $cita->juzgado_id = $juzgado->id;
                $cita->juez_id = $juez->id;
                $cita->save();
            } else {
                $usuario = new Usuario;
                $usuario->nombre = $request->nombre;
                $usuario->apellido_paterno = $request->apellido_paterno;
                $usuario->apellido_materno = $request->apellido_materno;
                $usuario->curp = $request->curp;
                $usuario->email = $request->email;
                $usuario->telefono = $request->telefono;
                $usuario->sexo = $request->sexo;
                $usuario->save();
    
                $ultimo_registro = CitaJuzgado::where('juzgado_id', $juzgado->id)->get()->last();
                $consecutivo = 0;
                if ($ultimo_registro) {
                    $consecutivo = $ultimo_registro->consecutivo + 1;
                } else {
                    $consecutivo = 1;
                }

                $cita = new CitaJuzgado;
                $cita->consecutivo = $consecutivo;
                $cita->anio = $current_date->year;
                $cita->folio = $juzgado->prefijo_folio . $this->formatearNumero($consecutivo) . substr($current_date->year, -2);
                $cita->fecha_cita = $request->dia_cita;
                $cita->fecha_formateada = $request->fecha_formateada;
                $cita->hora_cita = $request->horario;
                $cita->expediente = $request->expediente;
                $cita->asunto = $request->asunto;
                $cita->usuario_id = $usuario->id;
                $cita->juzgado_id = $juzgado->id;
                $cita->juez_id = $juez->id;
                $cita->save();
            }

            $horario = Horario::find($request->hora_cita);
            $horario->citas_disponibles = $horario->citas_disponibles-1;
            $horario->save();

            $citaAgendada = new \stdClass();
            $citaAgendada->id = $cita->id;
            $citaAgendada->folio = $cita->folio;
            $citaAgendada->nombre = $usuario->nombre . ' ' . $usuario->apellido_paterno . ' ' . $usuario->apellido_materno;
            $citaAgendada->fecha = $cita->fecha_formateada;
            $citaAgendada->hora = $cita->hora_cita;
            $citaAgendada->juzgado = $juzgado->nombre;
            $citaAgendada->direccion_juzgado = $juzgado->direccion;
            $citaAgendada->juez = $juez->nombre . ' ' . $juez->apellido_paterno . ' ' . $juez->apellido_materno;
            
            $folio = $citaAgendada->folio;

            //Custom Header
            PDF::setHeaderCallback(function($pdf) {
                $pdf->SetFont('helvetica', 'B', 11);
                // Header
                $header_image_file = public_path() . '/images/header_pdf.png';           
                $pdf->Image($header_image_file, 0,0,0,0);
            });

            // Custom Footer
            PDF::setFooterCallback(function($pdf) use($folio) {
                $pdf->SetFont('helvetica', 'I', 8);

                $style = array(
                    // 'border' => 2,
                    'vpadding' => 'auto',
                    'hpadding' => 'auto',
                    'fgcolor' => array(0,0,0),
                    'bgcolor' => false, //array(255,255,255)
                    'module_width' => 1, // width of a single module in points
                    'module_height' => 1 // height of a single module in points
                ); 

                $pdf->write2DBarcode('http://defensoria_publica.test/confirmacion-cita-buscada-juzgado?folio='.$folio, 'QRCODE,Q', 160, 135, 70, 70, $style, 'N');

                // footer
                $footer_image_file = public_path() . '/images/footer_pdf.png';
                $pdf->Image($footer_image_file, 0,280,0,0);
            });

            $view = View::make('pdf.pdf_confirmacion_cita_juez', compact('citaAgendada'));
            $html_content = $view->render();

            PDF::SetTitle('Confirmación Cita');
            
            PDF::AddPage('P', 'A4');

            PDF::writeHTML($html_content, true, false, true, false, '');

            ob_end_clean();
            
            $pdf = PDF::Output('Confirmacion_Cita_Juez.pdf', 'S');

            Mail::to($usuario->email)->send(new ConfirmacionCitaJuez($citaAgendada, $pdf));

            DB::commit();
            $exito = true;
        } catch (\Throwable $th) {
            DB::rollback();
            $exito = false;
            return response()->json([
                "status" => "error",
                "message" => "Ocurrió un error al agendar la cita.",
                "error" => $th->getMessage(),
                "location" => $th->getFile(),
                "line" => $th->getLine(),
            ], 200);
        }

        if ($exito) {
            return response()->json([
                "status" => "ok",
                "message" => "Cita agendada con éxito.",
                "cita_agendada" => $citaAgendada,
            ], 200);
        }
    }

    public function imprimirCitaJuzgado($id)
    {
        $cita = CitaJuzgado::find($id);

        $citaAgendada = new \stdClass();
        $citaAgendada->id = $cita->id;
        $citaAgendada->folio = $cita->folio;
        $citaAgendada->nombre = $cita->usuario->nombre . ' ' . $cita->usuario->apellido_paterno . ' ' . $cita->usuario->apellido_materno;
        $citaAgendada->fecha = $cita->fecha_formateada;
        $citaAgendada->hora = $cita->hora_cita;
        $citaAgendada->juzgado = $cita->juzgado->nombre;
        $citaAgendada->direccion_juzgado = $cita->juzgado->direccion;
        $citaAgendada->juez = $cita->juez->nombre . ' ' . $cita->juez->apellido_paterno . ' ' . $cita->juez->apellido_materno;

        $folio = $citaAgendada->folio;

        //Custom Header
        PDF::setHeaderCallback(function($pdf) {
            $pdf->SetFont('helvetica', 'B', 11);
            // Header
            $header_image_file = public_path() . '/images/header_pdf.png';           
            $pdf->Image($header_image_file, 0,0,0,0);
        });

        // Custom Footer
        PDF::setFooterCallback(function($pdf) use($folio) {
            $pdf->SetFont('helvetica', 'I', 8);

            $style = array(
                // 'border' => 2,
                'vpadding' => 'auto',
                'hpadding' => 'auto',
                'fgcolor' => array(0,0,0),
                'bgcolor' => false, //array(255,255,255)
                'module_width' => 1, // width of a single module in points
                'module_height' => 1 // height of a single module in points
            ); 

            $pdf->write2DBarcode('http://defensoria_publica.test/confirmacion-cita-buscada-juzgado?folio='.$folio, 'QRCODE,Q', 160, 135, 70, 70, $style, 'N');

            // footer
            $footer_image_file = public_path() . '/images/footer_pdf.png';
            $pdf->Image($footer_image_file, 0,280,0,0);
        });

        $view = View::make('pdf.pdf_confirmacion_cita_juez', compact('citaAgendada'));
        $html_content = $view->render();

        PDF::SetTitle('Confirmación Cita');
        
        PDF::AddPage('P', 'A4');

        PDF::writeHTML($html_content, true, false, true, false, '');

        ob_end_clean();

        PDF::Output(uniqid().'_Cita_Juzgado.pdf', 'I');
    }

    public function cancelarCitaJuzgado($id)
    {
        $exito = false;
        
        DB::beginTransaction();
        try {
            $cita = CitaJuzgado::find($id);
            $cita->status = 3;
            $cita->save();
            
            $horario = $cita->juez->dias->where('fecha', $cita->fecha_cita)->first()->horarios->where('hora_inicio',$cita->hora_cita)->first();
            $horario->citas_disponibles++;
            $horario->save();

            DB::commit();
            $exito = true;
        } catch (\Throwable $th) {
            DB::rollback();
            $exito = false;
            return response()->json([
                "status" => "error",
                "message" => "Ocurrió un error al cancelar cita.",
                "error" => $th->getMessage(),
                "location" => $th->getFile(),
                "line" => $th->getLine(),
            ], 200);
        }

        if ($exito) {
            return response()->json([
                "status" => "ok",
                "message" => "Cita cancelada con éxito",
            ], 200);
        }
    }

    public function getCitasDelDiaJuez(Request $request) {
        try {
            $user = Auth::user();
            $date = Carbon::now();
            $citas = CitaJuzgado::where('fecha_cita', $date->toDateString())->where('juez_id', $user->juez_id)->get();
            
            $cont = 1;
            $array_citas = array();
            foreach ($citas as $cita) {
                $objectCita = new \stdClass();
                $objectCita->id = $cita->id;
                $objectCita->folio = $cita->folio;
                $objectCita->fecha_formateada = $cita->fecha_formateada;
                $objectCita->hora_cita = $cita->hora_cita;
                $objectCita->nombre = $cita->usuario->nombre . ' ' . $cita->usuario->apellido_paterno . ' ' . $cita->usuario->apellido_materno;
                $objectCita->curp = $cita->curp;
                $objectCita->status = $cita->status;
                $objectCita->expediente = $cita->expediente;
                $objectCita->asunto = $cita->asunto;

                if($cita->status == 1){
                    $objectCita->status = "1";
                    $objectCita->statusnom = "No atendida";
                }
                if($cita->status == 2){
                    $objectCita->status = "2";
                    $objectCita->statusnom = "Atendida";
                }
                if($cita->status == 3){
                    $objectCita->status = "3";
                    $objectCita->statusnom = "Cancelada";
                }

                $cont++;
                array_push($array_citas, $objectCita);
            }

            return response()->json([
                "status" => "ok",
                "message" => "Citas obtenidas con éxito",
                "citas" => $array_citas
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => "error",
                "message" => "Ocurrió un error al obtener las citas",
                "error" => $th->getMessage(),
                "location" => $th->getFile(),
                "line" => $th->getLine(),
            ], 200);
        }
    }

    public function selectDiaCitaJuez(Request $request){
        try {
            $user = Auth::user();
            $citas = CitaJuzgado::where('fecha_cita', $request->dia)->where('juez_id', $user->juez_id)->get();
            
            $cont = 1;
            $array_cita = array();
            foreach ($citas as $cita) {
                $objectCita = new \stdClass();
                $objectCita->id = $cita->id;
                $objectCita->folio = $cita->folio;
                $objectCita->fecha_formateada = $cita->fecha_formateada;
                $objectCita->hora_cita = $cita->hora_cita;
                $objectCita->nombre = $cita->usuario->nombre . ' ' . $cita->usuario->apellido_paterno . ' ' . $cita->usuario->apellido_materno;
                $objectCita->curp = $cita->curp;
                $objectCita->status = $cita->status;
                $objectCita->expediente = $cita->expediente;
                $objectCita->asunto = $cita->asunto;

                if($cita->status == 1){
                    $objectCita->status = "1";
                    $objectCita->statusnom = "No atendida";
                }
                if($cita->status == 2){
                    $objectCita->status = "2";
                    $objectCita->statusnom = "Atendida";
                }
                if($cita->status == 3){
                    $objectCita->status = "3";
                    $objectCita->statusnom = "Cancelada";
                }

                $cont++;
                array_push($array_cita, $objectCita);
            }

            return response()->json([
                "status" => "ok",
                "message" => "Citas obtenidas con éxito",
                "citas" => $array_cita
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => "error",
                "message" => "Ocurrió un error al obtener las citas",
                "error" => $th->getMessage(),
                "location" => $th->getFile(),
                "line" => $th->getLine(),
            ], 200);
        }
    }

    public function guardarCambios(Request $request)
    {
        $exito = false;

        DB::beginTransaction();
        try {
            $cita = CitaJuzgado::find($request->id);
            $cita->status = $request->status;
            $cita->motivo = $request->motivo;
            $cita->save();
            
            $date = Carbon::now();
            $citas = CitaJuzgado::where('fecha_cita', $date->toDateString() )->get();
           
            $array_cita = array();
            $cont = 1;
            foreach ($citas as $cita) {
                $objectCita = new \stdClass();
                $objectCita->id = $cita->id;
                $objectCita->folio = $cita->folio;
                $objectCita->fecha_formateada = $cita->fecha_formateada;
                $objectCita->hora_cita = $cita->hora_cita;
                $objectCita->nombre = $cita->usuario->nombre . ' ' . $cita->usuario->apellido_paterno . ' ' . $cita->usuario->apellido_materno;
                $objectCita->curp = $cita->curp;
                $objectCita->status = $cita->status;
                $objectCita->expediente = $cita->expediente;
                $objectCita->asunto = $cita->asunto;

                if($cita->status == 1){
                    $objectCita->status = "1";
                    $objectCita->statusnom = "No atendida";
                }
                if($cita->status == 2){
                    $objectCita->status = "2";
                    $objectCita->statusnom = "Atendida";
                }
                if($cita->status == 3){
                    $objectCita->status = "3";
                    $objectCita->statusnom = "Cancelada";
                }

                $cont++;
                array_push($array_cita, $objectCita);
            }
            
            DB::commit();
            $exito = true;
        } catch (\Throwable $th) {
            DB::rollback();
            $exito = false;
            return response()->json([
                "status" => "error",
                "message" => "Ocurrió un error al actualizar el estatus.",
                "error" => $th->getMessage(),
                "location" => $th->getFile(),
                "line" => $th->getLine(),
            ], 200);
        }

        if ($exito) {
            return response()->json([
                "status" => "ok",
                "message" => "Estatus actualizado con éxito.",
                "citas" => $array_cita
            ], 200);
        }
    }

    public function getReporteGraficas(Request $request)
    {
        try {
            $reservadas = CitaJuzgado::where('fecha_cita', '>=', $request->fecha_inicio)
                                ->where('fecha_cita', '<=', $request->fecha_fin)
                                ->where('status', 1)
                                ->count();

                $atendidas = CitaJuzgado::where('fecha_cita', '>=', $request->fecha_inicio)
                                ->where('fecha_cita', '<=', $request->fecha_fin)
                                ->where('status', 2)
                                ->count();

                $canceladas = CitaJuzgado::where('fecha_cita', '>=', $request->fecha_inicio)
                                ->where('fecha_cita', '<=', $request->fecha_fin)
                                ->where('status', 3)
                                ->count();

                $total = CitaJuzgado::where('fecha_cita', '>=', $request->fecha_inicio)
                                ->where('fecha_cita', '<=', $request->fecha_fin)
                                ->count();
                
                $objectReporte = new \stdClass();
                $objectReporte->reservadas = $reservadas;
                $objectReporte->atendidas = $atendidas;
                $objectReporte->canceladas = $canceladas;
                $objectReporte->total = $total;
                $objectReporte->porcent_1 = $total > 0 ? ($reservadas * 100) / $total : 0;
                $objectReporte->porcent_2 = $total > 0 ? ($atendidas * 100) / $total : 0;
                $objectReporte->porcent_3 = $total > 0 ? ($canceladas * 100) / $total : 0;

                return response()->json([
                    "status" => "ok",
                    "message" => "Estadisticas obtenidos con éxito",
                    "reporte" => $objectReporte
                ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => "error",
                "message" => "Ocurrió un error al obtener las estadísticas",
                "error" => $th->getMessage(),
                "location" => $th->getFile(),
                "line" => $th->getLine(),
            ], 200);
        }
    }

    public function formatearNumero($number)
    {
        $length = strlen((string)$number);
        switch ($length) {
            case 1:
                $numero_formateado = '000' . $number;
                break;
            case 2:
                $numero_formateado = '00' . $number;
                break;
            case 3:
                $numero_formateado = '0' . $number;
                break;
            default:
                $numero_formateado = $number;
                break;
        }

        return $numero_formateado;
    }
    public function getReporteGraficasJuzgado(Request $request)
    {
        $days = Carbon::createFromDate(2023, $request->mes, 1)->daysInMonth;
        $first = Carbon::createFromDate(2023, $request->mes, 1);
        $last = Carbon::createFromDate(2023, $request->mes, $days);
        $period = CarbonPeriod::create($first, $last);

        $datefirst = $first->format('Y-m-d');
        $datelast = $last->format('Y-m-d');


        if($request->juzgado_id == 9999){
                 $reservadas = CitaJuzgado::where('fecha_cita', '>=', $datefirst)
                                ->where('fecha_cita', '<=', $datelast)
                                ->where('status', 1)
                                ->count();

                $atendidas = CitaJuzgado::where('fecha_cita', '>=', $datefirst)
                                ->where('fecha_cita', '<=', $datelast)
                                ->where('status', 2)
                                ->count();

                $canceladas = CitaJuzgado::where('fecha_cita', '>=', $datefirst)
                                ->where('fecha_cita', '<=', $datelast)
                                ->where('status', 3)
                                ->count();

                $total = CitaJuzgado::where('fecha_cita', '>=', $datefirst)
                                ->where('fecha_cita', '<=', $datelast)
                                ->count();

                                
                $jueces = Juez::all();                
               
                $array_jueces = array();
                $cont = 1;
                foreach ($jueces as $juez) 
                {
                    $apellidom = $juez->apellido_materno;
                    $apellidop = $juez->apellido_paterno;
                    $objectJuez = new \stdClass();
                    $objectJuez->id = $cont;
                    $objectJuez->nombre = $juez->nombre.' '.$apellidop.' '.$apellidom;
                    $reservadas1 = CitaJuzgado::where('juzgado_id', $cont)
                                    ->where('fecha_cita', '>=', $datefirst)
                                    ->where('fecha_cita', '<=', $datelast)
                                    ->where('status', 1)
                                    ->count();

                    $atendidas1 = CitaJuzgado::where('juzgado_id', $cont)
                                    ->where('fecha_cita', '>=', $datefirst)
                                    ->where('fecha_cita', '<=', $datelast)
                                    ->where('status', 2)
                                    ->count();

                    $canceladas1 = CitaJuzgado::where('juzgado_id', $cont)
                                    ->where('fecha_cita', '>=', $datefirst)
                                    ->where('fecha_cita', '<=', $datelast)
                                    ->where('status', 3)
                                    ->count();

                    $total1 = CitaJuzgado::where('juzgado_id', $cont)
                                    ->where('fecha_cita', '>=', $datefirst)
                                    ->where('fecha_cita', '<=', $datelast)
                                    ->count();

                                    $cont++;
                    $objectJuez->pen = $reservadas1;
                    $objectJuez->aten = $atendidas1;
                    $objectJuez->cance = $canceladas1;
                    $objectJuez->tot = $total1;
                    array_push($array_jueces, $objectJuez);
                    }
        }else{
                $reservadas = CitaJuzgado::where('juzgado_id', $request->juzgado_id)
                                ->where('fecha_cita', '>=', $datefirst)
                                ->where('fecha_cita', '<=', $datelast)
                                ->where('status', 1)
                                ->count();

                $atendidas = CitaJuzgado::where('juzgado_id', $request->juzgado_id)
                                ->where('fecha_cita', '>=', $datefirst)
                                ->where('fecha_cita', '<=', $datelast)
                                ->where('status', 2)
                                ->count();

                $canceladas = CitaJuzgado::where('juzgado_id', $request->juzgado_id)
                                ->where('fecha_cita', '>=', $datefirst)
                                ->where('fecha_cita', '<=', $datelast)
                                ->where('status', 3)
                                ->count();

                $total = CitaJuzgado::where('juzgado_id', $request->juzgado_id)
                                ->where('fecha_cita', '>=', $datefirst)
                                ->where('fecha_cita', '<=', $datelast)
                                ->count();

                
                                $jueces = Juez::where('juzgado_id', $request->juzgado_id)->get();                
                

                $id = $request->juzgado_id;
                $array_jueces = array();
                $cont = 1;
                foreach ($jueces as $juez) 
                {
                    $apellidom = $juez->apellido_materno;
                    $apellidop = $juez->apellido_paterno;
                    $objectJuez = new \stdClass();
                    $objectJuez->id = $cont;
                    $objectJuez->nombre = $juez->nombre.' '.$apellidop.' '.$apellidom;
                    $reservadas1 = CitaJuzgado::where('juzgado_id', $request->juzgado_id)
                                    ->where('id', $id)
                                    ->where('fecha_cita', '>=', $datefirst)
                                    ->where('fecha_cita', '<=', $datelast)
                                    ->where('status', 1)
                                    ->count();

                    $atendidas1 = CitaJuzgado::where('juzgado_id', $request->juzgado_id)
                                    ->where('id', $id)
                                    ->where('fecha_cita', '>=', $datefirst)
                                    ->where('fecha_cita', '<=', $datelast)
                                    ->where('status', 2)
                                    ->count();

                    $canceladas1 = CitaJuzgado::where('juzgado_id', $request->juzgado_id)
                                    ->where('id', $id)
                                    ->where('fecha_cita', '>=', $datefirst)
                                    ->where('fecha_cita', '<=', $datelast)
                                    ->where('status', 3)
                                    ->count();

                    $total1 = CitaJuzgado::where('juzgado_id', $request->juzgado_id)
                                    ->where('id', $id)
                                    ->where('fecha_cita', '>=', $datefirst)
                                    ->where('fecha_cita', '<=', $datelast)
                                    ->count();

                                    $cont++;
                                    $id++;
                    $objectJuez->pen = $reservadas1;
                    $objectJuez->aten = $atendidas1;
                    $objectJuez->cance = $canceladas1;
                    $objectJuez->tot = $total1;
                    array_push($array_jueces, $objectJuez);
                    }
        }


        
        $objectReporte = new \stdClass();
        $objectReporte->reservadas = $reservadas;
        $objectReporte->atendidas = $atendidas;
        $objectReporte->canceladas = $canceladas;
        $objectReporte->total = $total;
        $objectReporte->porcent_1 = $total > 0 ? ($reservadas * 100) / $total : 0;
        $objectReporte->porcent_2 = $total > 0 ? ($atendidas * 100) / $total : 0;
        $objectReporte->porcent_3 = $total > 0 ? ($canceladas * 100) / $total : 0;
        $objectReporte->tabla = $array_jueces;

        return response()->json([
            "status" => "ok",
            "message" => "Reporte obtenido con éxito",
            "reporte" => $objectReporte
        ], 200);
    }
}
