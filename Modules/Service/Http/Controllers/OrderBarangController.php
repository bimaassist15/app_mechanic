<?php

namespace Modules\Service\Http\Controllers;

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
        $order_servis_id = $OrderBarang->id;

        $order = new OrderBarang();
        $getOrderBarang = $getOrder = $order->getOrderBarang()->find($order_servis_id);
        $jumlahHarga = $getOrderBarang->barang->hargajual_barang;

        // penerimaan servis
        $penerimaan_servis_id = $request->input('penerimaan_servis_id');
        $getPenerimaanServis = PenerimaanServis::find($penerimaan_servis_id);
        $getPenerimaanServis->totalbiaya_pservis = $getPenerimaanServis->totalbiaya_pservis + $jumlahHarga;
        $getPenerimaanServis->save();

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

        // update order barang
        $getOrderBarang->update($data);
        // end update


        $order = new OrderBarang();
        $getOrder = $order->getOrderBarang()->where('penerimaan_servis_id', $penerimaan_servis_id)->get();
        $totalHargaBarang = $getOrder->sum('subtotal_orderbarang');

        return response()->json([
            'result' => $getOrder,
            'totalHargaBarang' => $totalHargaBarang,

            'is_bring_data' => true,
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
        $jumlahHarga = $getOrderBarang->barang->hargajual_barang;

        OrderBarang::destroy($id);

        // update penerimaan servis
        $penerimaan_servis_id = $request->input('penerimaan_servis_id');
        $getPenerimaanServis = PenerimaanServis::find($penerimaan_servis_id);
        $getPenerimaanServis->totalbiaya_pservis = $getPenerimaanServis->totalbiaya_pservis - $jumlahHarga;
        $getPenerimaanServis->save();

        $getOrder = $order->getOrderBarang()->where('penerimaan_servis_id', $penerimaan_servis_id)->get();
        $totalHargaBarang = $getOrder->sum('subtotal_orderbarang');

        return response()->json([
            'result' => $getOrder,
            'totalHargaBarang' => $totalHargaBarang,

            'is_bring_data' => true,
            'message' => 'Berhasil hapus data',
        ], 200);
    }
}
