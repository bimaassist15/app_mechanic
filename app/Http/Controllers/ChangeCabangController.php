<?php

namespace App\Http\Controllers;

use App\Http\Requests\FormChangeCabangRequest;
use App\Models\Barang;
use App\Models\Cabang;
use App\Models\TransferDetail;
use App\Models\TransferStock;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ChangeCabangController extends Controller
{
    public function index(Request $request)
    {
        $cabang = Cabang::where('id', '<>', session()->get('cabang_id'))->get();
        $array_cabang = [];
        foreach ($cabang as $key => $item) {
            $array_cabang[] = [
                'id' => $item->id,
                'label' => '<strong>Nama Cabang: ' . $item->nama_cabang . '</strong> <br />
                <span>Alamat: ' . $item->nowa_cabang . '</span> <br />'
            ];
        }
        $action = url('changeCabang?_method=put');
        return view('changeCabang.index', compact('array_cabang', 'action'));
    }

    public function checkBarang(Request $request)
    {
        $cabang_id_penerima = $request->input('cabang_id_penerima');
        $getCabang = Cabang::find($cabang_id_penerima);

        $barang_id = $request->input('barang_id');
        $getBarang = Barang::find($barang_id);

        $checkBarang = Barang::where('barcode_barang', $getBarang->barcode_barang)
            ->where('cabang_id', $cabang_id_penerima)
            ->get()
            ->count();

        if ($checkBarang == 0) {
            return response()->json([
                'status' => 200,
                'message' => 'Barang tidak ditemukan pada Cabang: ' . $getCabang->nama_cabang,
                'result' => false,
            ]);
        } else {
            return response()->json([
                'status' => 200,
                'message' => 'Barang berhasil ditemukan',
                'result' => true,
            ]);
        }
    }

    public function update(FormChangeCabangRequest $request)
    {
        session()->put('cabang_id', $request->input('cabang_id'));
        return response()->json('Berhasil ganti cabang');
    }

    public function transferBarang(Request $request)
    {
        $transfer_stock = $request->input('transfer_stock');
        
        //next proses
        $createTransferStock = TransferStock::create($transfer_stock);
        $transfer_stock_id = $createTransferStock->id;

        $transfer_detail = $request->input('transfer_detail');
        $new_transfer_detail = [];
        foreach ($transfer_detail as $key => $item) {
            $new_transfer_detail[] = array_merge(
                $item,
                [
                    'transfer_stock_id' => $transfer_stock_id,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]
            );
        }
        TransferDetail::insert($new_transfer_detail);

        // memindahkan stock
        $cabang_id_awal = $transfer_stock['cabang_id_awal'];
        $cabang_id_penerima = $transfer_stock['cabang_id_penerima'];
        foreach ($transfer_detail as $key => $item) {
            $barang_id = $item['barang_id'];
            $qty = $item['qty_tdetail'];

            $getBarang = Barang::where('id', $barang_id)->first();
            $getBarangCabangPenerima = Barang::where('barcode_barang', $getBarang->barcode_barang)
                ->where('cabang_id', $cabang_id_penerima)
                ->first();

            if ($getBarangCabangPenerima) {
                $getBarangCabangPenerima->update([
                    'stok_barang' => $getBarangCabangPenerima->stok_barang + $qty,
                ]);
            }

            $getBarangCabangPemberi = Barang::where('barcode_barang', $getBarang->barcode_barang)
                ->where('cabang_id', $cabang_id_awal)
                ->first();

            if ($getBarangCabangPemberi) {
                $getBarangCabangPemberi->update([
                    'stok_barang' => $getBarangCabangPemberi->stok_barang - $qty,
                ]);
            }
        }


        return response()->json('Berhasil transfer barang');
    }
}
