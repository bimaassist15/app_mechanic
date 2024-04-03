<?php

namespace Modules\Report\Http\Controllers;

use App\Http\Helpers\UtilsHelper;
use App\Models\KategoriPengeluaran;
use App\Models\TransaksiPengeluaran;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Master\Http\Requests\FormPengeluaranRequest;
use DataTables;
use Illuminate\Support\Facades\Config;

class PengeluaranController extends Controller
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
            $transaksiPengeluaran = new TransaksiPengeluaran();
            $data = $transaksiPengeluaran->getPengeluaran();
            return DataTables::eloquent($data)
                ->addColumn('jumlah_tpengeluaran', function ($row) {
                    return UtilsHelper::formatUang($row->jumlah_tpengeluaran);
                })
                ->addColumn('tanggal_tpengeluaran', function ($row) {
                    return UtilsHelper::formatDate($row->tanggal_tpengeluaran);
                })
                ->addColumn('action', function ($row) {
                    $buttonUpdate = '
                    <a class="btn btn-warning btn-edit btn-sm" 
                    data-typemodal="mediumModal"
                    data-urlcreate="' . url('report/pengeluaran/' . $row->id . '/edit') . '"
                    data-modalId="mediumModal"
                    >
                        <i class="fa-solid fa-pencil"></i>
                    </a>
                    ';
                    $buttonDelete = '
                    <button type="button" class="btn-delete btn btn-danger btn-sm" data-url="' . url('report/pengeluaran/' . $row->id) . '?_method=delete">
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
                ->rawColumns(['action'])
                ->toJson();
        }
        return view('report::pengeluaran.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $action = url('report/pengeluaran');
        $kategoriPengeluaran = KategoriPengeluaran::dataTable()->where('status_kpengeluaran', true)->get();
        $array_kategori_pengeluaran = [];
        foreach ($kategoriPengeluaran as $key => $item) {
            $array_kategori_pengeluaran[] = [
                'id' => $item->id,
                'label' => $item->nama_kpengeluaran,
            ];
        }
        return view('report::pengeluaran.form', compact('action', 'array_kategori_pengeluaran'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(FormPengeluaranRequest $request)
    {
        //
        $data = [
            'kategori_pengeluaran_id' => $request->input('kategori_pengeluaran_id'),
            'jumlah_tpengeluaran' => $request->input('jumlah_tpengeluaran'),
            'tanggal_tpengeluaran' => $request->input('tanggal_tpengeluaran'),
            'cabang_id' => session()->get('cabang_id'),
        ];
        TransaksiPengeluaran::create($data);
        return response()->json('Berhasil tambah data', 201);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('report::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $action = url('report/pengeluaran/' . $id . '?_method=put');
        $row = TransaksiPengeluaran::find($id);
        $kategoriPengeluaran = KategoriPengeluaran::dataTable()->where('status_kpengeluaran', true)->get();
        $array_kategori_pengeluaran = [];
        foreach ($kategoriPengeluaran as $key => $item) {
            $array_kategori_pengeluaran[] = [
                'id' => $item->id,
                'label' => $item->nama_kpengeluaran,
            ];
        }
        return view('report::pengeluaran.form', compact('action', 'row', 'array_kategori_pengeluaran'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(FormPengeluaranRequest $request, $id)
    {
        //
        $data = [
            'kategori_pengeluaran_id' => $request->input('kategori_pengeluaran_id'),
            'jumlah_tpengeluaran' => $request->input('jumlah_tpengeluaran'),
            'tanggal_tpengeluaran' => $request->input('tanggal_tpengeluaran'),
            'cabang_id' => session()->get('cabang_id'),
        ];
        TransaksiPengeluaran::find($id)->update($data);
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
        TransaksiPengeluaran::destroy($id);
        return response()->json('Berhasil hapus data', 200);
    }
}
