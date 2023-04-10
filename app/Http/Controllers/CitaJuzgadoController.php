<?php

namespace App\Http\Controllers;

use PDF;
use Carbon\Carbon;
use App\Models\Juez;
use App\Models\Horario;
use App\Models\CitaJuzgado;
use Illuminate\Http\Request;
use App\Mail\ConfirmacionCitaJuez;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;

class CitaJuzgadoController extends Controller
{
    public function agendarCitaJuez(Request $request)
    {
        $exito = false;

        DB::beginTransaction();
        try {
            $juez = Juez::find($request->juez);
            $juzgado = $juez->juzgado;

            $cita = CitaJuzgado::where('curp', $request->curp)->where('status', 1)->where('juzgado_id', $juzgado->id)->exists();
            
            if ($cita) {
                return response()->json([
                    "status" => "no-data",
                    "message" => "Usted ya cuenta con una cita agendada en este juzgado",
                ], 200);
            }
            
            $cita = new CitaJuzgado;
            $cita->folio = '1C0001';
            $cita->fecha_cita = $request->dia_cita;
            $cita->fecha_formateada = $request->fecha_formateada;
            $cita->hora_cita = $request->horario;
            $cita->expediente = $request->expediente;
            $cita->asunto = $request->asunto;
            $cita->nombre = $request->nombre;
            $cita->curp = $request->curp;
            $cita->email = $request->email;
            $cita->telefono = $request->telefono;
            $cita->sexo = $request->sexo;
            $cita->juzgado_id = $juzgado->id;
            $cita->juez_id = $juez->id;
            $cita->save();

            $horario = Horario::find($request->hora_cita);
            $horario->citas_disponibles = $horario->citas_disponibles-1;
            $horario->save();

            $citaAgendada = new \stdClass();
            $citaAgendada->id = $cita->id;
            $citaAgendada->folio = $cita->folio;
            $citaAgendada->nombre = $cita->nombre;
            $citaAgendada->fecha = $cita->fecha_formateada;
            $citaAgendada->hora = $cita->hora_cita;
            $citaAgendada->juzgado = $juzgado->nombre;
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

                $pdf->write2DBarcode('http://citasenlinea.pjpuebla.gob.mx/confirmacion-cita-buscada?folio='.$folio, 'QRCODE,Q', 160, 135, 70, 70, $style, 'N');

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

            Mail::to($cita->email)->send(new ConfirmacionCitaJuez($citaAgendada, $pdf));

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
        $citaAgendada->nombre = $cita->nombre;
        $citaAgendada->fecha = $cita->fecha_formateada;
        $citaAgendada->hora = $cita->hora_cita;
        $citaAgendada->juzgado = $cita->juzgado->nombre;
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

            $pdf->write2DBarcode('http://citasenlinea.pjpuebla.gob.mx/confirmacion-cita-buscada?folio='.$folio, 'QRCODE,Q', 160, 135, 70, 70, $style, 'N');

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
            
            $horario = $cita->juez->dias->where('fecha',$cita->fecha_cita)->first()->horarios->where('hora_inicio',$cita->hora_cita)->first();
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
                $objectCita->nombre = $cita->nombre;
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
                $objectCita->nombre = $cita->nombre;
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
}
