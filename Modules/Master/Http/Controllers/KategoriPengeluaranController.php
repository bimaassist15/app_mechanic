<?php

namespace Modules\Master\Http\Controllers;

use App\Models\KategoriPengeluaran;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Master\Http\Requests\FormKPengeluaranRequest;
use DataTables;
use Illuminate\Support\Facades\Config;

class KategoriPengeluaranController extends Controller
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
            $data = KategoriPengeluaran::dataTable();
            return DataTables::eloquent($data)
                ->addColumn('status_kpengeluaran', function ($row) {
                    $output = $row->status_kpengeluaran ? '<i class="fa-solid fa-check"></i>' : '<i class="fa-solid fa-circle-xmark"></i>';
                    return '<div class="text-center">
                ' . $output . '
                </div>';
                })
                ->addColumn('action', function ($row) {
                    $buttonUpdate = '
                    <a class="btn btn-warning btn-edit btn-sm" 
                    data-typemodal="mediumModal"
                    data-urlcreate="' . url('master/kategoriPengeluaran/'.$row->id.'/edit') . '"
                    data-modalId="mediumModal"
                    >
                        <i class="fa-solid fa-pencil"></i>
                    </a>
                    ';
                    $buttonDelete = '
                    <button type="button" class="btn-delete btn btn-danger btn-sm" data-url="' . url('master/kategoriPengeluaran/' . $row->id) . '?_method=delete">
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
                ->rawColumns(['action', 'status_kpengeluaran'])
                ->toJson();
        }
        return view('master::kategoriPengeluaran.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $action = url('master/kategoriPengeluaran');
        return view('master::kategoriPengeluaran.form', compact('action'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(FormKPengeluaranRequest $request)
    {
        //
        $data = [
            'nama_kpengeluaran' => $request->input('nama_kpengeluaran'),
            'status_kpengeluaran' => $request->input('status_kpengeluaran') !== null ? true : false,
            'cabang_id' => session()->get('cabang_id'),
        ];
        KategoriPengeluaran::create($data);
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
        $action = url('master/kategoriPengeluaran/' . $id . '?_method=put');
        $row = KategoriPengeluaran::find($id);
        return view('master::kategoriPengeluaran.form', compact('action', 'row'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(FormKPengeluaranRequest $request, $id)
    {
        //
        $data = [
            'nama_kpengeluaran' => $request->input('nama_kpengeluaran'),
            'status_kpengeluaran' => $request->input('status_kpengeluaran') !== null ? true : false,
            'cabang_id' => session()->get('cabang_id'),
        ];
        KategoriPengeluaran::find($id)->update($data);
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
        KategoriPengeluaran::destroy($id);
        return response()->json('Berhasil hapus data', 200);
    }
}
