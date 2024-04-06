<?php

namespace Modules\Transaction\Http\Controllers;

use App\Http\Helpers\UtilsHelper;
use App\Models\Barang;
use App\Models\Customer;
use App\Models\KategoriPembayaran;
use App\Models\Pembelian;
use App\Models\PembelianPembayaran;
use App\Models\PembelianProduct;
use App\Models\SubPembayaran;
use App\Models\Supplier;
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

        $pembelian = UtilsHelper::paymentStatisPembelian(5);

        $supplier = Supplier::dataTable()
            ->where('status_supplier', true)
            ->get();
        $array_supplier = [];
        foreach ($supplier as $key => $item) {
            $array_supplier[] = [
                'id' => $item->id,
                'label' => $item->nama_supplier
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


        $dataSupplier = json_encode($supplier);
        $dataBarang = json_encode($barang);

        $pembelianCount = Pembelian::dataTable()->whereDate('transaksi_pembelian', date('Y-m-d'))->get()->count();
        $pembelianCount++;
        $noInvoice = date('Ymd') . $pembelianCount;
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
        $pembelianId = $request->query('pembelian_id');
        $isEdit = $request->query('isEdit');
        $pembelian = new Pembelian();
        $dataPembelian = $pembelian->invoicePembelian($pembelianId);

        $data = [
            'array_supplier' => $array_supplier,
            'dataSupplier' => $dataSupplier,
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
            'pembelian_id' => $pembelianId,
            'isEdit' => $isEdit,
            'dataPembelian' => $dataPembelian,
        ];

        if ($request->ajax()) {
            return response()->json($data, 200);
        }

        return view('transaction::kasir.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('transaction::kasir.form');
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
            $pembelianId = $payloadIsEdit['pembelian_id'];

            $pembelian = new Pembelian();
            $getInvoice = $pembelian->invoicePembelian($pembelianId);
            foreach ($getInvoice->pembelianProduct as $key => $item) {
                $barang_id = $item->barang_id;
                $jumlah_pembelianproduct = $item->jumlah_pembelianproduct;

                $barang = Barang::find($barang_id);
                $barang->stok_barang = $barang->stok_barang - $jumlah_pembelianproduct;
                $barang->save();
            }

            Pembelian::destroy($pembelianId);
        }

        $dataPembelian = $request->input('pembelian');
        $dateNow = date('Y-m-d');
        if ($dataPembelian['tipe_pembelian'] == 'hutang') {
            $dataPembelian = array_merge($dataPembelian, [
                'jatuhtempo_pembelian' => date('Y-m-d', strtotime($dateNow . ' + 1 month')),
                'keteranganjtempo_pembelian' => $this->datastatis['pesanwa_hutangsupplier'],
                'isinfojtempo_pembelian' => 0,
            ]);
        }

        $pembelian = Pembelian::create($dataPembelian);
        $pembelianProduct = $request->input('pembelian_product');
        $arrayPembelianProduct = [];
        foreach ($pembelianProduct as $key => $item) {
            $arrayPembelianProduct[] = array_merge($item, ['pembelian_id' => $pembelian->id]);
        }
        PembelianProduct::insert($arrayPembelianProduct);

        $pembelianPembayaran = $request->input('pembelian_pembayaran');
        $arrayPembelianPembayaran = [];
        foreach ($pembelianPembayaran as $key => $item) {
            $arrayPembelianPembayaran[] = array_merge(
                $item,
                [
                    'pembelian_id' => $pembelian->id,
                ]
            );
        }
        PembelianPembayaran::insert($arrayPembelianPembayaran);

        // pengurangan stock
        foreach ($arrayPembelianProduct as $key => $value) {
            $barang = Barang::find($value['barang_id']);
            $barang->stok_barang = floatval($barang->stok_barang) + floatval($value['jumlah_pembelianproduct']);
            $barang->save();
        }

        $message = 'Berhasil tambah data';
        if ($payloadIsEdit['isEdit'] == true) {
            $message = 'Berhasil edit transaksi';
        }

        return response()->json([
            'message' => $message,
            'result' => $pembelian->id,
        ], 201);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('transaction::show');
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
