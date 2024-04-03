<?php

namespace Modules\Master\Http\Controllers;

use App\Models\HargaServis;
use App\Models\KategoriServis;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DataTables;
use Modules\Master\Http\Requests\FormHargaServisRequest;
use Modules\Master\Http\Requests\FormHargaServisUpdateRequest;

class HargaServisController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = HargaServis::dataTable()->with('kategoriServis');
            return DataTables::eloquent($data)
                ->addColumn('status_hargaservis', function ($row) {
                    $output = $row->status_hargaservis ? '<i class="fa-solid fa-check"></i>' : '<i class="fa-solid fa-circle-xmark"></i>';
                    return '<div class="text-center">
                ' . $output . '
                </div>';
                })
                ->addColumn('total_hargaservis', function ($row) {
                    $output = number_format($row->total_hargaservis, 0, '.', ',');
                    return $output;
                })
                ->addColumn('action', function ($row) {
                    $buttonUpdate = '
                    <a class="btn btn-warning btn-edit btn-sm" 
                    data-typemodal="extraLargeModal"
                    data-urlcreate="' . url('master/hargaServis/' . $row->id . '/edit') . '"
                    data-modalId="extraLargeModal"
                    >
                        <i class="fa-solid fa-pencil"></i>
                    </a>
                    ';
                    $buttonDelete = '
                    <button type="button" class="btn-delete btn btn-danger btn-sm" data-url="' . url('master/hargaServis/' . $row->id) . '?_method=delete">
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
                ->rawColumns(['action', 'status_hargaservis'])
                ->toJson();
        }
        return view('master::hargaServis.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $kategoriServis = KategoriServis::dataTable()->where('status_kservis', true)->get();
        $array_kategori_servis = [];
        foreach ($kategoriServis as $key => $value) {
            $array_kategori_servis[] = [
                'id' => $value->id,
                'label' => $value->nama_kservis,
            ];
        }
        $action = url('master/hargaServis');
        return view('master::hargaServis.form', compact('array_kategori_servis', 'action'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(FormHargaServisRequest $request)
    {
        // 
        $data = [
            'kode_hargaservis' => $request->input('kode_hargaservis'),
            'nama_hargaservis' => $request->input('nama_hargaservis'),
            'jasa_hargaservis' => $request->input('jasa_hargaservis'),
            'deskripsi_hargaservis' => $request->input('deskripsi_hargaservis'),
            'profit_hargaservis' => $request->input('profit_hargaservis'),
            'total_hargaservis' => $request->input('total_hargaservis'),
            'status_hargaservis' => $request->input('status_hargaservis') !== null ? true : false,
            'kategori_servis_id' => $request->input('kategori_servis_id'),
            'cabang_id' => session()->get('cabang_id'),
        ];
        HargaServis::create($data);
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
        $kategoriServis = KategoriServis::dataTable()->where('status_kservis', true)->get();
        $array_kategori_servis = [];
        foreach ($kategoriServis as $key => $value) {
            $array_kategori_servis[] = [
                'id' => $value->id,
                'label' => $value->nama_kservis,
            ];
        }
        $action = url('master/hargaServis/' . $id . '?_method=put');
        $row = HargaServis::with('kategoriServis')->find($id);
        return view('master::hargaServis.form', compact('array_kategori_servis', 'action', 'row'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(FormHargaServisUpdateRequest $request, $id)
    {
        //
        $data = [
            'kode_hargaservis' => $request->input('kode_hargaservis'),
            'nama_hargaservis' => $request->input('nama_hargaservis'),
            'jasa_hargaservis' => $request->input('jasa_hargaservis'),
            'deskripsi_hargaservis' => $request->input('deskripsi_hargaservis'),
            'profit_hargaservis' => $request->input('profit_hargaservis'),
            'total_hargaservis' => $request->input('total_hargaservis'),
            'status_hargaservis' => $request->input('status_hargaservis') !== null ? true : false,
            'kategori_servis_id' => $request->input('kategori_servis_id'),
            'cabang_id' => session()->get('cabang_id'),
        ];
        HargaServis::find($id)->update($data);
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
        HargaServis::destroy($id);
        return response()->json('Berhasil hapus data', 200);
    }
}
