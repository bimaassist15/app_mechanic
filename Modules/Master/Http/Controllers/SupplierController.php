<?php

namespace Modules\Master\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DataTables;
use Modules\Master\Http\Requests\FormSupplierRequest;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Supplier::dataTable();
            return DataTables::eloquent($data)
                ->addColumn('status_supplier', function ($row) {
                    $output = $row->status_supplier ? '<i class="fa-solid fa-check"></i>' : '<i class="fa-solid fa-circle-xmark"></i>';
                    return '<div class="text-center">
                ' . $output . '
                </div>';
                })
                ->addColumn('action', function ($row) {
                    $buttonUpdate = '
                    <a class="btn btn-warning btn-edit btn-sm" 
                    data-typemodal="extraLargeModal"
                    data-urlcreate="' . url('master/supplier/' . $row->id . '/edit') . '"
                    data-modalId="extraLargeModal"
                    >
                        <i class="fa-solid fa-pencil"></i>
                    </a>
                    ';
                    $buttonDelete = '
                    <button type="button" class="btn-delete btn btn-danger btn-sm" data-url="' . url('master/supplier/' . $row->id) . '?_method=delete">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                    ';

                    $button = '
                <div class="text-center">
                    ' . $buttonUpdate . '
                    ' . $buttonDelete . '
                </div>
                ';
                    return $button;
                })
                ->rawColumns(['action', 'status_supplier'])
                ->toJson();
        }
        return view('master::supplier.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $action = url('master/supplier');
        return view('master::supplier.form', compact('action'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(FormSupplierRequest $request)
    {
        //
        $data = [
            'nama_supplier' => $request->input('nama_supplier'),
            'nowa_supplier' => $request->input('nowa_supplier'),
            'deskripsi_supplier' => $request->input('deskripsi_supplier'),
            'perusahaan_supplier' => $request->input('perusahaan_supplier'),
            'status_supplier' => $request->input('status_supplier') !== null ? true : false,
            'cabang_id' => session()->get('cabang_id'),
        ];
        Supplier::create($data);
        return response()->json('Berhasil tambah data', 201);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('master::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $action = url('master/supplier/' . $id . '?_method=put');
        $row = Supplier::find($id);
        return view('master::supplier.form', compact('action', 'row'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(FormSupplierRequest $request, $id)
    {
        //
        $data = [
            'nama_supplier' => $request->input('nama_supplier'),
            'nowa_supplier' => $request->input('nowa_supplier'),
            'deskripsi_supplier' => $request->input('deskripsi_supplier'),
            'perusahaan_supplier' => $request->input('perusahaan_supplier'),
            'status_supplier' => $request->input('status_supplier') !== null ? true : false,
            'cabang_id' => session()->get('cabang_id'),
        ];
        Supplier::find($id)->update($data);
        return response()->json('Berhasil update data', 200);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
        Supplier::destroy($id);
        return response()->json('Berhasil hapus data', 200);
    }
}
