<?php

namespace Modules\Service\Http\Controllers;

use App\Models\Barang;
use App\Models\OrderBarang;
use App\Models\PenerimaanServis;
use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;


class OrderBarangController extends Controller
{
    public function index(Request $request)
    {
        $order = new OrderBarang();
        $penerimaan_servis_id = $request->input('penerimaan_servis_id');
        $getOrder = $order->getOrderBarang()->where('penerimaan_servis_id', $penerimaan_servis_id)->get();
        $totalHargaBarang = $getOrder->sum('subtotal_orderbarang');

        return response()->json([
            'result' => $getOrder,
            'totalHargaBarang' => $totalHargaBarang,
        ], 200);
    }


    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $OrderBarang = OrderBarang::create($request->all());
        $id = $OrderBarang->id;

        $order = new OrderBarang();
        $getOrderBarang = $order->getOrderBarang()->find($id);
        $jumlahHarga = $getOrderBarang->barang->hargajual_barang;

        $penerimaan_servis_id = $request->input('penerimaan_servis_id');
        $modelPenerimaanServis = PenerimaanServis::find($penerimaan_servis_id);

        // barang
        if ($modelPenerimaanServis->status_pservis != 'estimasi servis') {
            $qty_orderbarang = $request->input('qty_orderbarang');
            $barang_id = $request->input('barang_id');
            $barang = Barang::find($barang_id);
            $barang->stok_barang = floatval($barang->stok_barang) - floatval($qty_orderbarang);
            $barang->save();
        }
        // end barang

        // penerimaan servis
        $penerimaan_servis_id = $request->input('penerimaan_servis_id');
        $getPenerimaanServis = PenerimaanServis::find($penerimaan_servis_id);
        $getPenerimaanServis->totalbiaya_pservis = $getPenerimaanServis->totalbiaya_pservis + $jumlahHarga;
        $getPenerimaanServis->save();
        // end penerimaan servis

        // handle hutang dan kembalian
        $getPenerimaanServis = PenerimaanServis::find($penerimaan_servis_id);
        $deposit = $getPenerimaanServis->total_dppservis;
        $totalBiaya = $getPenerimaanServis->totalbiaya_pservis;
        $kalkulasi = $deposit - $totalBiaya;
        $hutang = 0;
        $kembalian = 0;
        if ($kalkulasi < 0) {
            $hutang = abs($kalkulasi);
            $kembalian = 0;
        } else {
            $hutang = 0;
            $kembalian = $kalkulasi;
        }
        $getPenerimaanServis->kembalian_pservis = $kembalian;
        $getPenerimaanServis->hutang_pservis = $hutang;
        $getPenerimaanServis->save();
        // end handle hutang dan kembalian

        $getOrder = $order->getOrderBarang()->where('penerimaan_servis_id', $penerimaan_servis_id)->get();
        $totalHargaBarang = $getOrder->sum('subtotal_orderbarang');

