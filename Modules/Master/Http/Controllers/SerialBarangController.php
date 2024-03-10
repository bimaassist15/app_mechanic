<?php

namespace Modules\Master\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Satuan;
use App\Models\SerialBarang;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DataTables;
use Illuminate\Support\Facades\Config;
use Modules\Master\Http\Requests\FormSerialBarangRequest;

class SerialBarangController extends Controller
{
    public $datastatis;
    public function __construct()
    {
        $this->datastatis = Config::get('datastatis');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $barang_id = $request->query('barang_id');
            $data = SerialBarang::dataTable()->where('barang_id', $barang_id);

            return DataTables::eloquent($data)
                ->addColumn('action', function ($row) use ($barang_id) {
                    $buttonUpdate =
                        '
                    <a class="btn btn-warning btn-edit btn-sm"
                    data-typemodal="mediumModal"
                    data-urlcreate="' .
                        url('master/serialBarang/' . $row->id . '/edit?barang_id=' . $barang_id) .
                        '"
                    data-modalId="mediumModal"
                    >
                        <i class="fa-solid fa-pencil"></i>
                    </a>
                    ';
                    $buttonDelete =
                        '
                    <button type="button" class="btn-delete btn btn-danger btn-sm" data-url="' .
                        url('master/serialBarang/' . $row->id) .
                        '?_method=delete&barang_id=' .
                        $barang_id .
                        '">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                    ';

                    $button =
                        '
                <div class="text-center">
                    ' .
                        $buttonUpdate .
                        '
                    ' .
                        $buttonDelete .
                        '
                </div>
                ';
                    return $button;
                })
                ->rawColumns(['action'])
                ->toJson();
        }
        $barang = Barang::find($request->query('barang_id'));
        return view('master::serialBarang.index', compact('barang'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $barang_id = request()->query('barang_id');
        $barang = Barang::find($barang_id);
        $serialBarang = SerialBarang::dataTable()->where('barang_id', $barang_id)->get()->count();

        $formCount = $barang->stok_barang - $serialBarang;
        $formCount = $formCount < 0 ? 0 : $formCount;

        $status_serial_barang = $this->datastatis['status_serial_barang'];
        $array_status_serial_barang = [];
        foreach ($status_serial_barang as $value => $item) {
            $array_status_serial_barang[] = [
                'id' => $value,
                'label' => $item,
            ];
        }
        $action = url('master/serialBarang?barang_id=' . $barang_id);
        return view('master::serialBarang.form', compact('action', 'formCount', 'array_status_serial_barang'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(FormSerialBarangRequest $request)
    {
        //
        $nomor_serial_barang = json_decode($request->input('nomor_serial_barang'));
        $status_serial_barang = json_decode($request->input('status_serial_barang'));
        $data = [];
        foreach ($nomor_serial_barang as $index => $value) {
            $data[] = [
                'nomor_serial_barang' => $value,
                'status_serial_barang' => $status_serial_barang[$index],
                'barang_id' => $request->query('barang_id'),
                'cabang_id' => session()->get('cabang_id'),
            ];
        }

        SerialBarang::insert($data);
        return response()->json('Berhasil tambah data', 201);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $barang_id = request()->query('barang_id');
        $status_serial_barang = $this->datastatis['status_serial_barang'];
        $array_status_serial_barang = [];
        foreach ($status_serial_barang as $value => $item) {
            $array_status_serial_barang[] = [
                'id' => $value,
                'label' => $item,
            ];
        }
        $action = url('master/serialBarang/' . $id . '?barang_id=' . $barang_id . '&_method=put');
        $row = SerialBarang::find($id);
        $formCount = 1;
        return view('master::serialBarang.form', compact('action', 'array_status_serial_barang', 'row', 'formCount'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(FormSerialBarangRequest $request, $id)
    {
        //
        $nomor_serial_barang = json_decode($request->input('nomor_serial_barang'));
        $status_serial_barang = json_decode($request->input('status_serial_barang'));
        $data = [];
        foreach ($nomor_serial_barang as $index => $value) {
            $data = [
                'nomor_serial_barang' => $value,
                'status_serial_barang' => $status_serial_barang[$index],
                'barang_id' => $request->query('barang_id'),
                'cabang_id' => session()->get('cabang_id'),
            ];
        }

        SerialBarang::find($id)->update($data);
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
        SerialBarang::destroy($id);
        return response()->json('Berhasil hapus data', 200);
    }
}
