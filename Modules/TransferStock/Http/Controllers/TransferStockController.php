<?php

namespace Modules\TransferStock\Http\Controllers;

use App\Http\Helpers\UtilsHelper;
use App\Models\Barang;
use App\Models\Cabang;
use App\Models\TransferDetail;
use App\Models\TransferStock;
use Faker\Provider\bn_BD\Utils;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class TransferStockController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        $cabang = Cabang::all();
        $array_cabang = [];
        foreach ($cabang as $key => $item) {
            $array_cabang[] = [
                'id' => $item->id,
                'label' => '<strong>Nama Cabang: ' . $item->nama_cabang . '</strong><br />
                <span>No. Wa: ' . $item->nowa_cabang . '</span>
                '
            ];
        }

        $kodeTStock = UtilsHelper::generateKodeTStock();
        $cabang_id = session()->get('cabang_id');
        $users_id = Auth::id();
        $barang = Barang::all();

        // if is edit
        $isEdit = $request->input('isEdit');
        $id = $request->input('id');
        // end if is edit


        $data = [
            'array_cabang' => $array_cabang,
            'kodeTStock' => $kodeTStock,
            'cabang_id' => $cabang_id,
            'users_id' => $users_id,
            'barang' => $barang,
            'isEdit' => $isEdit,
            'id' => $id,
        ];

        if ($request->ajax()) {
            if ($request->input('refresh')) {
                return response()->json($data);
            }

            if ($request->input('editData')) {
                $isEdit = $request->input('isEdit');
                $id = $request->input('id');
                $transferStock = new TransferStock();
                $dataTransferStock = $transferStock->getTransferStock()->find($id);

                return response()->json($dataTransferStock);
            }
        }

        return view('transferstock::index', $data);
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

    public function transferBarang(Request $request)
    {
        $transfer_edit = $request->input('transfer_edit');
        if ($transfer_edit['isEdit'] == true) {
            $id = $transfer_edit['id'];

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
        }
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
