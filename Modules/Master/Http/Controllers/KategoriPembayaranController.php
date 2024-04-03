<?php

namespace Modules\Master\Http\Controllers;

use App\Models\KategoriPembayaran;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Master\Http\Requests\FormKPembayaranRequest;
use DataTables;
use Illuminate\Support\Facades\Config;

class KategoriPembayaranController extends Controller
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
            $data = KategoriPembayaran::dataTable();
            return DataTables::eloquent($data)
                ->addColumn('status_kpembayaran', function ($row) {
                    $output = $row->status_kpembayaran ? '<i class="fa-solid fa-check"></i>' : '<i class="fa-solid fa-circle-xmark"></i>';
                    return '<div class="text-center">
                ' . $output . '
                </div>';
                })
                ->addColumn('action', function ($row) {
                    $buttonUpdate = '
                    <a class="btn btn-warning btn-edit btn-sm" 
                    data-typemodal="mediumModal"
                    data-urlcreate="' . url('master/kategoriPembayaran/' . $row->id . '/edit') . '"
                    data-modalId="mediumModal"
                    >
                        <i class="fa-solid fa-pencil"></i>
                    </a>
                    ';
                    $buttonDelete = '
                    <button type="button" class="btn-delete btn btn-danger btn-sm" data-url="' . url('master/kategoriPembayaran/' . $row->id) . '?_method=delete">
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
                ->rawColumns(['action', 'status_kpembayaran'])
                ->toJson();
        }
        return view('master::kategoriPembayaran.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $action = url('master/kategoriPembayaran');
        $array_tipe_pembayaran = [];
        foreach ($this->datastatis['tipe_pembayaran'] as $value => $item) {
            $array_tipe_pembayaran[] = [
                'id' => $value,
                'label' => $item
            ];
        }
        return view('master::kategoriPembayaran.form', compact('action', 'array_tipe_pembayaran'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(FormKPembayaranRequest $request)
    {
        //
        $data = [
            'nama_kpembayaran' => $request->input('nama_kpembayaran'),
            'tipe_kpembayaran' => $request->input('tipe_kpembayaran'),
            'status_kpembayaran' => $request->input('status_kpembayaran') !== null ? true : false,
            'cabang_id' => session()->get('cabang_id'),
        ];
        KategoriPembayaran::create($data);
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
        $action = url('master/kategoriPembayaran/' . $id . '?_method=put');
        $array_tipe_pembayaran = [];
        foreach ($this->datastatis['tipe_pembayaran'] as $value => $item) {
            $array_tipe_pembayaran[] = [
                'id' => $value,
                'label' => $item
            ];
        }
        $row = KategoriPembayaran::find($id);
        return view('master::kategoriPembayaran.form', compact('action', 'row', 'array_tipe_pembayaran'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(FormKPembayaranRequest $request, $id)
    {
        //
        $data = [
            'nama_kpembayaran' => $request->input('nama_kpembayaran'),
            'tipe_kpembayaran' => $request->input('tipe_kpembayaran'),
            'status_kpembayaran' => $request->input('status_kpembayaran') !== null ? true : false,
            'cabang_id' => session()->get('cabang_id'),
        ];
        KategoriPembayaran::find($id)->update($data);
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
        KategoriPembayaran::destroy($id);
        return response()->json('Berhasil hapus data', 200);
    }
}
