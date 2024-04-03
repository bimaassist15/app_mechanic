<?php

namespace Modules\Master\Http\Controllers;

use App\Models\KategoriPembayaran;
use App\Models\SubPembayaran;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Master\Http\Requests\FormKPembayaranRequest;
use DataTables;
use Illuminate\Support\Facades\Config;
use Modules\Master\Http\Requests\FormSPembayaranRequest;

class SubPembayaranController extends Controller
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
            $kategori_pembayaran_id = $request->query('kategori_pembayaran_id');
            $data = SubPembayaran::dataTable()->with('kategoriPembayaran');
            if ($kategori_pembayaran_id !== '' && $kategori_pembayaran_id !== null) {
                $data->where('kategori_pembayaran_id', $kategori_pembayaran_id);
            }
            return DataTables::eloquent($data)
                ->addColumn('status_spembayaran', function ($row) {
                    $output = $row->status_spembayaran ? '<i class="fa-solid fa-check"></i>' : '<i class="fa-solid fa-circle-xmark"></i>';
                    return '<div class="text-center">
                ' . $output . '
                </div>';
                })
                ->addColumn('action', function ($row) {
                    $buttonUpdate = '
                    <a class="btn btn-warning btn-edit btn-sm" 
                    data-typemodal="mediumModal"
                    data-urlcreate="' . url('master/subPembayaran/' . $row->id . '/edit') . '"
                    data-modalId="mediumModal"
                    >
                        <i class="fa-solid fa-pencil"></i>
                    </a>
                    ';
                    $buttonDelete = '
                    <button type="button" class="btn-delete btn btn-danger btn-sm" data-url="' . url('master/subPembayaran/' . $row->id) . '?_method=delete">
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
                ->rawColumns(['action', 'status_spembayaran'])
                ->toJson();
        }
        $array_kategori_pembayaran = [];
        $kategoriPembayaran = KategoriPembayaran::dataTable()->where('status_kpembayaran', true)
            ->whereNot('nama_kpembayaran', 'like', '%deposit%')
            ->get();
        foreach ($kategoriPembayaran as $value => $item) {
            $array_kategori_pembayaran[] = [
                'id' => $item->id,
                'label' => $item->nama_kpembayaran
            ];
        }
        return view('master::subPembayaran.index', compact('array_kategori_pembayaran'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $action = url('master/subPembayaran');
        $array_kategori_pembayaran = [];
        $kategoriPembayaran = KategoriPembayaran::dataTable()->where('status_kpembayaran', true)->whereNot('nama_kpembayaran', 'like', '%deposit%')->get();
        foreach ($kategoriPembayaran as $value => $item) {
            $array_kategori_pembayaran[] = [
                'id' => $item->id,
                'label' => $item->nama_kpembayaran
            ];
        }
        return view('master::subPembayaran.form', compact('action', 'array_kategori_pembayaran'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(FormSPembayaranRequest $request)
    {
        //
        $data = [
            'nama_spembayaran' => $request->input('nama_spembayaran'),
            'kategori_pembayaran_id' => $request->input('kategori_pembayaran_id'),
            'status_spembayaran' => $request->input('status_spembayaran') !== null ? true : false,
            'cabang_id' => session()->get('cabang_id'),
        ];
        SubPembayaran::create($data);
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
        $action = url('master/subPembayaran/' . $id . '?_method=put');
        $array_kategori_pembayaran = [];
        $kategoriPembayaran = KategoriPembayaran::dataTable()->where('status_kpembayaran', true)->whereNot('nama_kpembayaran', 'like', '%deposit%')->get();
        foreach ($kategoriPembayaran as $value => $item) {
            $array_kategori_pembayaran[] = [
                'id' => $item->id,
                'label' => $item->nama_kpembayaran
            ];
        }
        $row = SubPembayaran::find($id);
        return view('master::subPembayaran.form', compact('action', 'row', 'array_kategori_pembayaran'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(FormSPembayaranRequest $request, $id)
    {
        //
        $data = [
            'nama_spembayaran' => $request->input('nama_spembayaran'),
            'kategori_pembayaran_id' => $request->input('kategori_pembayaran_id'),
            'status_spembayaran' => $request->input('status_spembayaran') !== null ? true : false,
            'cabang_id' => session()->get('cabang_id'),
        ];
        SubPembayaran::find($id)->update($data);
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
        SubPembayaran::destroy($id);
        return response()->json('Berhasil hapus data', 200);
    }
}
