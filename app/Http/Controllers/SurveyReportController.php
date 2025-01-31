<?php

namespace App\Http\Controllers;

use App\Exports\surveyResultRawExport;
use App\Models\Aspect;
use App\Models\BiodataCorespondens;
use App\Models\Categories;
use App\Models\Correspondence;
use App\Models\DivisionWork;
use App\Models\Survey;
use App\Models\UnitWork;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class SurveyReportController extends Controller
{
    public function list()
    {
        $data['aspects'] = Aspect::getAllAspectDataForReport();
        $data['allDivision'] = DivisionWork::all();
        $data['allUnit'] = UnitWork::all();
        $data['biodatas'] = BiodataCorespondens::getBiodataActive();
        $data['surveys'] = Correspondence::select('id', 'data')->get();
        $data['menu'] = "VIEW";

        return view('apps.surveyor.survey-result.list',compact('data'));
    }

    public function datatables(Request $request)
    {
        if ($request->ajax()) {

            $data['survey'] = Survey::with('aspects.categories.questions')->where('status_approve','>',1)->get();

            $DataTables = DataTables::of($data['survey'])
                ->addColumn('checkbox', function ($row) {
                    return '<input type="checkbox" name="surveys_checkbox[]" class="form-check-input surveys_checkbox" value="' . $row->id . '" data-id="' . $row->id . '" />';
                })
                ->addColumn('type_report', function ($row) {
                    $type_report = '
                    <select name="type_report" id="type_report" class="form-control">
                        <option value="1" selected>Raw Responden</option>
                        <option value="2">Raw Entitas</option>
                        <option value="3">Report All</option>
                    </select>
                    ';

                    return $type_report;
                })
                ->addColumn('action', function ($row) {
                    $button = '';

                    return '
                        <div class="dropdown">
                            <a class="" href="javascript:void(0)" id="t1" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ti ti-dots-vertical fs-4"></i>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="t1">
                                '.$button.'
                                <li>
                                    <button class="dropdown-item detail-action" data-id="'.$row->id.'">
                                        Detail
                                    </button>
                                </li>
                                <li>
                                    <button class="dropdown-item export-action" data-id="'.$row->id.'">
                                        Export
                                    </button>
                                </li>
                            </ul>
                        </div>';
                })
                ->rawColumns(['action', 'checkbox', 'type_report'])
                ->addIndexColumn()
                ->make(true);

            return $DataTables;
        }
    }

    public function viewSurveyResponden(Request $request, $id)
    {
        $data['menu'] = "VIEW";
        $data['aspects'] = Aspect::getAllAspectDataForReport();
        $data['allDivision'] = DivisionWork::all();
        $data['allUnit'] = UnitWork::all();
        $data['biodatas'] = BiodataCorespondens::getBiodataActive();

        // Division, Sort, and Pagination parameters
        $division = $request->input('division');
        $sortField = $request->input('sort', 'id');
        $sortDirection = $request->input('direction', 'asc'); // Default direction 'asc'
        $perPage = $request->input('per_page', 25);

        // Validate Pagination and Sorting Inputs
        $perPage = in_array($perPage, [25, 50, 100, 1000]) ? $perPage : 25;
        $sortDirection = in_array($sortDirection, ['asc', 'desc']) ? $sortDirection : 'asc';

        // Build Query with Search, Sort, and Pagination
        $query = Correspondence::select('id', 'data')->where('survey_id', $id);

        if ($division && $division != '999') {
            $query->whereJsonContains('data->biodata', ['division_work' => (string)$division]);
        }

        $data['surveys'] = $query->orderBy($sortField, $sortDirection)
                                ->paginate($perPage)
                                ->appends([
                                    'division' => $division,
                                    'sort' => $sortField,
                                    'direction' => $sortDirection,
                                    'per_page' => $perPage,
                                ]);

        return view('apps.surveyor.survey-result.report-all', compact('data'));
    }

    public function viewSurveyGap(Request $request, $id)
    {
        $data['menu'] = "VIEW";
        $data['categories'] = Categories::all()->groupBy('name');
        $data['allDivision'] = DivisionWork::all(); // Tambahkan daftar divisi untuk filter
        $division = $request->input('division'); // Ambil input divisi

        // Query untuk mendapatkan data survei
        $query = Correspondence::select('id', 'data')->where('survey_id', $id);

        // Filter berdasarkan divisi jika divisi dipilih
        if ($division && $division != '999') {
            $query->whereJsonContains('data->biodata', ['division_work' => (string)$division]);
        }

        $data['surveys'] = $query->get();

        $categoryResults = [];
        $totalPerformance = 0;
        $totalImportance = 0;
        $totalPerformanceImportance = 0;
        $totalIKM = 0;
        $categoryCount = 0;

        foreach ($data['categories'] as $categoryName => $categories) {
            $performanceSum = 0;
            $performanceCount = 0;
            $importanceSum = 0;
            $importanceCount = 0;

            foreach ($categories as $category) {
                foreach ($data['surveys'] as $survey) {
                    $decodedData = json_decode($survey->data, true);

                    foreach ($decodedData['aspects'] as $aspect) {
                        foreach ($aspect['categories'] as $cat) {
                            if ($cat['category_id'] == $category->id) {
                                $answers = collect($cat['questions'])->pluck('answer_id')->map(function ($value) {
                                    return (int)$value;
                                })->filter();

                                if ($aspect['aspect_id'] == 1) { // Kepuasan (Performance)
                                    $performanceSum += $answers->sum();
                                    $performanceCount += $answers->count();
                                } elseif ($aspect['aspect_id'] == 2) { // Harapan (Importance)
                                    $importanceSum += $answers->sum();
                                    $importanceCount += $answers->count();
                                }
                            }
                        }
                    }
                }
            }

            $averagePerformance = $performanceCount > 0 ? round($performanceSum / $performanceCount, 2) : 0;
            $averageImportance = $importanceCount > 0 ? round($importanceSum / $importanceCount, 2) : 0;
            $multiplicationPerformanceImportance = $performanceCount > 0 && $importanceCount > 0 ? round($averagePerformance * $averageImportance, 2) : 0;
            $ikm = $performanceCount > 0 && $importanceCount > 0 ? round(($multiplicationPerformanceImportance / (5 * $averageImportance)) * 100, 2) : 0;
            $gap = $performanceCount > 0 && $importanceCount > 0 ? round($averagePerformance - $averageImportance, 2) : 0;

            if ($ikm > 88.30) {
                $nmp = 'A';
                $kup = 'Sangat Baik';
            } elseif ($ikm > 76.60) {
                $nmp = 'B';
                $kup = 'Baik';
            } elseif ($ikm > 64.99) {
                $nmp = 'C';
                $kup = 'Kurang Baik';
            } else {
                $nmp = 'D';
                $kup = 'Tidak Baik';
            }

            $categoryResults[] = [
                'name' => $categoryName,
                'ipa' => chr(65 + $categoryCount),
                'performance' => $averagePerformance,
                'importance' => $averageImportance,
                'performance_importance' => $multiplicationPerformanceImportance,
                'gap' => $gap,
                'ikm' => $ikm,
                'nmp' => $nmp,
                'kup' => $kup,
            ];

            $totalPerformance += $averagePerformance;
            $totalImportance += $averageImportance;
            $totalPerformanceImportance += $multiplicationPerformanceImportance;
            $totalIKM += $ikm;
            $categoryCount++;
        }

        // Hitung total dan rata-rata
        $data['report'] = $categoryResults;
        $data['totalPerformance'] = round($totalPerformance, 2);
        $data['totalImportance'] = round($totalImportance, 2);
        $data['totalPerformanceImportance'] = round($totalPerformanceImportance, 2);
        $data['totalIKM'] = round($totalIKM, 2);
        $data['averagePerformance'] = $categoryCount > 0 ? round($totalPerformance / $categoryCount, 2) : 0;
        $data['averageImportance'] = $categoryCount > 0 ? round($totalImportance / $categoryCount, 2) : 0;
        $data['averageMultiplicationPerformanceImportance'] = $categoryCount > 0 ? round($totalPerformanceImportance / $categoryCount, 2) : 0;
        $data['averageIKM'] = $categoryCount > 0 ? round($totalIKM / $categoryCount, 2) : 0;

        return view('apps.surveyor.survey-result.report-gap', compact('data'));
    }



    public function surveyResultRawExport(Request $request)
    {

        return Excel::download(new surveyResultRawExport($request), 'reportResultSurvey.xlsx');
    }
}
