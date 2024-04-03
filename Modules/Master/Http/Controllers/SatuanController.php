<?php

namespace Modules\Master\Http\Controllers;

use App\Models\Satuan;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DataTables;
use Modules\Master\Http\Requests\FormSatuanRequest;

class SatuanController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Satuan::dataTable();
            return DataTables::eloquent($data)
                ->addColumn('status_satuan', function ($row) {
                    $output = $row->status_satuan ? '<i class="fa-solid fa-check"></i>' : '<i class="fa-solid fa-circle-xmark"></i>';
                    return '<div class="text-center">
                ' . $output . '
                </div>';
                })
                ->addColumn('action', function ($row) {
                    $buttonUpdate = '
                    <a class="btn btn-warning btn-edit btn-sm" 
                    data-typemodal="mediumModal"
                    data-urlcreate="' . url('master/satuan/' . $row->id . '/edit') . '"
                    data-modalId="mediumModal"
                    >
                        <i class="fa-solid fa-pencil"></i>
                    </a>
                    ';
                    $buttonDelete = '
                    <button type="button" class="btn-delete btn btn-danger btn-sm" data-url="' . url('master/satuan/' . $row->id) . '?_method=delete">
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
                ->rawColumns(['action', 'status_satuan'])
                ->toJson();
        }
        return view('master::satuan.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $action = url('master/satuan');
        return view('master::satuan.form', compact('action'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(FormSatuanRequest $request)
    {
        //
        $data = [
            'nama_satuan' => $request->input('nama_satuan'),
            'status_satuan' => $request->input('status_satuan') !== null ? true : false,
            'cabang_id' => session()->get('cabang_id'),
        ];
        Satuan::create($data);
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
        $action = url('master/satuan/' . $id . '?_method=put');
        $row = Satuan::find($id);
        return view('master::satuan.form', compact('action', 'row'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(FormSatuanRequest $request, $id)
    {
        //
        $data = [
            'nama_satuan' => $request->input('nama_satuan'),
            'status_satuan' => $request->input('status_satuan') !== null ? true : false,
            'cabang_id' => session()->get('cabang_id'),
        ];
        Satuan::find($id)->update($data);
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
        Satuan::destroy($id);
        return response()->json('Berhasil hapus data', 200);
    }
}
