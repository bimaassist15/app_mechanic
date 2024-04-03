<?php

namespace Modules\Transaction\Http\Controllers;

use App\Http\Helpers\UtilsHelper;
use App\Models\Barang;
use App\Models\Pembelian;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DataTables;

class PembelianController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Pembelian::dataTable()->with('supplier', 'users', 'users.profile');
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
                    data-urlcreate="' . url('transaction/pembelian/' . $row->id) . '"
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
        return view('transaction::pembelian.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('transaction::pembelian.form');
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
        $jsonRow = json_encode($row);
        return view('transaction::pembelian.detail', compact('row', 'jsonRow'));
    }

    public function print()
    {
        $pembelian = new Pembelian();
        $pembelian_id = request()->query('pembelian_id');
        $pembelian = $pembelian->invoicePembelian($pembelian_id);
        $myCabang = UtilsHelper::myCabang();

        return view('transaction::pembelian.print', compact('pembelian', 'myCabang'));
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
        $pembelian = new Pembelian();
        $getInvoice = $pembelian->invoicePembelian($id);
        foreach ($getInvoice->pembelianProduct as $key => $item) {
            $barang_id = $item->barang_id;
            $jumlah_pembelianproduct = $item->jumlah_pembelianproduct;

            $barang = Barang::find($barang_id);
            $barang->stok_barang = $barang->stok_barang - $jumlah_pembelianproduct;
            $barang->save();
        }

        Pembelian::destroy($id);
        return response()->json('Berhasil menghapus transaksi', 200);
    }
}
