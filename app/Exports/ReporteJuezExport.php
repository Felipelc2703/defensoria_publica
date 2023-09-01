<?php

namespace App\Exports;

use Maatwebsite\Excel\Excel;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;

class ReporteJuezExport implements FromView, WithEvents
{
    use Exportable;
    use RegistersEventListeners;


    public $citas;
    public $contador;

    function __construct($citas,$contador)
    {
        $this->citas = $citas;
        $this->contador = $contador;
    }

    public function view(): View
    {
        return view('exports.reporte_citas_juez', [
            'citas' => $this->citas
        ]);
    }

    public static function afterSheet(afterSheet $event)
    {
        $num_rows = $event->getConcernable()->contador;
        //$num_rows=15;

        $title_font_style = [
            'font' => [
                'name' => 'Arial',
                'bold' => true,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => array('argb' => '000000'),
                ]
            ]
        ];

        $heads_font_style = [
            'font' => [
                'name' => 'Arial',
                'bold' => true,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => array('argb' => '000000'),
                ]
            ]
        ];
        $body_font_style = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => array('argb' => '000000'),
                ]
            ]
        ];

        // Get Worksheet
        $active_sheet = $event->sheet->getDelegate();

        // $active_sheet->mergeCells('B2:D2');

        // Tittle
        $active_sheet->mergeCells('A1:U1');
        $active_sheet->getStyle('A1:U1')->applyFromArray($title_font_style);
        $active_sheet->getStyle('A1:U1')->getAlignment()->setHorizontal('center');
        // Tittle

        // Columns title
        $active_sheet->getStyle('A2:U2')->applyFromArray($heads_font_style);
        $active_sheet->getStyle('A2:U2')->getAlignment()->setHorizontal('center');
        // // Columns title
        
        //$active_sheet->getStyle('A3:A'.($num_rows+2))->applyFromArray($body_font_style);

        for ($i=2; $i <= $num_rows+2; $i++) { //FOLIO
            $active_sheet->mergeCells('A'.$i.':A'.$i);
        }
        for ($i=2; $i <= $num_rows+2; $i++) { //NOMBRE
            $active_sheet->mergeCells('B'.$i.':D'.$i);
        }
        for ($i=2; $i <= $num_rows+2; $i++) { //SeXO
            $active_sheet->mergeCells('E'.$i.':G'.$i);
        }
        for ($i=2; $i <= $num_rows+2; $i++) { //cORREO
            $active_sheet->mergeCells('H'.$i.':I'.$i);
        }
        for ($i=2; $i <= $num_rows+2; $i++) { //TELEFONO
            $active_sheet->mergeCells('J'.$i.':K'.$i);
        }
        for ($i=2; $i <= $num_rows+2; $i++) { //TRAMITE
            $active_sheet->mergeCells('L'.$i.':O'.$i);
        }
        for ($i=2; $i <= $num_rows+2; $i++) { //FECHA
            $active_sheet->mergeCells('P'.$i.':Q'.$i);
        }
        for ($i=2; $i <= $num_rows+2; $i++) { //HORARIO
            $active_sheet->mergeCells('R'.$i.':S'.$i);
        }
        for ($i=2; $i <= $num_rows+2; $i++) { //ESTATUS
            $active_sheet->mergeCells('T'.$i.':U'.$i);
        }
        // for ($i=2; $i <= $num_rows+2; $i++) { //CENTRO ATENCION
        //     $active_sheet->mergeCells('V'.$i.':AB'.$i);
        // }
        // for ($i=2; $i <= $num_rows+2; $i++) { //DISCAPACIDAD
        //     $active_sheet->mergeCells('AC'.$i.':AE'.$i);
        // }
        // for ($i=2; $i <= $num_rows+2; $i++) { //TIPO_DIS
        //     $active_sheet->mergeCells('AF'.$i.':AG'.$i);
        // }

        $active_sheet->getStyle('A3:A'.($num_rows+2))->applyFromArray($body_font_style);
        $active_sheet->getStyle('B3:B'.($num_rows+2))->applyFromArray($body_font_style);
        $active_sheet->getStyle('C3:C'.($num_rows+2))->applyFromArray($body_font_style);
        $active_sheet->getStyle('D3:D'.($num_rows+2))->applyFromArray($body_font_style);
        $active_sheet->getStyle('E3:E'.($num_rows+2))->applyFromArray($body_font_style);
        $active_sheet->getStyle('F3:F'.($num_rows+2))->applyFromArray($body_font_style);
        $active_sheet->getStyle('G3:G'.($num_rows+2))->applyFromArray($body_font_style);
        $active_sheet->getStyle('H3:H'.($num_rows+2))->applyFromArray($body_font_style);
        $active_sheet->getStyle('I3:I'.($num_rows+2))->applyFromArray($body_font_style);
        $active_sheet->getStyle('J3:J'.($num_rows+2))->applyFromArray($body_font_style);
        $active_sheet->getStyle('K3:K'.($num_rows+2))->applyFromArray($body_font_style);
        $active_sheet->getStyle('L3:L'.($num_rows+2))->applyFromArray($body_font_style);
        $active_sheet->getStyle('M3:M'.($num_rows+2))->applyFromArray($body_font_style);
        $active_sheet->getStyle('N3:N'.($num_rows+2))->applyFromArray($body_font_style);
        $active_sheet->getStyle('O3:O'.($num_rows+2))->applyFromArray($body_font_style);
        $active_sheet->getStyle('P3:P'.($num_rows+2))->applyFromArray($body_font_style);
        $active_sheet->getStyle('Q3:Q'.($num_rows+2))->applyFromArray($body_font_style);
        $active_sheet->getStyle('R3:R'.($num_rows+2))->applyFromArray($body_font_style);
        $active_sheet->getStyle('S3:S'.($num_rows+2))->applyFromArray($body_font_style);
        $active_sheet->getStyle('T3:T'.($num_rows+2))->applyFromArray($body_font_style);
        $active_sheet->getStyle('U3:U'.($num_rows+2))->applyFromArray($body_font_style);
        // $active_sheet->getStyle('V3:V'.($num_rows+2))->applyFromArray($body_font_style);
        // $active_sheet->getStyle('W3:W'.($num_rows+2))->applyFromArray($body_font_style);
        // $active_sheet->getStyle('X3:X'.($num_rows+2))->applyFromArray($body_font_style);
        // $active_sheet->getStyle('Y3:Y'.($num_rows+2))->applyFromArray($body_font_style);
        // $active_sheet->getStyle('Z3:Z'.($num_rows+2))->applyFromArray($body_font_style);
        // $active_sheet->getStyle('AA3:AA'.($num_rows+2))->applyFromArray($body_font_style);
        // $active_sheet->getStyle('AB3:AB'.($num_rows+2))->applyFromArray($body_font_style);
        // $active_sheet->getStyle('AC3:AC'.($num_rows+2))->applyFromArray($body_font_style);
        // $active_sheet->getStyle('AD3:AD'.($num_rows+2))->applyFromArray($body_font_style);
        // $active_sheet->getStyle('AE3:AE'.($num_rows+2))->applyFromArray($body_font_style);
        // $active_sheet->getStyle('AF3:AF'.($num_rows+2))->applyFromArray($body_font_style);
        // $active_sheet->getStyle('AG3:AG'.($num_rows+2))->applyFromArray($body_font_style);
    }
}
