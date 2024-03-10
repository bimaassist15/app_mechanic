<?php

namespace Modules\Purchase\Http\Controllers;

use App\Models\Barang;
use App\Models\Customer;
use App\Models\KategoriPembayaran;
use App\Models\Penjualan;
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
    public function __construct() {
        $this->datastatis = Config::get('datastatis');
    }

    public function index()
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
                'label' => $item->barcode_barang. ' '.$item->nama_barang
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
        ->join('roles','roles.id','=','users.roles_id')
        ->with('profile')
        ->select('users.*','roles.id as roles_id', 'roles.name as roles_name', 'roles.guard_name as roles_guard')
        ->get();
        $dataUser = json_encode($dataUser);
        $defaultUser = Auth::id();


        return view('purchase::kasir.index', compact(
            'array_customer', 'dataCustomer', 'noInvoice', 'array_barang', 'dataBarang', 'dataTipeDiskon', 'array_kategori_pembayaran', 'kategoriPembayaran', 'subPembayaran', 'array_sub_pembayaran', 'dataUser', 'defaultUser'));
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
        //
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
