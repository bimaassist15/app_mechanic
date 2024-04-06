<?php

namespace Modules\Purchase\Http\Controllers;

use App\Models\Barang;
use App\Models\Customer;
use App\Models\KategoriPembayaran;
use App\Models\Penjualan;
use App\Models\PenjualanPembayaran;
use App\Models\PenjualanProduct;
use App\Models\SubPembayaran;
use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class KasirController extends Controller
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

        $customer = Customer::dataTable()
            ->where('status_customer', true)
            ->get();
        $array_customer = [];
        foreach ($customer as $key => $item) {
            $array_customer[] = [
                'id' => $item->id,
                'label' => $item->nama_customer
            ];
        }
        $barang = Barang::dataTable()
            ->with('satuan', 'kategori')
            ->where('status_barang', 'dijual')
            ->orWhere('status_barang', 'dijual & untuk servis')
            ->get();
        $array_barang = [];
        foreach ($barang as $key => $item) {
            $array_barang[] = [
                'id' => $item->id,
                'label' => '
                <strong>[' . $item->barcode_barang . '] ' . $item->nama_barang . '</strong> <br />
                <span>Stok: ' . $item->stok_barang . '</span>
                '
            ];
        }


        $dataCustomer = json_encode($customer);
        $dataBarang = json_encode($barang);

        $penjualanCount = Penjualan::dataTable()->whereDate('transaksi_penjualan', date('Y-m-d'))->get()->count();
        $penjualanCount++;
        $noInvoice = date('Ymd') . $penjualanCount;
        $dataTipeDiskon = json_encode($this->datastatis['tipe_diskon']);

        $array_kategori_pembayaran = [];
        $kategoriPembayaran = KategoriPembayaran::dataTable()->where('status_kpembayaran', true)
            ->whereNot('nama_kpembayaran', 'like', '%deposit%')
            ->get();
        foreach ($kategoriPembayaran as $value => $item) {
            $array_kategori_pembayaran[] = [
                'id' => $item->id,
                'label' => $item->nama_kpembayaran
            ];
        }
        $kategoriPembayaran = json_encode($kategoriPembayaran);
        $array_kategori_pembayaran = json_encode($array_kategori_pembayaran);


        $array_sub_pembayaran = [];
        $subPembayaran = SubPembayaran::dataTable()->where('status_spembayaran', true)
            ->get();
        foreach ($subPembayaran as $value => $item) {
            $array_sub_pembayaran[] = [
                'id' => $item->id,
                'label' => $item->nama_spembayaran,
                'kategori_pembayaran_id' => $item->kategori_pembayaran_id
            ];
        }
        $subPembayaran = json_encode($subPembayaran);
        $array_sub_pembayaran = json_encode($array_sub_pembayaran);

        $dataUser = User::dataTable()
            ->join('roles', 'roles.id', '=', 'users.roles_id')
            ->with('profile')
            ->select('users.*', 'roles.id as roles_id', 'roles.name as roles_name', 'roles.guard_name as roles_guard')
            ->get();
        $dataUser = json_encode($dataUser);
        $defaultUser = Auth::id();
        $cabangId = session()->get('cabang_id');
        $penjualanId = $request->query('penjualan_id');
        $isEdit = $request->query('isEdit');
        $penjualan = new Penjualan();
        $dataPenjualan = $penjualan->invoicePenjualan($penjualanId);

        $data = [
            'array_customer' => $array_customer,
            'dataCustomer' => $dataCustomer,
            'noInvoice' => $noInvoice,
            'array_barang' => $array_barang,
            'dataBarang' => $dataBarang,
            'dataTipeDiskon' => $dataTipeDiskon,
            'array_kategori_pembayaran' => $array_kategori_pembayaran,
            'kategoriPembayaran' => $kategoriPembayaran,
            'subPembayaran' => $subPembayaran,
            'array_sub_pembayaran' => $array_sub_pembayaran,
            'dataUser' => $dataUser,
            'defaultUser' => $defaultUser,
            'cabangId' => $cabangId,
            'penjualan_id' => $penjualanId,
            'isEdit' => $isEdit,
            'dataPenjualan' => $dataPenjualan,
        ];

        if ($request->ajax()) {
            return response()->json($data, 200);
        }

        return view('purchase::kasir.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('purchase::kasir.form');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        // jika payload is edit
        $payloadIsEdit = $request->input('payload_is_edit');
        if ($payloadIsEdit['isEdit'] == true) {
            $penjualanId = $payloadIsEdit['penjualan_id'];

            $penjualan = new Penjualan();
            $getInvoice = $penjualan->invoicePenjualan($penjualanId);
            foreach ($getInvoice->penjualanProduct as $key => $item) {
                $barang_id = $item->barang_id;
                $jumlah_penjualanproduct = $item->jumlah_penjualanproduct;

                $barang = Barang::find($barang_id);
                $barang->stok_barang = $barang->stok_barang + $jumlah_penjualanproduct;
                $barang->save();
            }

            Penjualan::destroy($penjualanId);
        }

        $dataPenjualan = $request->input('penjualan');
        $dateNow = date('Y-m-d');
        if ($dataPenjualan['tipe_penjualan'] == 'hutang') {
            $dataPenjualan = array_merge($dataPenjualan, [
                'jatuhtempo_penjualan' => date('Y-m-d', strtotime($dateNow . ' + 1 month')),
                'keteranganjtempo_penjualan' => $this->datastatis['pesanwa_hutang'],
                'isinfojtempo_penjualan' => 0,
            ]);
        }

        $penjualan = Penjualan::create($dataPenjualan);
        $penjualanProduct = $request->input('penjualan_product');
        $arrayPenjualanProduct = [];
        foreach ($penjualanProduct as $key => $item) {
            $arrayPenjualanProduct[] = array_merge(
                $item,
                [
                    'penjualan_id' => $penjualan->id,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]
            );
        }
        PenjualanProduct::insert($arrayPenjualanProduct);

        $penjualanPembayaran = $request->input('penjualan_pembayaran');
        $arrayPenjualanPembayaran = [];
        foreach ($penjualanPembayaran as $key => $item) {
            $arrayPenjualanPembayaran[] = array_merge(
                $item,
                [
                    'penjualan_id' => $penjualan->id,
                ]
            );
        }
        PenjualanPembayaran::insert($arrayPenjualanPembayaran);

        // pengurangan stock
        foreach ($arrayPenjualanProduct as $key => $value) {
            $barang = Barang::find($value['barang_id']);
            $barang->stok_barang = floatval($barang->stok_barang) - floatval($value['jumlah_penjualanproduct']);
            $barang->save();
        }

        $message = 'Berhasil tambah data';
        if ($payloadIsEdit['isEdit'] == true) {
            $message = 'Berhasil edit transaksi';
        }

        return response()->json([
            'message' => $message,
            'result' => $penjualan->id,
        ], 201);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('purchase::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('purchase::edit');
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
