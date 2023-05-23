<?php

namespace App\Http\Controllers;

use PDF;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Horario;
use App\Models\Usuario;
use Carbon\CarbonPeriod;
use App\Models\Consejero;
use Illuminate\Http\Request;
use App\Models\CitaConsejero;
use Illuminate\Support\Facades\DB;
use App\Mail\CancelarCitaConsejero;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;
use App\Mail\ConfirmacionCitaConsejero;


class CitaConsejeroController extends Controller
{
    public function consultaCurp(Request $request)
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

    public function agendarCitaConsejero(Request $request)
    {
        $exito = false;

        DB::beginTransaction();
        try {
            $usuario = Usuario::where('curp', $request->curp)->first();

            $consejero = Consejero::find($request->consejero);
            // $juzgado = $juez->juzgado;
            $current_date = Carbon::now();

            if ($usuario) {
                
                    $cita = CitaConsejero::where('usuario_id', $usuario->id)->where('status', 1)->where('consejero_id', $consejero->id)->exists();
                    if ($cita) {
                                return response()->json([
                                    "status" => "no-data",
                                    "message" => "Usted ya cuenta con una cita agendada con este consejero",
                                ], 200);
                            }


                $ultimo_registro = CitaConsejero::where('consejero_id', $consejero->id)->get()->last();
                $consecutivo = 0;
                if ($ultimo_registro) {
                    $consecutivo = $ultimo_registro->consecutivo + 1;
                } else {
                    $consecutivo = 1;
                }

                $cita = new CitaConsejero;
                $cita->consecutivo = $consecutivo;
                $cita->anio = $current_date->year;
                $cita->folio = 'CON' . $this->formatearNumero($consecutivo) . substr($current_date->year, -2);
                $cita->fecha_cita = $request->dia_cita;
                $cita->fecha_formateada = $request->fecha_formateada;
                $cita->hora_cita = $request->horario;
                $cita->expediente = $request->expediente;
                $cita->asunto = $request->asunto;
                $cita->usuario_id = $usuario->id;
                $cita->consejero_id = $consejero->id;
                // $cita->juez_id = $juez->id;
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
    
                $ultimo_registro = CitaConsejero::where('consejero_id', $consejero->id)->get()->last();
                $consecutivo = 0;
                if ($ultimo_registro) {
                    $consecutivo = $ultimo_registro->consecutivo + 1;
                } else {
                    $consecutivo = 1;
                }

                $cita = new CitaConsejero;
                $cita->consecutivo = $consecutivo;
                $cita->anio = $current_date->year;
                $cita->folio = 'CON' . $this->formatearNumero($consecutivo) . substr($current_date->year, -2);
                $cita->fecha_cita = $request->dia_cita;
                $cita->fecha_formateada = $request->fecha_formateada;
                $cita->hora_cita = $request->horario;
                $cita->expediente = $request->expediente;
                $cita->asunto = $request->asunto;
                $cita->usuario_id = $usuario->id;
                $cita->consejero_id = $consejero->id;
                // $cita->juez_id = $juez->id;
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
            // $citaAgendada->juzgado = $juzgado->nombre;
            // $citaAgendada->direccion_juzgado = $juzgado->direccion;
            $citaAgendada->consejero = $consejero->nombre . ' ' . $consejero->apellido_paterno . ' ' . $consejero->apellido_materno;
            
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

                $pdf->write2DBarcode('http://defensoria_publica.test/confirmacion-cita-buscada-consejero?folio='.$folio, 'QRCODE,Q', 160, 135, 70, 70, $style, 'N');

                // footer
                $footer_image_file = public_path() . '/images/footer_pdf.png';
                $pdf->Image($footer_image_file, 0,280,0,0);
            });

            $view = View::make('pdf.pdf_confirmacion_cita_consejero', compact('citaAgendada'));
            $html_content = $view->render();

            PDF::SetTitle('Confirmación Cita');
            
            PDF::AddPage('P', 'A4');

            PDF::writeHTML($html_content, true, false, true, false, '');

            ob_end_clean();
            
            $pdf = PDF::Output('Confirmacion_Cita_Consejero.pdf', 'S');

            Mail::to($usuario->email)->send(new ConfirmacionCitaConsejero($citaAgendada, $pdf));

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
    public function getCitasDelDiaConsejero(Request $request) {
        try {
            $user = Auth::user();
            $date = Carbon::now();
            $citas = CitaConsejero::where('fecha_cita', $date->toDateString())->where('consejero_id', $user->consejero_id)->get();
            
            $cont = 1;
            $array_citas = array();
            foreach ($citas as $cita) {
                $objectCita = new \stdClass();
                $objectCita->id = $cita->id;
                $objectCita->folio = $cita->folio;
                $objectCita->fecha_formateada = $cita->fecha_formateada;
                $objectCita->hora_cita = $cita->hora_cita;
                $objectCita->nombre = $cita->usuario->nombre . ' ' . $cita->usuario->apellido_paterno . ' ' . $cita->usuario->apellido_materno;
                $objectCita->curp = $cita->usuario->curp;
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

    public function selectDiaCitaConsejero(Request $request){
        try {
            $user = Auth::user();
            $citas = CitaConsejero::where('fecha_cita', $request->dia)->where('consejero_id', $user->consejero_id)->get();
            
            $cont = 1;
            $array_cita = array();
            foreach ($citas as $cita) {
                $objectCita = new \stdClass();
                $objectCita->id = $cita->id;
                $objectCita->folio = $cita->folio;
                $objectCita->fecha_formateada = $cita->fecha_formateada;
                $objectCita->hora_cita = $cita->hora_cita;
                $objectCita->nombre = $cita->usuario->nombre . ' ' . $cita->usuario->apellido_paterno . ' ' . $cita->usuario->apellido_materno;
                $objectCita->curp = $cita->usuario->curp;
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
            $cita = CitaConsejero::find($request->id);
            $cita->status = $request->status;
            $cita->motivo = $request->motivo;
            $cita->save();
            
            $status = $request->status;
            if($status == 3){
                $cita = CitaConsejero::find($request->id);
                $citaAgendada = new \stdClass();
                $citaAgendada->id = $cita->id;
                $citaAgendada->folio = $cita->folio;
                $citaAgendada->nombre = $cita->usuario->nombre . ' ' . $cita->usuario->apellido_paterno . ' ' . $cita->usuario->apellido_materno;
                $citaAgendada->fecha = $cita->fecha_formateada;
                $citaAgendada->hora = $cita->hora_cita;
                $citaAgendada->motivo = $cita->motivo;
                $email = $cita->usuario->email;

                Mail::to($email)->send(new CancelarCitaConsejero($citaAgendada));
            }
            $date = Carbon::now();
            $citas = CitaConsejero::where('fecha_cita', $date->toDateString() )->get();
           
            $array_cita = array();
            $cont = 1;
            foreach ($citas as $cita) {
                $objectCita = new \stdClass();
                $objectCita->id = $cita->id;
                $objectCita->folio = $cita->folio;
                $objectCita->fecha_formateada = $cita->fecha_formateada;
                $objectCita->hora_cita = $cita->hora_cita;
                $objectCita->nombre = $cita->usuario->nombre . ' ' . $cita->usuario->apellido_paterno . ' ' . $cita->usuario->apellido_materno;
                $objectCita->curp = $cita->usuario->curp;
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

    public function imprimirCitaConsejero($id)
    {
        $cita = CitaConsejero::find($id);

        $citaAgendada = new \stdClass();
        $citaAgendada->id = $cita->id;
        $citaAgendada->folio = $cita->folio;
        $citaAgendada->nombre = $cita->usuario->nombre . ' ' . $cita->usuario->apellido_paterno . ' ' . $cita->usuario->apellido_materno;
        $citaAgendada->fecha = $cita->fecha_formateada;
        $citaAgendada->hora = $cita->hora_cita;
        // $citaAgendada->juzgado = $cita->juzgado->nombre;
        // $citaAgendada->direccion_juzgado = $cita->juzgado->direccion;
        $citaAgendada->consejero = $cita->consejero->nombre . ' ' . $cita->consejero->apellido_paterno . ' ' . $cita->consejero->apellido_materno;
        // $citaAgendada->consejero = $consejero->nombre . ' ' . $consejero->apellido_paterno . ' ' . $consejero->apellido_materno;

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

            $pdf->write2DBarcode('http://defensoria_publica.test/confirmacion-cita-buscada-consejero?folio='.$folio, 'QRCODE,Q', 160, 135, 70, 70, $style, 'N');

            // footer
            $footer_image_file = public_path() . '/images/footer_pdf.png';
            $pdf->Image($footer_image_file, 0,280,0,0);
        });

        $view = View::make('pdf.pdf_confirmacion_cita_consejero', compact('citaAgendada'));
        $html_content = $view->render();

        PDF::SetTitle('Confirmación Cita');
        
        PDF::AddPage('P', 'A4');

        PDF::writeHTML($html_content, true, false, true, false, '');

        ob_end_clean();

        PDF::Output(uniqid().'_Cita_Consejero.pdf', 'I');
    }

    public function cancelarCitaConsejero($id)
    {
        $exito = false;
        
        DB::beginTransaction();
        try {
            $cita = CitaConsejero::find($id);
            $cita->status = 3;
            $cita->save();
            
            $horario = $cita->consejero->dias->where('fecha', $cita->fecha_cita)->first()->horarios->where('hora_inicio',$cita->hora_cita)->first();
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
    public function getReporteGraficas(Request $request)
    {
        try {
            $reservadas = CitaConsejero::where('fecha_cita', '>=', $request->fecha_inicio)
                                ->where('fecha_cita', '<=', $request->fecha_fin)
                                ->where('status', 1)
                                ->count();

                $atendidas = CitaConsejero::where('fecha_cita', '>=', $request->fecha_inicio)
                                ->where('fecha_cita', '<=', $request->fecha_fin)
                                ->where('status', 2)
                                ->count();

                $canceladas = CitaConsejero::where('fecha_cita', '>=', $request->fecha_inicio)
                                ->where('fecha_cita', '<=', $request->fecha_fin)
                                ->where('status', 3)
                                ->count();

                $total = CitaConsejero::where('fecha_cita', '>=', $request->fecha_inicio)
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
    public function getReporteGraficasConsejero(Request $request)
    {
        $days = Carbon::createFromDate(2023, $request->mes, 1)->daysInMonth;
        $first = Carbon::createFromDate(2023, $request->mes, 1);
        $last = Carbon::createFromDate(2023, $request->mes, $days);
        $period = CarbonPeriod::create($first, $last);

        $datefirst = $first->format('Y-m-d');
        $datelast = $last->format('Y-m-d');


        if($request->consejero_id == 9999){
                 $reservadas = CitaConsejero::where('fecha_cita', '>=', $datefirst)
                                ->where('fecha_cita', '<=', $datelast)
                                ->where('status', 1)
                                ->count();

                $atendidas = CitaConsejero::where('fecha_cita', '>=', $datefirst)
                                ->where('fecha_cita', '<=', $datelast)
                                ->where('status', 2)
                                ->count();

                $canceladas = CitaConsejero::where('fecha_cita', '>=', $datefirst)
                                ->where('fecha_cita', '<=', $datelast)
                                ->where('status', 3)
                                ->count();

                $total = CitaConsejero::where('fecha_cita', '>=', $datefirst)
                                ->where('fecha_cita', '<=', $datelast)
                                ->count();

                                
                $consejeros = Consejero::all();                
               
                $array_consejeros = array();
                // $cont = 1;
                foreach ($consejeros as $consejero) 
                {
                    $id = $consejero->id;
                    // $cont = $consejero->juzgado_id;
                    $apellidom = $consejero->apellido_materno;
                    $apellidop = $consejero->apellido_paterno;
                    $object = new \stdClass();
                    $object->id = $consejero->id;
                    $object->nombre = $consejero->nombre.' '.$apellidop.' '.$apellidom;
                    $reservadas1 = CitaConsejero::where('consejero_id', $id)
                                    ->where('fecha_cita', '>=', $datefirst)
                                    ->where('fecha_cita', '<=', $datelast)
                                    ->where('status', 1)
                                    ->count();

                    $atendidas1 = CitaConsejero::where('consejero_id', $id)
                                    ->where('fecha_cita', '>=', $datefirst)
                                    ->where('fecha_cita', '<=', $datelast)
                                    ->where('status', 2)
                                    ->count();

                    $canceladas1 = CitaConsejero::where('consejero_id', $id)
                                    ->where('fecha_cita', '>=', $datefirst)
                                    ->where('fecha_cita', '<=', $datelast)
                                    ->where('status', 3)
                                    ->count();

                    $total1 = CitaConsejero::where('consejero_id', $id)
                                    ->where('fecha_cita', '>=', $datefirst)
                                    ->where('fecha_cita', '<=', $datelast)
                                    ->count();

                                    // $cont++;
                    $object->pen = $reservadas1;
                    $object->aten = $atendidas1;
                    $object->cance = $canceladas1;
                    $object->tot = $total1;
                    array_push($array_consejeros, $object);
                    }
        }else{
                $reservadas = CitaConsejero::where('consejero_id', $request->consejero_id)
                                ->where('fecha_cita', '>=', $datefirst)
                                ->where('fecha_cita', '<=', $datelast)
                                ->where('status', 1)
                                ->count();

                $atendidas = CitaConsejero::where('consejero_id', $request->consejero_id)
                                ->where('fecha_cita', '>=', $datefirst)
                                ->where('fecha_cita', '<=', $datelast)
                                ->where('status', 2)
                                ->count();

                $canceladas = CitaConsejero::where('consejero_id', $request->consejero_id)
                                ->where('fecha_cita', '>=', $datefirst)
                                ->where('fecha_cita', '<=', $datelast)
                                ->where('status', 3)
                                ->count();

                $total = CitaConsejero::where('consejero_id', $request->consejero_id)
                                ->where('fecha_cita', '>=', $datefirst)
                                ->where('fecha_cita', '<=', $datelast)
                                ->count();

                
                $consejeros = Consejero::where('id', $request->consejero_id)->get();                
                

                // $id = $request->juzgado_id;
                $array_consejeros = array();
                $cont = 1;
                foreach ($consejeros as $consejero) 
                {
                    $id = $consejero->id;
                    $apellidom = $consejero->apellido_materno;
                    $apellidop = $consejero->apellido_paterno;
                    $object = new \stdClass();
                    $object->id = $cont;
                    $object->nombre = $consejero->nombre.' '.$apellidop.' '.$apellidom;
                    $reservadas1 = CitaConsejero::where('consejero_id', $request->consejero_id)
                                    ->where('fecha_cita', '>=', $datefirst)
                                    ->where('fecha_cita', '<=', $datelast)
                                    ->where('status', 1)
                                    ->count();

                    $atendidas1 = CitaConsejero::where('consejero_id', $request->consejero_id)
                                    ->where('fecha_cita', '>=', $datefirst)
                                    ->where('fecha_cita', '<=', $datelast)
                                    ->where('status', 2)
                                    ->count();

                    $canceladas1 = CitaConsejero::where('consejero_id', $request->consejero_id)
                                    ->where('fecha_cita', '>=', $datefirst)
                                    ->where('fecha_cita', '<=', $datelast)
                                    ->where('status', 3)
                                    ->count();

                    $total1 = CitaConsejero::where('consejero_id', $request->consejero_id)
                                    ->where('fecha_cita', '>=', $datefirst)
                                    ->where('fecha_cita', '<=', $datelast)
                                    ->count();

                                    $cont++;
                                    // $id++;
                    $object->pen = $reservadas1;
                    $object->aten = $atendidas1;
                    $object->cance = $canceladas1;
                    $object->tot = $total1;
                    array_push($array_consejeros, $object);
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
        $objectReporte->tabla = $array_consejeros;

        return response()->json([
            "status" => "ok",
            "message" => "Reporte obtenido con éxito",
            "reporte" => $objectReporte
        ], 200);
    }

    public function getAgenda(Request $request)
    {
        try {
            $current_date = Carbon::now();
            $user = User::find($request->user_id);
            
            $citas = CitaConsejero::where('consejero_id', $user->consejero->id)->where('status', 1)->get();

            $array_citas = array();
            foreach ($citas as $cita) {
                // $fecha_hora_cita = new Carbon($cita->fecha_cita . ' ' . $cita->hora_cita);
                // $hora_fin_cita = $fecha_hora_cita->addMinutes($horario->dia->duracion);

                $objectEvento = new \stdClass();
                $objectEvento->cita_id = $cita->id;

                // Variables para fullcalendar
                $objectEvento->title = 'Cita ' . $cita->folio;
                $objectEvento->start = $cita->fecha_cita . ' ' . $cita->hora_cita;
                $objectEvento->display = 'block';
                $objectEvento->allDay = 0;
                $objectEvento->backgroundColor = '#c4f45d';
                $objectEvento->textColor = '#000000';
                $objectEvento->borderColor = "#c4f45d";

                // Variables para modal editar
                $objectEvento->fecha = $cita->fecha_cita;
                $objectEvento->all_day = 0;
                $objectEvento->hora_inicio = $cita->hora_cita;
                $objectEvento->hora_fin = '';
                $objectEvento->descripcion = $cita->asunto;
                $objectEvento->evento_externo = 1;
                $objectEvento->tipo_externo = 1;

                array_push($array_citas, $objectEvento);
            }

            if ($request->fecha) {
                $citas_dia = CitaConsejero::where('fecha_cita', $request->fecha)->where('consejero_id', $user->consejero->id)->get();
            } else {
                $citas_dia = CitaConsejero::where('fecha_cita', $current_date->toDateString())->where('consejero_id', $user->consejero->id)->get();
            }

            return response()->json([
                "status" => "ok",
                "message" => "Eventos del calendario obtenidos con éxito.",
                "citas" => $array_citas,
                "citas_dia" => $citas_dia,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => "error",
                "message" => "Ocurrió un error al obtener los eventos del calendario.",
                "error" => $th->getMessage(),
                "location" => $th->getFile(),
                "line" => $th->getLine(),
            ], 200);
        }
    }
}
