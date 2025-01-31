<?php

namespace App\Http\Controllers;

use App\Models\Answers;
use App\Models\Categories;
use App\Models\Questions;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class QuestionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['answers'] = Answers::getAnswersActive();
        $data['categories'] = Categories::getCategoriesActive();

        return view('apps.master.questions.index',compact('data'));
    }

    public function datatables(Request $request)
    {
        //Datatable Handle
        if ($request->ajax()) {
            $data['questionsAll'] = Questions::getAllQuestions();

        $DataTables = DataTables::of($data['questionsAll'])
            ->addColumn('checkbox', function ($row) {
                $checkbox = '<input type="checkbox" name="questions_checkbox[]" class="form-check-input questions_checkbox" value="'.$row->id.'" data-id="'.$row->id.'" />';
                return $checkbox;
            })
            ->addColumn('status', function ($row) {
                if ($row->status == '0') {
                    $statuses = '<span class="badge text-bg-danger p-2">Not Active</span>';
                } else {
                    $statuses = '<span class="badge text-bg-success p-2">Active</span>';
                }
                return $statuses;
            })
            ->addColumn('categories', function ($row) {
                return $row->categories->aspects->name.'-'.$row->categories->name;
            })
            ->addColumn('answers', function ($row) {
                return $row->answers->name;
            })
            ->addColumn('action', function ($row) {
                $action = '
                    <div class="dropdown">
                        <a class="" href="javascript:void(0)" id="t1" data-bs-toggle="dropdown" aria-expanded="false">
                          <i class="ti ti-dots-vertical fs-4"></i>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="t1">
                          <li>
                            <a class="dropdown-item edit-action" href="javascript:void(0)" data-id="'.$row->id.'">
                                Edit
                            </a>
                          </li>
                          </li>
                        </ul>
                    </div>
                ';
                return $action;
            })
            ->rawColumns(['action', 'checkbox', 'status'])
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
            'categories' => 'required',
            'answers' => 'required',
            'status' => 'required',
        ]);

        try {
            $dataQuestions = [
                'name' => $request->name,
                'categories_id' => $request->categories,
                'answer_id' => $request->answers,
                'status' => $request->status,
                'author' => Auth::user()->id,
            ];

            Questions::create($dataQuestions);

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
    public function show(Questions $questions)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data['question'] = Questions::find($id);
        $data['categories'] = Categories::with('aspects')->get();
        $data['answers'] = Answers::all();

        return response()->json([
            'question' => $data['question'],
            'categories' => $data['categories'],
            'answers' => $data['answers'],
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $dataQuestions = [
            'name' => $request->name,
            'categories_id' => $request->categories,
            'answer_id' => $request->answers,
            'status' => $request->status,
        ];

        $questions = Questions::findOrFail($id);
        $questions->update($dataQuestions);

        return response()->json(['success' => true, 'message' => 'Data Questions berhasil diupdate.']);
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

        $question_array = $validatedData['id'];

        $question = Questions::whereIn('id', $question_array)->delete();

        if ($question) {
            return response()->json(['success' => true, 'message' => 'Data berhasil dihapus.']);
        } else {
            return response()->json(['success' => false, 'message' => 'Tidak ada data yang dihapus.']);
        }
    }
}
