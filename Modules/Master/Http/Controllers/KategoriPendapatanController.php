<?php

namespace Modules\Master\Http\Controllers;

use App\Models\KategoriPendapatan;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Master\Http\Requests\FormKPendapatanRequest;
use DataTables;
use Illuminate\Support\Facades\Config;

class KategoriPendapatanController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */

    public $datastatis;
    public function __construct()
    {
        $this->datastatis = Config::get('datastatis');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = KategoriPendapatan::dataTable();
            return DataTables::eloquent($data)
                ->addColumn('status_kpendapatan', function ($row) {
                    $output = $row->status_kpendapatan ? '<i class="fa-solid fa-check"></i>' : '<i class="fa-solid fa-circle-xmark"></i>';
                    return '<div class="text-center">
                ' . $output . '
                </div>';
                })
                ->addColumn('action', function ($row) {
                    $buttonUpdate = '
                    <a class="btn btn-warning btn-edit btn-sm" 
                    data-typemodal="mediumModal"
                    data-urlcreate="' . url('master/kategoriPendapatan/' . $row->id . '/edit') . '"
                    data-modalId="mediumModal"
                    >
                        <i class="fa-solid fa-pencil"></i>
                    </a>
                    ';
                    $buttonDelete = '
                    <button type="button" class="btn-delete btn btn-danger btn-sm" data-url="' . url('master/kategoriPendapatan/' . $row->id) . '?_method=delete">
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
                ->rawColumns(['action', 'status_kpendapatan'])
                ->toJson();
        }
        return view('master::kategoriPendapatan.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $action = url('master/kategoriPendapatan');
        return view('master::kategoriPendapatan.form', compact('action'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(FormKPendapatanRequest $request)
    {
        //
        $data = [
            'nama_kpendapatan' => $request->input('nama_kpendapatan'),
            'status_kpendapatan' => $request->input('status_kpendapatan') !== null ? true : false,
            'cabang_id' => session()->get('cabang_id'),
        ];
        KategoriPendapatan::create($data);
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
        $action = url('master/kategoriPendapatan/' . $id . '?_method=put');
        $row = KategoriPendapatan::find($id);
        return view('master::kategoriPendapatan.form', compact('action', 'row'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(FormKPendapatanRequest $request, $id)
    {
        //
        $data = [
            'nama_kpendapatan' => $request->input('nama_kpendapatan'),
            'status_kpendapatan' => $request->input('status_kpendapatan') !== null ? true : false,
            'cabang_id' => session()->get('cabang_id'),
        ];
        KategoriPendapatan::find($id)->update($data);
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
        KategoriPendapatan::destroy($id);
        return response()->json('Berhasil hapus data', 200);
    }
}
