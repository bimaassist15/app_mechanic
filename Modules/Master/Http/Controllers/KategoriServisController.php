<?php

namespace Modules\Master\Http\Controllers;

use App\Models\KategoriServis;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Master\Http\Requests\FormKServisRequest;
use DataTables;

class KategoriServisController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = KategoriServis::dataTable();
            return DataTables::eloquent($data)
                ->addColumn('status_kservis', function ($row) {
                    $output = $row->status_kservis ? '<i class="fa-solid fa-check"></i>' : '<i class="fa-solid fa-circle-xmark"></i>';
                    return '<div class="text-center">
                ' . $output . '
                </div>';
                })
                ->addColumn('action', function ($row) {
                    $buttonUpdate = '
                    <a class="btn btn-warning btn-edit btn-sm" 
                    data-typemodal="mediumModal"
                    data-urlcreate="' . url('master/kategoriServis/' . $row->id . '/edit') . '"
                    data-modalId="mediumModal"
                    >
                        <i class="fa-solid fa-pencil"></i>
                    </a>
                    ';
                    $buttonDelete = '
                    <button type="button" class="btn-delete btn btn-danger btn-sm" data-url="' . url('master/kategoriServis/' . $row->id) . '?_method=delete">
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
                ->rawColumns(['action', 'status_kservis'])
                ->toJson();
        }
        return view('master::kategoriServis.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $action = url('master/kategoriServis');
        return view('master::kategoriServis.form', compact('action'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(FormKServisRequest $request)
    {
        //
        $data = [
            'nama_kservis' => $request->input('nama_kservis'),
            'status_kservis' => $request->input('status_kservis') !== null ? true : false,
            'cabang_id' => session()->get('cabang_id'),
        ];
        KategoriServis::create($data);
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
        $action = url('master/kategoriServis/' . $id . '?_method=put');
        $row = KategoriServis::find($id);
        return view('master::kategoriServis.form', compact('action', 'row'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(FormKServisRequest $request, $id)
    {
        //
        $data = [
            'nama_kservis' => $request->input('nama_kservis'),
            'status_kservis' => $request->input('status_kservis') !== null ? true : false,
            'cabang_id' => session()->get('cabang_id'),
        ];
        KategoriServis::find($id)->update($data);
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
        KategoriServis::destroy($id);
        return response()->json('Berhasil hapus data', 200);
    }
}
