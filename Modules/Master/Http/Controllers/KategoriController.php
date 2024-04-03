<?php

namespace Modules\Master\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Master\Http\Requests\FormKategoriRequest;
use DataTables;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $data = Kategori::dataTable();
            return DataTables::eloquent($data)
            ->addColumn('status_kategori', function ($row) {
                $output = $row->status_kategori ? '<i class="fa-solid fa-check"></i>' : '<i class="fa-solid fa-circle-xmark"></i>';
                return '<div class="text-center">
                '.$output.'
                </div>';
            })
                ->addColumn('action', function ($row) {
                    $buttonUpdate = '
                    <a class="btn btn-warning btn-edit btn-sm" 
                    data-typemodal="mediumModal"
                    data-urlcreate="' . url('master/kategori/'.$row->id.'/edit'). '"
                    data-modalId="mediumModal"
                    >
                        <i class="fa-solid fa-pencil"></i>
                    </a>
                    ';
                    $buttonDelete = '
                    <button type="button" class="btn-delete btn btn-danger btn-sm" data-url="'.url('master/kategori/'.$row->id).'?_method=delete">
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
                ->rawColumns(['action', 'status_kategori'])
                ->toJson();
        }
        return view('master::kategori.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $action = url('master/kategori');
        return view('master::kategori.form', compact('action'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(FormKategoriRequest $request)
    {
        $data = [
            'nama_kategori' => $request->input('nama_kategori'),
            'status_kategori' => $request->input('status_kategori') !== null ? true : false,
            'cabang_id' => session()->get('cabang_id'),
        ];
        Kategori::create($data);
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
        $action = url('master/kategori/'.$id.'?_method=put');
        $row = Kategori::find($id);
        return view('master::kategori.form', compact('action','row'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(FormKategoriRequest $request, $id)
    {
        $data = [
            'nama_kategori' => $request->input('nama_kategori'),
            'status_kategori' => $request->input('status_kategori') !== null ? true : false,
            'cabang_id' => session()->get('cabang_id'),
        ];
        Kategori::find($id)->update($data);
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
        Kategori::destroy($id);
        return response()->json('Berhasil hapus data', 200);
    }
}
