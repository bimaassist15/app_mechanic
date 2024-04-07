<?php

namespace Modules\TransferStock\Http\Controllers;

use App\Http\Helpers\UtilsHelper;
use App\Models\Barang;
use App\Models\TransferStock;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DataTables;

class StockKeluarController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $transferKeluar = new TransferStock();
            $data = $transferKeluar->getTransferStock()
                ->where('cabang_id_awal', session()->get('cabang_id'));

            return DataTables::eloquent($data)

                ->addColumn('created_at', function ($row) {
                    return UtilsHelper::tanggalBulanTahunKonversi($row->created_at);
                })
                ->addColumn('action', function ($row) {
                    $buttonDetail = '
                    <a class="btn btn-info btn-detail btn-sm" 
                    data-typemodal="extraLargeModal"
                    data-urlcreate="' . url('transferStock/keluar/' . $row->id) . '"
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
        return view('transferstock::stokKeluar.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('stokKeluar::create');
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
        $transferKeluar = new TransferStock();
        $row = $transferKeluar->getTransferStock()->find($id);

        return view('transferstock::stokKeluar.detail', compact('row'));
    }

    public function print($id)
    {
        $transferKeluar = new TransferStock();
        $row = $transferKeluar->getTransferStock()->find($id);

        return view('transferstock::stokKeluar.print', compact('row'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('stokKeluar::edit');
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
        $getTransferStock = new TransferStock();
        $data = $getTransferStock->getTransferStock()->find($id);

        // rollback stok
        $cabang_id_penerima = $data->cabang_id_penerima;
        $cabang_id_awal = $data->cabang_id_awal;

        foreach ($data->transferDetail as $key => $item) {
            $barang_id = $item->barang_id;
            $qty = $item->qty_tdetail;

            $getBarang = Barang::where('id', $barang_id)->first();
            $getBarangCabangPenerima = Barang::where('barcode_barang', $getBarang->barcode_barang)
                ->where('cabang_id', $cabang_id_penerima)
                ->first();

            if ($getBarangCabangPenerima) {
                $getBarangCabangPenerima->update([
                    'stok_barang' => $getBarangCabangPenerima->stok_barang - $qty,
                ]);
            }

            $getBarangCabangPemberi = Barang::where('barcode_barang', $getBarang->barcode_barang)
                ->where('cabang_id', $cabang_id_awal)
                ->first();

            if ($getBarangCabangPemberi) {
                $getBarangCabangPemberi->update([
                    'stok_barang' => $getBarangCabangPemberi->stok_barang + $qty,
                ]);
            }
        }

        $data->delete();
        return response()->json('Berhasil hapus data');
    }

    public function checkStatus(Request $request)
    {
        $id = $request->input('id');

        $getTransferStock = new TransferStock();
        $data = $getTransferStock->getTransferStock()
            ->find($id);
        $statusAllowed = ['proses kirim'];
        
        if (in_array($data->status_tstock, $statusAllowed)) {
            return response()->json([
                'status' => 200,
                'message' => "Transaksi ini dapat diproses",
                'result' => true,
            ]);
        } else {
            return response()->json([
                'status' => 200,
                'message' => "Transaksi ini sudah ditangani oleh cabang penerima",
                'result' => false,
            ]);
        }
    }
}
