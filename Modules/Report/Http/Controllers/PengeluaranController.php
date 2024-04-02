<?php

namespace Modules\Report\Http\Controllers;

use App\Http\Helpers\UtilsHelper;
use App\Models\KategoriPengeluaran;
use App\Models\TransaksiPengeluaran;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Master\Http\Requests\FormKPengeluaranRequest;
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
                ->addColumn('jumlah_tpendapatan', function ($row) {
                    return UtilsHelper::formatUang($row->jumlah_tpendapatan);
                })
                ->addColumn('tanggal_tpendapatan', function ($row) {
                    return UtilsHelper::formatDate($row->tanggal_tpendapatan);
                })
                ->addColumn('action', function ($row) {
                    $buttonUpdate = '
                    <a class="btn btn-warning btn-edit btn-sm" 
                    data-typemodal="mediumModal"
                    data-urlcreate="' . route('pendapatan.edit', $row->id) . '"
                    data-modalId="mediumModal"
                    >
                        <i class="fa-solid fa-pencil"></i>
                    </a>
                    ';
                    $buttonDelete = '
                    <button type="button" class="btn-delete btn btn-danger btn-sm" data-url="' . url('report/pendapatan/' . $row->id) . '?_method=delete">
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
        return view('report::pendapatan.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $action = route('pendapatan.store');
        $kategoriPengeluaran = KategoriPengeluaran::dataTable()->where('status_kpendapatan', true)->get();
        $array_kategori_pendapatan = [];
        foreach ($kategoriPengeluaran as $key => $item) {
            $array_kategori_pendapatan[] = [
                'id' => $item->id,
                'label' => $item->nama_kpendapatan,
            ];
        }
        return view('report::pendapatan.form', compact('action', 'array_kategori_pendapatan'));
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
            'kategori_pendapatan_id' => $request->input('kategori_pendapatan_id'),
            'jumlah_tpendapatan' => $request->input('jumlah_tpendapatan'),
            'tanggal_tpendapatan' => $request->input('tanggal_tpendapatan'),
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
        $action = url('report/pendapatan/' . $id . '?_method=put');
        $row = TransaksiPengeluaran::find($id);
        $kategoriPengeluaran = KategoriPengeluaran::dataTable()->where('status_kpendapatan', true)->get();
        $array_kategori_pendapatan = [];
        foreach ($kategoriPengeluaran as $key => $item) {
            $array_kategori_pendapatan[] = [
                'id' => $item->id,
                'label' => $item->nama_kpendapatan,
            ];
        }
        return view('report::pendapatan.form', compact('action', 'row', 'array_kategori_pendapatan'));
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
            'kategori_pendapatan_id' => $request->input('kategori_pendapatan_id'),
            'jumlah_tpendapatan' => $request->input('jumlah_tpendapatan'),
            'tanggal_tpendapatan' => $request->input('tanggal_tpendapatan'),
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
