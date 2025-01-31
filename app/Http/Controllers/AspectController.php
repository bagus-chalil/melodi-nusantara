<?php

namespace App\Http\Controllers;

use App\Models\Aspect;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class AspectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('apps.master.aspect.index');
    }

    public function datatables(Request $request)
    {
        //Datatable Handle
        if ($request->ajax()) {
            $data['aspectAll'] = Aspect::all();

        $DataTables = DataTables::of($data['aspectAll'])
            ->addColumn('checkbox', function ($row) {
                $checkbox = '<input type="checkbox" name="aspect_checkbox[]" class="form-check-input aspect_checkbox" value="'.$row->id.'" data-id="'.$row->id.'" />';
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
            'name' => 'required',
            'status' => 'required',
        ]);

        try {

            $dataAspect = [
                'name' => $request->name,
                'description' => $request->description,
                'status' => $request->status,
                'author' => Auth::user()->id,
            ];

            Aspect::create($dataAspect);

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
    public function show(Aspect $aspect)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data['aspect'] = Aspect::find($id);

        return response()->json([
            'aspect' => $data['aspect']
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $dataAspect = ([
            'name' => $request->name,
            'status' => $request->status,
            'description' => $request->description,
        ]);

        $aspect = Aspect::findOrFail($id);
        $aspect->update($dataAspect);

        return response()->json(['success' => true, 'message' => 'Data Aspect berhasil diupdate.']);
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

        $aspect_array = $validatedData['id'];

        $aspect = Aspect::whereIn('id', $aspect_array)->delete();

        if ($aspect) {
            return response()->json(['success' => true, 'message' => 'Data berhasil dihapus.']);
        } else {
            return response()->json(['success' => false, 'message' => 'Tidak ada data yang dihapus.']);
        }
    }
}
