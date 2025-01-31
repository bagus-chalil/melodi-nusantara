<?php

namespace App\Http\Controllers;

use App\Models\Aspect;
use App\Models\Categories;
use App\Models\Roles;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['roles'] = Roles::all();
        $data['aspects'] = Aspect::getAspectActive();

        return view('apps.master.categories.index',compact('data'));
    }

    public function datatables(Request $request)
    {
        //Datatable Handle
        if ($request->ajax()) {
            $data['categoriesAll'] = Categories::all();
            $data['roles'] = Roles::all();
            $data['aspect'] = Aspect::getAspectActive();

        $DataTables = DataTables::of($data['categoriesAll'])
            ->addColumn('checkbox', function ($row) {
                $checkbox = '<input type="checkbox" name="categories_checkbox[]" class="form-check-input categories_checkbox" value="'.$row->id.'" data-id="'.$row->id.'" />';
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
            ->addColumn('aspect', function ($row) use ($data){
                foreach ($data['aspect'] as $value) {
                    if ($row->aspect_id == $value->id) {
                        $aspect = $value->name;
                    }
                }
                return $aspect;
            })
            ->addColumn('role', function ($row) use ($data) {
                $dataRolesArray = 'Not Set Role';
                if ($row->type_role != 'null') {
                    $dataRoles = json_decode($row->type_role);

                    $roleSpan = [];
                    foreach ($dataRoles as $value) {
                        foreach ($data['roles'] as $role) {
                            if ($value == $role->id) {
                                $roleSpan[] = '<span class="badge text-bg-secondary p-2">'.$role->name.'</span>';
                            }
                        }
                    }

                    $dataRolesArray = implode(' ', $roleSpan);
                }

                return $dataRolesArray;
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
            ->rawColumns(['action', 'checkbox', 'status', 'role', 'aspect'])
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
            'aspect' => 'required',
            'status' => 'required',
        ]);

        try {

            $dataCategories = [
                'name' => $request->name,
                'type_role' => json_encode($request->role) ?? null,
                'aspect_id' => $request->aspect,
                'description' => $request->description,
                'status' => $request->status,
                'author' => Auth::user()->id,
            ];

            Categories::create($dataCategories);

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
    public function show(Categories $categories)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data['categories'] = Categories::find($id);
        $data['aspects'] = Aspect::all();
        $data['roles'] = Roles::all();

        return response()->json([
            'aspects' => $data['aspects'],
            'categories' => $data['categories'],
            'roles' => $data['roles'],
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $dataCategories = ([
            'name' => $request->name,
            'type_role' => json_encode($request->role),
            'aspect_id' => $request->aspect,
            'status' => $request->status,
            'description' => $request->description,
        ]);

        $categories = Categories::findOrFail($id);
        $categories->update($dataCategories);

        return response()->json(['success' => true, 'message' => 'Data Categories berhasil diupdate.']);
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

        $categories_array = $validatedData['id'];

        $categories = Categories::whereIn('id', $categories_array)->delete();

        if ($categories) {
            return response()->json(['success' => true, 'message' => 'Data berhasil dihapus.']);
        } else {
            return response()->json(['success' => false, 'message' => 'Tidak ada data yang dihapus.']);
        }
    }
}
