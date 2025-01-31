<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Answers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class AnswersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('apps.master.answers.index');
    }

    public function datatables(Request $request)
    {
        //Datatable Handle
        if ($request->ajax()) {
            $data['answersAll'] = Answers::all();

        $DataTables = DataTables::of($data['answersAll'])
            ->addColumn('checkbox', function ($row) {
                $checkbox = '<input type="checkbox" name="answers_checkbox[]" class="form-check-input answers_checkbox" value="'.$row->id.'" data-id="'.$row->id.'" />';
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
            ->addColumn('created_at', function ($row) {
                return Carbon::parse($row->created_at)->format('d-m-Y H:i');
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
            'label' => 'required',
            'name' => 'required',
            'type' => 'required',
            'status' => 'required',
        ]);

        try {
            $data = null;
            if ($request->type == 'checkbox' || $request->type == 'radiobutton') {
                $data = json_encode($request->data);
            } elseif ($request->type == 'select'){
                $data = $request->data;
            }

            $dataAnswers = [
                'label' => $request->label,
                'name' => $request->name,
                'type' => $request->type,
                'data' => $data,
                'status' => $request->status,
                'author' => Auth::user()->id,
            ];

            Answers::create($dataAnswers);

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
    public function show(Answer $answer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data['answers'] = Answers::find($id);

        return response()->json([
            'answers' => $data['answers']
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $data = null;
        if ($request->type == 'checkbox') {
            $data = json_encode($request->data);
        } elseif ($request->type == 'select'){
            $data = $request->data;
        }

        $dataAnswers = [
            'label' => $request->label,
            'name' => $request->name,
            'type' => $request->type,
            'data' => $data,
            'status' => $request->status,
        ];

        $answers = Answers::findOrFail($id);
        $answers->update($dataAnswers);

        return response()->json(['success' => true, 'message' => 'Data Answers berhasil diupdate.']);
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

        $answers_array = $validatedData['id'];

        $answers = Answers::whereIn('id', $answers_array)->delete();

        if ($answers) {
            return response()->json(['success' => true, 'message' => 'Data berhasil dihapus.']);
        } else {
            return response()->json(['success' => false, 'message' => 'Tidak ada data yang dihapus.']);
        }
    }
}
