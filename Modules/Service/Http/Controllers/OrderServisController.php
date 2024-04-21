<?php

namespace Modules\Service\Http\Controllers;

use App\Models\OrderServis;
use App\Models\PenerimaanServis;
use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;


class OrderServisController extends Controller
{
    public function index(Request $request)
    {
        $order = new OrderServis();
        $penerimaan_servis_id = $request->input('penerimaan_servis_id');
        $getOrder = $order->getOrderServis()->where('penerimaan_servis_id', $penerimaan_servis_id)->get();
        $totalHargaServis = $getOrder->sum('harga_orderservis');

        return response()->json([
            'result' => $getOrder,
            'totalHargaServis' => $totalHargaServis,
        ], 200);
    }


    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $orderServis = OrderServis::create($request->all());
        $order_servis_id = $orderServis->id;

        $order = new OrderServis();
        $getOrderServis = $getOrder = $order->getOrderServis()->find($order_servis_id);
        $jumlahHarga = $getOrderServis->hargaServis->total_hargaservis;

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

        $getOrder = $order->getOrderServis()->where('penerimaan_servis_id', $penerimaan_servis_id)->get();
        $totalHargaServis = $getOrder->sum('harga_orderservis');

        return response()->json([
            'result' => $getOrder,
            'totalHargaServis' => $totalHargaServis,
        ], 201);
    }

    public function edit($id)
    {
        $orderServis = new OrderServis();
        $row = $orderServis->getOrderServis()->find($id);
        $action = url('service/orderServis/' . $id . '?_method=put');
        $array_users_mekanik = [];
        $getUsers = new User();
        $dataUsers = ($getUsers->getUsersMekanik());
        foreach ($dataUsers as $key => $item) {
            $array_users_mekanik[] = [
                'label' => '<strong>Nama Mekanik: ' . $item->name . '</strong><br />
                <span>No. HP: ' . $item->profile->nohp_profile . '</span>',
                'id' => $item->id,
            ];
        }
        return view('service::orderServis.form', compact('row', 'action', 'array_users_mekanik'));
    }

    public function update(Request $request, $id)
    {
        $getOrder = OrderServis::find($id);
        $getOrder->users_id_mekanik = $request->input('users_id_mekanik');
        $getOrder->save();

        // update order servis
        $order = new OrderServis();
        $penerimaan_servis_id = $getOrder->penerimaan_servis_id;
        $getOrder = $order->getOrderServis()->where('penerimaan_servis_id', $penerimaan_servis_id)->get();
        $totalHargaServis = $getOrder->sum('harga_orderservis');

        return response()->json([
            'result' => $getOrder,
            'totalHargaServis' => $totalHargaServis,
            'message' => 'Berhasil tambah mekanik'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Request $request, $id)
    {
        $order = new OrderServis();
        $getOrderServis = $order->getOrderServis()->find($id);
        $jumlahHarga = $getOrderServis->hargaServis->total_hargaservis;

        OrderServis::destroy($id);

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

        $getOrder = $order->getOrderServis()->where('penerimaan_servis_id', $penerimaan_servis_id)->get();
        $totalHargaServis = $getOrder->sum('harga_orderservis');

        return response()->json('Berhasil hapus data');
    }
}
