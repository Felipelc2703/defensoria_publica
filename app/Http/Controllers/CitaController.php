<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use Illuminate\Http\Request;
use App\Mail\ConfirmacionCita;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;
use PDF;

class CitaController extends Controller
{
    public function agendarCita(Request $request)
    {
        $exito = false;

        DB::beginTransaction();
        try {
            $cita = new Cita;
            $cita->folio = 'FDEA3C';
            $cita->fecha_cita = $request->dia_cita;
            $cita->fecha_formateada = $request->fecha_formateada;
            $cita->hora_cita = $request->hora_cita;
            $cita->nombre = $request->nombre;
            $cita->email = $request->email;
            $cita->telefono = $request->telefono;
            $cita->sexo = $request->sexo;
            $cita->tiene_discapacidad = $request->tiene_discapacidad == 'Si' ? true : false;
            $cita->tramite_id = $request->tramite;
            $cita->centro_atencion_id = $request->centro_atencion;
            $cita->save();
        
            $citaAgendada = new \stdClass();
            $citaAgendada->id = $cita->id;
            $citaAgendada->folio = $cita->folio;
            $citaAgendada->nombre = $cita->nombre;
            $citaAgendada->tramite = $cita->tramite->nombre;
            $citaAgendada->fecha = $cita->fecha_formateada;
            $citaAgendada->hora = $cita->hora_cita;
            $citaAgendada->centro_atencion = $cita->centroAtencion->nombre;
            $citaAgendada->direccion_centro_atencion = $cita->centroAtencion->direccion;

            // $pdf = $this->generarArchivoCitaPdf();
            // $pdf = '';
            // $pdf = app('App\Http\Controllers\CitaController')->generarArchivoCitaPdf();

            // Custom Header
            PDF::setHeaderCallback(function($pdf) {

                // $pdf->SetY(10);

                // Set font
                $pdf->SetFont('helvetica', 'B', 11);
                // Header
                $header_image_file = public_path() . '/images/header_pdf.png';           
                $pdf->Image($header_image_file, 0,0,0,0);

            });

            
            // Custom Footer
            PDF::setFooterCallback(function($pdf) {
                
                // Position at 15 mm from bottom
                // $pdf->SetY(-15);
                // Set font
                $pdf->SetFont('helvetica', 'I', 8);
                // footer
                $footer_image_file = public_path() . '/images/footer_pdf.png';
                $pdf->Image($footer_image_file, 0,280,0,0);
                // Page number
                //$pdf->Cell(0, 10, 'Página '.$pdf->getAliasNumPage().'/'.$pdf->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');

            });

            $view = View::make('pdf.pdf_confirmacion_cita', compact('citaAgendada'));
            $html_content = $view->render();

            PDF::SetTitle('Confirmación Cita');
            
            PDF::AddPage('P', 'A4');

            PDF::writeHTML($html_content, true, false, true, false, '');

            ob_end_clean();
            
            $pdf = PDF::Output('Confirmacion_Cita.pdf', 'S');

            Mail::to($cita->email)->send(new ConfirmacionCita($citaAgendada, $pdf));

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
                "message" => "Cita agendada con exito.",
                "cita_agendada" => $citaAgendada,
            ], 200);
        }
    }

    public function generarArchivoCitaPdf()
    {
        // Custom Header
        PDF::setHeaderCallback(function($pdf) {

            $pdf->SetY(10);

            // Set font
            $pdf->SetFont('helvetica', 'B', 11);
            // Header
            // $header_image_file = asset('/img/pages/fichapdf/header.svg');            
            // $pdf->Image($header_image_file, 12,10,188,30);

        });

        
        // Custom Footer
        PDF::setFooterCallback(function($pdf) {
            
            // Position at 15 mm from bottom
            $pdf->SetY(-15);
            // Set font
            $pdf->SetFont('helvetica', 'I', 8);
            // footer
            // $footer_image_file = asset('/img/pages/fichapdf/footer.svg');            
            // $pdf->Image($footer_image_file, 12,270,188,17);
            // Page number
            //$pdf->Cell(0, 10, 'Página '.$pdf->getAliasNumPage().'/'.$pdf->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');

        });

        $view = View::make('pdf.pdf_confirmacion_cita');
        $html_content = $view->render();

        PDF::SetTitle('Confirmación Cita');
        
        PDF::AddPage('P', 'A4');

        PDF::writeHTML($html_content, true, false, true, false, '');

        ob_end_clean();
        
        // $ficha_registro = PDF::Output(uniqid().'_Ficha.pdf', 'S');
        // return $ficha_registro;
        // PDF::Output(public_path($filename), 'I');
        PDF::Output(uniqid().'_Ficha.pdf', 'I');
    }

    public function buscarCita(Request $request)
    {
        try {
            $cita = Cita::where('folio', $request->folio)->where('status', 1)->first();

            if ($cita) {
                $citaAgendada = new \stdClass();
                $citaAgendada->id = $cita->id;
                $citaAgendada->folio = $cita->folio;
                $citaAgendada->nombre = $cita->nombre;
                $citaAgendada->tramite = $cita->tramite->nombre;
                $citaAgendada->fecha = $cita->fecha_formateada;
                $citaAgendada->hora = $cita->hora_cita;
                $citaAgendada->centro_atencion = $cita->centroAtencion->nombre;
                $citaAgendada->direccion_centro_atencion = $cita->centroAtencion->direccion;

                return response()->json([
                    "status" => "ok",
                    "message" => "Cita encontrada con exito",
                    "cita" => $citaAgendada
                ], 200);
            } else {
                return response()->json([
                    "status" => "not-found",
                    "message" => "No se encontro ninguna cita registrada con ese número de folio.",
                ], 200);
            }

        } catch (\Throwable $th) {
            DB::rollback();
            $exito = false;
            return response()->json([
                "status" => "error",
                "message" => "Ocurrió un error al buscar cita.",
                "error" => $th->getMessage(),
                "location" => $th->getFile(),
                "line" => $th->getLine(),
            ], 200);
        }
    }

    public function cancelarCita($id)
    {
        try {
            $cita = Cita::find($id);
            $cita->status = 3;
            $cita->save();

            return response()->json([
                "status" => "ok",
                "message" => "Cita cancelada con exito",
            ], 200);
        } catch (\Throwable $th) {
            DB::rollback();
            $exito = false;
            return response()->json([
                "status" => "error",
                "message" => "Ocurrió un error al buscar cita.",
                "error" => $th->getMessage(),
                "location" => $th->getFile(),
                "line" => $th->getLine(),
            ], 200);
        }
    }

    public function imprimirCita($id)
    {
        $cita = Cita::find($id);

        $citaAgendada = new \stdClass();
        $citaAgendada->id = $cita->id;
        $citaAgendada->folio = $cita->folio;
        $citaAgendada->nombre = $cita->nombre;
        $citaAgendada->tramite = $cita->tramite->nombre;
        $citaAgendada->fecha = $cita->fecha_formateada;
        $citaAgendada->hora = $cita->hora_cita;
        $citaAgendada->centro_atencion = $cita->centroAtencion->nombre;
        $citaAgendada->direccion_centro_atencion = $cita->centroAtencion->direccion;

        // Custom Header
        PDF::setHeaderCallback(function($pdf) {

            // $pdf->SetY(10);

            // Set font
            $pdf->SetFont('helvetica', 'B', 11);
            // Header
            $header_image_file = public_path() . '/images/header_pdf.png';           
            $pdf->Image($header_image_file, 0,0,0,0);

        });

        
        // Custom Footer
        PDF::setFooterCallback(function($pdf) {
            
            // Position at 15 mm from bottom
            // $pdf->SetY(-15);
            // Set font
            $pdf->SetFont('helvetica', 'I', 8);
            // footer
            $footer_image_file = public_path() . '/images/footer_pdf.png';
            $pdf->Image($footer_image_file, 0,280,0,0);
            // Page number
            //$pdf->Cell(0, 10, 'Página '.$pdf->getAliasNumPage().'/'.$pdf->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');

        });

        $view = View::make('pdf.pdf_confirmacion_cita', compact('citaAgendada'));
        $html_content = $view->render();

        PDF::SetTitle('Confirmación Cita');
        
        PDF::AddPage('P', 'A4');

        PDF::writeHTML($html_content, true, false, true, false, '');

        ob_end_clean();
        
        // $ficha_registro = PDF::Output(uniqid().'_Ficha.pdf', 'S');
        // return $ficha_registro;
        // PDF::Output(public_path($filename), 'I');
        PDF::Output(uniqid().'_Ficha.pdf', 'I');

        // return response()->json([
        //     "asdf" => "aaaaa",
        //     "re" => $cita
        // ], 200);
    }
}
