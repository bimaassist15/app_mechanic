<?php

namespace Modules\Master\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Satuan;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DataTables;
use Illuminate\Support\Facades\Config;
use Modules\Master\Http\Requests\FormBarangRequest;
use Modules\Master\Http\Requests\FormBarangUpdateRequest;

class BarangController extends Controller
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
            $data = Barang::dataTable()->with('kategori', 'satuan');
            return DataTables::eloquent($data)
                ->addColumn('hargajual_barang', function ($row) {
                    $output = number_format($row->hargajual_barang, '0', ',', '.');
                    return $output;
                })
                ->addColumn('stok_barang', function ($row) {
                    $output = number_format($row->stok_barang, '0', ',', '.');
                    return $output;
                })
                ->addColumn('action', function ($row) {
                    $buttonDetail = '
                    <a class="btn btn-info btn-detail btn-sm" 
                    data-typemodal="extraLargeModal"
                    data-urlcreate="' . url('master/barang/' . $row->id) . '"
                    data-modalId="extraLargeModal"
                    >
                        <i class="fa-solid fa-eye"></i>
                    </a>
                    ';

                    $button = '
                <div class="text-center">
                    ' . $buttonDetail . '
                </div>
                ';
                    return $button;
                })
                ->rawColumns(['action'])
                ->toJson();
        }
        return view('master::barang.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $action = url('master/barang');
        $status_barang = $this->datastatis['status_barang'];
        $status_serial = $this->datastatis['status_serial'];
        $kategori = Kategori::dataTable()->where('status_kategori', true)->get();
        $array_kategori = [];
        foreach ($kategori as $key => $item) {
            $array_kategori[] = [
                'id' => $item->id,
                'label' => $item->nama_kategori,
            ];
        }
        $satuan = Satuan::dataTable()->where('status_satuan', true)->get();
        $array_satuan = [];
        foreach ($satuan as $key => $item) {
            $array_satuan[] = [
                'id' => $item->id,
                'label' => $item->nama_satuan,
            ];
        }
        $array_status_barang = [];
        foreach ($status_barang as $key => $item) {
            $array_status_barang[] = [
                'id' => $key,
                'label' => $item,
            ];
        }

        $array_status_serial = [];
        foreach ($status_serial as $key => $item) {
            $array_status_serial[] = [
                'id' => $key,
                'label' => $item,
            ];
        }
        return view('master::barang.form', compact('action', 'array_status_barang', 'array_status_serial', 'array_kategori', 'array_satuan'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(FormBarangRequest $request)
    {
        //
        $data = [
            'barcode_barang' => $request->input('barcode_barang'),
            'nama_barang' => $request->input('nama_barang'),
            'satuan_id' => $request->input('satuan_id'),
            'deskripsi_barang' => $request->input('deskripsi_barang'),
            'snornonsn_barang' => $request->input('snornonsn_barang'),
            'stok_barang' => $request->input('stok_barang'),
            'hargajual_barang' => $request->input('hargajual_barang'),
            'lokasi_barang' => $request->input('lokasi_barang'),
            'kategori_id' => $request->input('kategori_id'),
            'status_barang' => $request->input('status_barang'),
            'cabang_id' => session()->get('cabang_id'),
        ];
        Barang::create($data);
        return response()->json('Berhasil tambah data', 201);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $row = Barang::with('kategori', 'satuan')->find($id);
        return view('master::barang.detail', compact('row'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $action = url('master/barang/' . $id . '?_method=put');
        $status_barang = $this->datastatis['status_barang'];
        $status_serial = $this->datastatis['status_serial'];
        $row = Barang::find($id);
        $kategori = Kategori::dataTable()->where('status_kategori', true)->get();
        $array_kategori = [];
        foreach ($kategori as $key => $item) {
            $array_kategori[] = [
                'id' => $item->id,
                'label' => $item->nama_kategori,
            ];
        }
        $satuan = Satuan::dataTable()->where('status_satuan', true)->get();
        $array_satuan = [];
        foreach ($satuan as $key => $item) {
            $array_satuan[] = [
                'id' => $item->id,
                'label' => $item->nama_satuan,
            ];
        }
        $array_status_barang = [];
        foreach ($status_barang as $key => $item) {
            $array_status_barang[] = [
                'id' => $key,
                'label' => $item,
            ];
        }

        $array_status_serial = [];
        foreach ($status_serial as $key => $item) {
            $array_status_serial[] = [
                'id' => $key,
                'label' => $item,
            ];
        }
        return view('master::barang.form', compact('action', 'array_status_barang', 'array_status_serial', 'row', 'array_kategori', 'array_satuan'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(FormBarangUpdateRequest $request, $id)
    {
        //
        $data = [
            'barcode_barang' => $request->input('barcode_barang'),
            'nama_barang' => $request->input('nama_barang'),
            'satuan_id' => $request->input('satuan_id'),
            'deskripsi_barang' => $request->input('deskripsi_barang'),
            'snornonsn_barang' => $request->input('snornonsn_barang'),
            'stok_barang' => $request->input('stok_barang'),
            'hargajual_barang' => $request->input('hargajual_barang'),
            'lokasi_barang' => $request->input('lokasi_barang'),
            'kategori_id' => $request->input('kategori_id'),
            'status_barang' => $request->input('status_barang'),
            'cabang_id' => session()->get('cabang_id'),
        ];
        Barang::find($id)->update($data);
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
        Barang::destroy($id);
        return response()->json('Berhasil hapus data', 200);
    }
}
