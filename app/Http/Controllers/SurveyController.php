<?php

namespace App\Http\Controllers;

use App\Exports\surveyResultRawExport;
use App\Helpers\GenerateTokenHelper;
use App\Models\Answers;
use App\Models\Aspect;
use App\Models\BiodataCorespondens;
use App\Models\Categories;
use App\Models\Correspondence;
use App\Models\DivisionWork;
use App\Models\Survey;
use App\Models\UnitWork;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class SurveyController extends Controller
{
    public function __construct(protected GenerateTokenHelper $generateTokenHelper)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['aspects'] = Aspect::getAspectActive();
        $data['biodatas'] = BiodataCorespondens::getBiodataActive();

        return view('apps.surveyor.survey.index',compact('data'));
    }

    public function approval()
    {
        $data['aspects'] = Aspect::getAspectActive();

        return view('apps.admin.survey.index',compact('data'));
    }

    public function datatables(Request $request)
    {
        if ($request->ajax()) {

            if (Auth::user()->hasRole('Surveyor|Super Admin')) {
                $data['survey'] = Survey::with('aspects.categories.questions')->get();
            } else {
                $data['survey'] = Survey::with('aspects.categories.questions')->where('status_approve','>',1)->get();
            }


            $DataTables = DataTables::of($data['survey'])
                ->addColumn('checkbox', function ($row) {
                    return '<input type="checkbox" name="surveys_checkbox[]" class="form-check-input surveys_checkbox" value="' . $row->id . '" data-id="' . $row->id . '" />';
                })
                ->addColumn('status_approve', function ($row) {
                    if ($row->status_approve == 0) {
                        $status_approve = '<span class="badge text-bg-secondary p-2">Survey Planned</span>';
                    } elseif ($row->status_approve == 1) {
                        $status_approve = '<span class="badge text-bg-danger p-2">Survey Planned Need Revision</span>';
                    } elseif ($row->status_approve == 2) {
                        $status_approve = '<span class="badge text-bg-warning p-2">Survey Planned Waiting Approved</span>';
                    } elseif ($row->status_approve == 3) {
                        $status_approve = '<span class="badge text-bg-primary p-2">Survey Generate</span>';
                    } else {
                        $status_approve = '<span class="badge text-bg-success p-2">Survey Finished</span>';
                    }

                    return $status_approve;
                })
                ->addColumn('token', function ($row) {
                    if ($row->status_approve > 2) {
                        $link = url('/survey/survey-guest/intro/' . Crypt::encrypt($row->token));
                        return '
                            <div class="d-flex align-items-center">
                                <input type="text" class="form-control form-control-sm me-2" value="' . $link . '" readonly>
                                <button class="btn btn-sm btn-primary copy-link" data-link="' . $link . '">Copy</button>
                            </div>';
                    } else {
                        return '
                            <div class="d-flex align-items-center">
                                <button class="btn btn-sm btn-warning">Not Avail</button>
                            </div>';
                    }
                })
                ->addColumn('action', function ($row) {
                    $button = '';
                    if (Auth::user()->hasRole('Surveyor')) {
                        if (in_array($row->status_approve, [0, 1])) {
                            $button = '
                                <li>
                                    <a class="dropdown-item edit-action" href="javascript:void(0)" data-id="' . $row->id . '">
                                        Edit
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item submit-action" href="javascript:void(0)" data-id="' . $row->id . '">
                                        Send for Approval
                                    </a>
                                </li>';
                        }
                    } elseif(Auth::user()->hasRole('Admin')) {
                        if (in_array($row->status_approve, [2])) {
                            $button = '
                                <li>
                                    <a class="dropdown-item approve-action" href="javascript:void(0)" data-id="' . $row->id . '">
                                        Approve Form Survey
                                    </a>
                                </li>';
                        }
                    } elseif(Auth::user()->hasRole('Super Admin')) {
                        $button = '
                                <li>
                                    <a class="dropdown-item edit-action" href="javascript:void(0)" data-id="' . $row->id . '">
                                        Edit
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item submit-action" href="javascript:void(0)" data-id="' . $row->id . '">
                                        Send for Approval
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item approve-action" href="javascript:void(0)" data-id="' . $row->id . '">
                                        Approve Form Survey
                                    </a>
                                </li>';
                    }

                    return '
                        <div class="dropdown">
                            <a class="" href="javascript:void(0)" id="t1" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ti ti-dots-vertical fs-4"></i>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="t1">
                                '.$button.'
                                <li>
                                    <a class="dropdown-item detail-action" href="/survey/survey-admin/intro/' . $row->id . '" data-id="' . $row->id . '">
                                        Detail
                                    </a>
                                </li>
                            </ul>
                        </div>';
                })
                ->rawColumns(['action', 'checkbox', 'status_approve', 'token'])
                ->addIndexColumn()
                ->make(true);

            return $DataTables;
        }
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'aspects' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'quota' => 'required',
            'biodatas' => 'required',
        ]);

        try {
            $dataSurvey = [
                'author' => Auth::user()->id,
                'name' => $request->name,
                'aspect' => json_encode($request->aspects),
                'biodata' => json_encode($request->biodatas),
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'status_approve' => 0,
                'description' => $request->description,
                'quota' => $request->quota,
                'token' => null
            ];

            Survey::create($dataSurvey);

            return response()->json([
                'message' => 'Data Save successfully!'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Survey $survey)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data['survey'] = Survey::find($id);
        $data['aspects'] = Aspect::all();
        $data['biodatas'] = BiodataCorespondens::all();

        return response()->json([
            'survey' => $data['survey'],
            'aspects' => $data['aspects'],
            'biodatas' => $data['biodatas'],
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $dataSurvey = [
            'name' => $request->name,
            'biodata' => json_encode($request->biodatas),
            'aspect' => json_encode($request->aspects),
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'quota' => $request->quota,
            'description' => $request->description,
        ];

        $survey = Survey::findOrFail($id);
        $survey->update($dataSurvey);

        return response()->json(['success' => true, 'message' => 'Data Survey berhasil diupdate.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required|array',
            'id.*' => 'integer',
        ]);

        $survey_array = $validatedData['id'];

        $survey = Survey::whereIn('id', $survey_array)->delete();

        if ($survey) {
            return response()->json(['success' => true, 'message' => 'Data berhasil dihapus.']);
        } else {
            return response()->json(['success' => false, 'message' => 'Tidak ada data yang dihapus.']);
        }
    }

    public function sendSurveyForApproval(Request $request)
    {
        $survey = Survey::findOrFail($request->id);

        if ($survey) {
            $survey->update(['status_approve' => 2]);
            return response()->json(['success' => true, 'message' => 'Data berhasil dikirim.']);
        } else {
            return response()->json(['success' => false, 'message' => 'Tidak ada data.']);
        }
    }

    public function approveFormSurvey(Request $request)
    {
        $survey = Survey::findOrFail($request->id);

        if ($survey) {
            $survey->update(['status_approve' => 3,'token' => $this->generateTokenHelper->generateSecureToken()]);
            return response()->json(['success' => true, 'message' => 'Data berhasil dikirim.']);
        } else {
            return response()->json(['success' => false, 'message' => 'Tidak ada data.']);
        }
    }

    public function introSurveyAdmin($id)
    {
        $data['survey'] = Survey::findOrFail($id);
        $data['typeCorespondens'] = BiodataCorespondens::all();
        $data['url'] = 'survey/survey-admin/form';

        return view('apps.guest.survey-intro',compact('data'));
    }

    public function introSurveyGuest($token)
    {
        try {
            // Dekripsi token
            $token = Crypt::decrypt($token);
        } catch (DecryptException) {
            // Jika token tidak valid
            Alert::error('Error', 'Token tidak valid!');
            return redirect()->back();
        }

        $data['survey'] = Survey::where('token', $token)->first();

        $data['typeCorespondens'] = BiodataCorespondens::all();

        $data['url'] = 'survey/survey-guest/form';

        return view('apps.guest.survey-intro', compact('data'));
    }


    public function detailFormSurvey(Request $request, $id)
    {
        if ($request->type_coresponden == 99) {
            Alert::error('Error', 'Silahkan pilih tipe survey!');
            return redirect()->back();
        }
        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException) {
            Alert::error('Error', 'Token tidak valid!');
            return redirect()->back();
        }

        $survey = Survey::findOrFail($id);

        if (!$survey) {
            Alert::error('Error', 'Survey tidak ditemukan!');
            return redirect()->back();
        }

        $currentDate = now();
        if ($currentDate <= $survey->start_date || $currentDate >= $survey->end_date) {
            Alert::error('Error', 'Survey tidak lagi berlaku!');
            return redirect()->back();
        }

        if ($survey->quota > 0 && $survey->total_responden >= $survey->quota) {
            Alert::error('Error', 'Kuota survey telah terpenuhi!');
            return redirect()->back();
        }

        $data['survey'] = $survey;

        $data['division_work'] = DivisionWork::getDivisionWorkActive();
        $data['unit_work'] = UnitWork::getUnitWorkActive();
        $data['surveyAll'] = $survey;
        $data['surveyForm'] = Aspect::getSurveyQuestion();
        $biodata = BiodataCorespondens::findOrFail($request->type_coresponden);

        $answerIds = json_decode($biodata->answer, true);

        $data['biodata_answers'] = Answers::whereIn('id', $answerIds)
            ->where('status', "1")
            ->get();

        $data['biodata'] = $biodata;

        return view('apps.guest.survey', compact('data'));
    }

    public function surveyAdminSubmit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'saran_umum' => 'required|string',
            'saran_k3' => 'required|string',
            'biodata' => 'required|array',
            'biodata.fields' => 'required|array',
            'biodata.fields.*.name' => 'required|string',
            'biodata.fields.*.value' => 'nullable',
            'aspects' => 'required|array',
            'aspects.*.aspect_id' => 'required|integer',
            'aspects.*.categories' => 'required|array',
            'aspects.*.categories.*.category_id' => 'required|integer',
            'aspects.*.categories.*.questions.*.question_id' => 'required_with:aspects.*.categories.*.questions|integer',
            'aspects.*.categories.*.questions.*.answer_id' => 'required_with:aspects.*.categories.*.questions|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi Gagal!',
                'errors' => $validator->errors()
            ], 422);
        }

        $validatedData = $validator->validated();

        // Transformasi biodata
        $biodata = [];
        foreach ($validatedData['biodata']['fields'] as $field) {
            $biodata[] = [
                $field['name'] => $field['value']
            ];
        }

        // Transformasi aspects
        $aspects = array_map(function ($aspect) {
            $categories = array_map(function ($category) {
                $questions = array_map(function ($question) {
                    return [
                        'question_id' => $question['question_id'],
                        'answer_id' => $question['answer_id']
                    ];
                }, array_values($category['questions']));

                return [
                    'category_id' => $category['category_id'],
                    'questions' => $questions
                ];
            }, array_values($aspect['categories']));
            return [
                'aspect_id' => $aspect['aspect_id'],
                'categories' => $categories
            ];
        }, array_values($validatedData['aspects']));

        // Hasil akhir JSON
        $finalData = [
            'biodata' => $biodata,
            'aspects' => $aspects,
            'saran_umum' => $validatedData['saran_umum'] ?? null,
            'saran_k3' => $validatedData['saran_k3'] ?? null
        ];

        return response()->json([
            'message' => 'Survey berhasil disimpan!',
            'data' => $finalData
        ]);
    }


    public function surveyGuestSubmit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'saran_umum' => 'required|string',
            'saran_k3' => 'required|string',
            'biodata' => 'required|array',
            'biodata.fields' => 'required|array',
            'biodata.fields.*.name' => 'required|string',
            'biodata.fields.*.value' => 'nullable',
            'aspects' => 'required|array',
            'aspects.*.aspect_id' => 'required|integer',
            'aspects.*.categories' => 'required|array',
            'aspects.*.categories.*.category_id' => 'required|integer',
            'aspects.*.categories.*.questions.*.question_id' => 'required_with:aspects.*.categories.*.questions|integer',
            'aspects.*.categories.*.questions.*.answer_id' => 'required_with:aspects.*.categories.*.questions|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi Gagal!',
                'errors' => $validator->errors()
            ], 422);
        }

        $validatedData = $validator->validated();

        // Transformasi biodata
        $biodata = [];
        foreach ($validatedData['biodata']['fields'] as $field) {
            $biodata[] = [
                $field['name'] => $field['value']
            ];
        }

        // Transformasi aspects
        $aspects = array_map(function ($aspect) {
            $categories = array_map(function ($category) {
                $questions = array_map(function ($question) {
                    return [
                        'question_id' => $question['question_id'],
                        'answer_id' => $question['answer_id']
                    ];
                }, array_values($category['questions']));

                return [
                    'category_id' => $category['category_id'],
                    'questions' => $questions
                ];
            }, array_values($aspect['categories']));
            return [
                'aspect_id' => $aspect['aspect_id'],
                'categories' => $categories
            ];
        }, array_values($validatedData['aspects']));

        // Hasil akhir JSON
        $finalData = [
            'biodata' => $biodata,
            'aspects' => $aspects,
            'saran_umum' => $validatedData['saran_umum'] ?? null,
            'saran_k3' => $validatedData['saran_k3'] ?? null
        ];

        $survey = Survey::findOrFail($request->survey_id);

        Correspondence::create([
            'survey_id' => $request->survey_id,
            'data' => json_encode($finalData)
        ]);

        $survey->update(['total_responden' => $survey->total_responden + 1]);

        return response()->json([
            'message' => 'Survey berhasil disimpan!',
            'data' => $finalData
        ]);
    }

    public function CloseSurvey()
    {
        return view('apps.guest.survey-close');
    }

}