        return response()->json([
            'result' => $getOrder,
            'totalHargaBarang' => $totalHargaBarang,
        ], 201);
    }

    public function edit($id)
    {
    }

    public function update(Request $request, $id)
    {
        $data = $request->except(['id', '_method']);
        $getOrderBarang = OrderBarang::find($id);

        $penerimaan_servis_id = $getOrderBarang->penerimaan_servis_id;

        // penerimaan servis
        $getPenerimaanServis = PenerimaanServis::find($penerimaan_servis_id);
        $getPenerimaanServis->totalbiaya_pservis = $getPenerimaanServis->totalbiaya_pservis - $getOrderBarang->subtotal_orderbarang;
        $getPenerimaanServis->save();
        // end penerimaan servis

        // penerimaan servis 2
        $getPenerimaanServis = PenerimaanServis::find($penerimaan_servis_id);
        $getPenerimaanServis->totalbiaya_pservis = $getPenerimaanServis->totalbiaya_pservis + doubleval($data['subtotal_orderbarang']);
        $getPenerimaanServis->save();
        // end penerimaan servis 2

        // handle hutang dan kembalian
        $getPenerimaanServis = PenerimaanServis::find($penerimaan_servis_id);
        $deposit = $getPenerimaanServis->total_dppservis;
        $totalBiaya = $getPenerimaanServis->totalbiaya_pservis;
        $kalkulasi = $deposit - $totalBiaya;
        $hutang = 0;
        $kembalian = 0;
        if ($kalkulasi < 0) {
            $hutang = abs($kalkulasi);
            $kembalian = 0;
        } else {
            $hutang = 0;
            $kembalian = $kalkulasi;
        }
        $getPenerimaanServis->kembalian_pservis = $kembalian;
        $getPenerimaanServis->hutang_pservis = $hutang;
        $getPenerimaanServis->save();
        // end handle hutang dan kembalian

        // update stock barang
        $getPenerimaanServis = PenerimaanServis::find($penerimaan_servis_id);
        if ($getPenerimaanServis->status_pservis != 'estimasi servis') {
            $barang_id = $getOrderBarang->barang_id;
            $qty_orderbarang = $data['qty_orderbarang'];
            // barang 1
            $jumlah_qty_orderbarang = $getOrderBarang->qty_orderbarang;
            $barang = Barang::find($barang_id);
            $barang->stok_barang = $barang->stok_barang + $jumlah_qty_orderbarang;
            $barang->save();
            // end barang 1

            // barang 2
            $barang = Barang::find($barang_id);
            $barang->stok_barang = floatval($barang->stok_barang) - floatval($qty_orderbarang);
            $barang->save();
            // end barang 2
        }

        // update order barang
        $getOrderBarang->update($data);
        // end update


        $order = new OrderBarang();
        $getOrder = $order->getOrderBarang()->where('penerimaan_servis_id', $penerimaan_servis_id)->get();
        $totalHargaBarang = $getOrder->sum('subtotal_orderbarang');

        return response()->json([
            'result' => $getOrder,
            'totalHargaBarang' => $totalHargaBarang,
            'message' => 'Berhasil update data'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Request $request, $id)
    {
        $order = new OrderBarang();
        $getOrderBarang = $order->getOrderBarang()->find($id);
        $jumlahHarga = $getOrderBarang->subtotal_orderbarang;
        $qty_orderbarang = $getOrderBarang->qty_orderbarang;
        $barang_id = $getOrderBarang->barang_id;


        OrderBarang::destroy($id);

        // update penerimaan servis
        $penerimaan_servis_id = $request->input('penerimaan_servis_id');
        $getPenerimaanServis = PenerimaanServis::find($penerimaan_servis_id);
        $getPenerimaanServis->totalbiaya_pservis = $getPenerimaanServis->totalbiaya_pservis - $jumlahHarga;
        $getPenerimaanServis->save();
        // end update penerimaan servis

        // handle hutang dan kembalian
        $getPenerimaanServis = PenerimaanServis::find($penerimaan_servis_id);
        $deposit = $getPenerimaanServis->total_dppservis;
        $totalBiaya = $getPenerimaanServis->totalbiaya_pservis;
        $kalkulasi = $deposit - $totalBiaya;
        $hutang = 0;
        $kembalian = 0;
        if ($kalkulasi < 0) {
            $hutang = abs($kalkulasi);
            $kembalian = 0;
        } else {
            $hutang = 0;
            $kembalian = $kalkulasi;
        }
        $getPenerimaanServis->kembalian_pservis = $kembalian;
        $getPenerimaanServis->hutang_pservis = $hutang;
        $getPenerimaanServis->save();
        // end handle hutang dan kembalian

        $getOrder = $order->getOrderBarang()->where('penerimaan_servis_id', $penerimaan_servis_id)->get();
        $totalHargaBarang = $getOrder->sum('subtotal_orderbarang');
        // end penerimaan servis

        // update barang
        $getPenerimaanServis = PenerimaanServis::find($penerimaan_servis_id);
        if ($getPenerimaanServis->status_pservis != 'estimasi servis') {
            $barang_id = $barang_id;
            $jumlah_qty_orderbarang = $qty_orderbarang;

            $barang = Barang::find($barang_id);
            $barang->stok_barang = $barang->stok_barang + $jumlah_qty_orderbarang;
            $barang->save();
        }

        // end update barang

        return response()->json([
            'result' => $getOrder,
            'totalHargaBarang' => $totalHargaBarang,
            'message' => 'Berhasil hapus data',
        ], 200);
    }
}
