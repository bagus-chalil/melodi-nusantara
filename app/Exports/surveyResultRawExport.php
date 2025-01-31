<?php

namespace App\Exports;

use App\Models\Aspect;
use App\Models\BiodataCorespondens;
use App\Models\Correspondence;
use App\Models\DivisionWork;
use App\Models\UnitWork;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class surveyResultRawExport implements FromView,WithChunkReading,WithStyles
{
    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($request)
  {
    $this->request = $request;
  }

    public function view(): View
    {
        $data['menu'] = "DWN";
        $data['aspects'] = Aspect::getAllAspectDataForReport();
        $data['allDivision'] = DivisionWork::all();
        $data['allUnit'] = UnitWork::all();
        $data['biodatas'] = BiodataCorespondens::getBiodataActive();

        // Check for division filter in the request
        $division = $this->request->input('division');
        $query = Correspondence::select('id', 'data')->where('survey_id', $this->request->survey_id);

        if ($division && $division != '999') {
            $query->whereJsonContains('data->biodata', ['division_work' => (string)$division]);
        }

        $data['surveys'] = $query->get();

        return view('apps.surveyor.survey-result.partials.table-survey-report', compact('data'));
    }


  public function chunkSize(): int
  {
      return 1000;
  }

  public function styles(Worksheet $sheet)
  {
      $styleArray = [
          'borders' => [
              'allBorders' => [
                  'borderStyle' => Border::BORDER_THIN,
              ],
          ],
      ];

      $sheet->getStyle('A1:W1000')->applyFromArray($styleArray);
  }
}
