<?php

namespace App\Http\Controllers;

use App\Models\Answers;
use App\Models\BiodataCorespondens;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class BiodataCorespondensController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['answers'] = Answers::getAnswersActive();

        return view('apps.master.biodata.index',compact('data'));
    }

    public function datatables(Request $request)
    {
        //Datatable Handle
        if ($request->ajax()) {
            $data['biodataAll'] = BiodataCorespondens::all();
            $data['answers'] = Answers::all();

        $DataTables = DataTables::of($data['biodataAll'])
            ->addColumn('checkbox', function ($row) {
                $checkbox = '<input type="checkbox" name="biodata_checkbox[]" class="form-check-input biodata_checkbox" value="'.$row->id.'" data-id="'.$row->id.'" />';
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
            ->addColumn('answer_status', function ($row) use ($data) {
                $dataAnswerArray = 'Not Set Answer';
                if ($row->answer != 'null') {
                    $dataAnswer = json_decode($row->answer);

                    $roleSpan = [];
                    foreach ($dataAnswer as $value) {
                        foreach ($data['answers'] as $answer) {
                            if ($value == $answer->id) {
                                $roleSpan[] = '<span class="badge text-bg-secondary p-2">'.$answer->name.'</span>';
                            }
                        }
                    }

                    $dataAnswerArray = implode(' ', $roleSpan);
                }

                return $dataAnswerArray;
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
            ->rawColumns(['action', 'checkbox', 'status', 'answer_status'])
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
            'answers' => 'required',
            'status' => 'required',
        ]);

        try {

            $dataBiodata = [
                'name' => $request->name,
                'answer' => json_encode($request->answers),
                'description' => $request->description,
                'status' => $request->status,
                'author' => Auth::user()->id,
            ];

            BiodataCorespondens::create($dataBiodata);

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
    public function show(BiodataCorespondens $biodataCorespondens)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data['biodata'] = BiodataCorespondens::find($id);
        $data['answers'] = Answers::all();

        return response()->json([
            'biodata' => $data['biodata'],
            'answers' => $data['answers']
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {

            $dataBiodata = [
                'name' => $request->name,
                'answer' => json_encode($request->answers),
                'description' => $request->description,
                'status' => $request->status,
            ];

            BiodataCorespondens::where('id', $id)->update($dataBiodata);

            return response()->json([
                'message' => 'Data Update successfully!'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred: ' . $e->getMessage(),
            ], 500);
        }
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

        $biodata_array = $validatedData['id'];

        $biodata = BiodataCorespondens::whereIn('id', $biodata_array)->delete();

        if ($biodata) {
            return response()->json(['success' => true, 'message' => 'Data berhasil dihapus.']);
        } else {
            return response()->json(['success' => false, 'message' => 'Tidak ada data yang dihapus.']);
        }
    }
}
