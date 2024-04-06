<?php

namespace Modules\Transaction\Http\Controllers;

use App\Http\Helpers\UtilsHelper;
use App\Models\Pembelian;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DataTables;
use Illuminate\Support\Facades\Config;
use Modules\Transaction\Http\Requests\FormJatuhTempoRequest;

class BelumLunasController extends Controller
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
            $data = Pembelian::dataTable()->with('supplier', 'users', 'users.profile')
                ->where('tipe_pembelian', 'hutang');
            return DataTables::eloquent($data)
                ->addColumn('transaksi_pembelian', function ($row) {
                    $output = UtilsHelper::tanggalBulanTahunKonversi($row->transaksi_pembelian);
                    return $output;
                })
                ->addColumn('total_pembelian', function ($row) {
                    $output = UtilsHelper::formatUang($row->total_pembelian);
                    return $output;
                })
                ->addColumn('supplier', function ($row) {
                    $output = $row->supplier->nama_supplier ?? 'Umum';
                    return $output;
                })
                ->addColumn('action', function ($row) {
                    $buttonDetail = '
                    <a class="btn btn-info btn-detail btn-sm" 
                    data-typemodal="extraLargeModal"
                    data-urlcreate="' . url('transaction/belumLunas/' . $row->id . '/show') . '"
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
        return view('transaction::belumLunas.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('transaction::belumLunas.form');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $pembelian = new Pembelian();
        $row = $pembelian->invoicePembelian($id);
        $pesanwa_hutangsupplier = $this->datastatis['pesanwa_hutangsupplier'];
        return view('transaction::belumLunas.detail', compact('row', 'pesanwa_hutangsupplier'));
    }

    public function jatuhTempo($id)
    {
        $penjualan = new Pembelian();
        $row = $penjualan->invoicePembelian($id);
        $action = url('transaction/belumLunas/' . $id . '/jatuhTempo?_method=put');
        return view('transaction::belumLunas.jatuhTempo', compact('row', 'action'));
    }

    public function updateJatuhTempo(FormJatuhTempoRequest $request, $id)
    {
        $pembelian = Pembelian::find($id);
        $pembelian->jatuhtempo_pembelian = $request->input('jatuhtempo_pembelian');
        $pembelian->keteranganjtempo_pembelian = $request->input('keteranganjtempo_pembelian');
        $pembelian->isinfojtempo_pembelian = false;
        $pembelian->save();

        return response()->json('Berhasil update jatuh tempo');
    }

    public function updateRemember($id)
    {
        $pembelian = Pembelian::find($id);
        $pembelian->isinfojtempo_pembelian = true;
        $pembelian->save();

        return response()->json('Supplier Telah berhasil diingatkan');
    }

    public function print()
    {
        return view('transaction::belumLunas.print');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('transaction::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
