<?php

namespace Modules\Service\Http\Controllers;

use App\Http\Helpers\UtilsHelper;
use App\Models\Barang;
use App\Models\Customer;
use App\Models\Kategori;
use App\Models\KategoriPembayaran;
use App\Models\KategoriServis;
use App\Models\Kendaraan;
use App\Models\PembayaranServis;
use App\Models\PenerimaanServis;
use App\Models\Penjualan;
use App\Models\SaldoCustomer;
use App\Models\SaldoDetail;
use App\Models\SubPembayaran;
use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class PenerimaanServisController extends Controller
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
        if ($request->ajax()) {
            $data = Kategori::dataTable();
            return DataTables::eloquent($data)
                ->addColumn('action', function ($row) {
                    $buttonUpdate = '
                    <a class="btn btn-warning btn-edit btn-sm" 
                    data-typemodal="mediumModal"
                    data-urlcreate="' . route('penerimaanServis.edit', $row->id) . '"
                    data-modalId="mediumModal"
                    >
                        <i class="fa-solid fa-pencil"></i>
                    </a>
                    ';
                    $buttonDelete = '
                    <button type="button" class="btn-delete btn btn-danger btn-sm" data-url="' . url('master/penerimaanServis/' . $row->id) . '?_method=delete">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                    ';

                    $button = '
                <div class="text-center">
                    ' . $buttonUpdate . '
                    ' . $buttonDelete . '
                </div>
                ';
                    return $button;
                })
                ->rawColumns(['action'])
                ->toJson();
        }
        return view('service::penerimaanServis.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create(Request $request)
    {
        $action = route('penerimaanServis.store');
        $kategoriServis = KategoriServis::dataTable()->get();
        $tipeServis = $this->datastatis['tipe_servis'];
        $kendaraanServis = Kendaraan::with('customer', 'cabang')->get();
        $array_kendaraan_servis = [];
        foreach ($kendaraanServis as $key => $item) {
            $array_kendaraan_servis[] = [
                'label' => '<strong>No. Polisi: ' . $item->nopol_kendaraan . '</strong><br />
                <span>Customer: ' . $item->customer->nama_customer . '</span>
                ',
                'id' => $item->id,
            ];
        }

        $array_tipe_servis = [];
        foreach ($tipeServis as $key => $item) {
            $array_tipe_servis[] = [
                'label' => $item,
                'id' => $key,
            ];
        }

        $array_kategori_servis = [];
        foreach ($kategoriServis as $key => $item) {
            $array_kategori_servis[] = [
                'label' => $item->nama_kservis,
                'id' => $item->id,
            ];
        }

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
        $isEdit = $request->query('isEdit');
        $penerimaanServis = new PenerimaanServis();

        // $dataHutang = $penerimaanServis->pembayaranServis;

        // $totalHutang = 0;
        // $totalBayar = 0;
        // $totalKembalian = 0;
        // if (count($dataHutang) > 0) {
        //     foreach ($dataHutang as $key => $item) {
        //         $totalBayar += $item->bayar_pbcicilan;
        //         $totalKembalian += $item->kembalian_pbcicilan;
        //     }
        //     $totalHutang = $totalKembalian > 0 ?  $totalBayar - $totalKembalian : $dataHutang[0]->bayar_pbcicilan + $dataHutang[0]->hutang_pbcicilan;
        // }

        // $totalHutang = $isEdit == true ? $totalHutang : $penerimaanServis->hutang_penerimaanServis;
        $totalHutang = 0;
        $data = [
            'array_kategori_pembayaran' => $array_kategori_pembayaran,
            'kategoriPembayaran' => $kategoriPembayaran,
            'subPembayaran' => $subPembayaran,
            'array_sub_pembayaran' => $array_sub_pembayaran,
            'dataUser' => $dataUser,
            'defaultUser' => $defaultUser,
            'cabangId' => $cabangId,
            'isEdit' => $isEdit,
            'penerimaanServis' => $penerimaanServis,
            'totalHutang' => $totalHutang,
            'array_kategori_servis' => $array_kategori_servis,
            'array_kendaraan_servis' => $array_kendaraan_servis,
            'array_tipe_servis' => $array_tipe_servis,
            'action' => $action,
            'kendaraanServis' => $kendaraanServis
        ];
        if ($request->input('refresh_dataset')) {
            return response()->json($data);
        }

        return view('service::penerimaanServis.form', $data);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {

        $payloadPenerimaanServis = $request->input('payloadPenerimaanServis');
        $payloadPembayaranServis = $request->input('payloadPembayaranServis');
        $payloadSaldoCustomer = $request->input('payloadSaldoCustomer');

        // penerimaan servis
        $penerimaanServis = PenerimaanServis::create($payloadPenerimaanServis);
        $penerimaan_servis_id = $penerimaanServis->id;

        // saldo customer
        $customer_id = $payloadSaldoCustomer['customer_id'];
        $checkSaldo = SaldoCustomer::where('customer_id')->get()->count();
        $saldo_customer_id = 0;
        if ($checkSaldo == 0) {
            $saldoCustomer = SaldoCustomer::create([
                'customer_id' => $customer_id,
                'jumlah_saldocustomer' => $payloadSaldoCustomer['totalsaldo_detail'],
                'cabang_id' => $payloadSaldoCustomer['cabang_id'],
            ]);
            $saldo_customer_id = $saldoCustomer->id;
        } else {
            $saldoCustomer = SaldoCustomer::where('customer_id')->first();
            $saldo_customer_id = $saldoCustomer->id;
        }

        // saldo detail
        $dataSaldoDetail = [
            'saldo_customer_id' => $saldo_customer_id,
            'pembayaran_servis_id' => $penerimaan_servis_id,
            'totalsaldo_detail' => $payloadSaldoCustomer['totalsaldo_detail'],
            'kembaliansaldo_detail' => $payloadSaldoCustomer['kembaliansaldo_detail'],
            'hutangsaldo_detail' => $payloadSaldoCustomer['hutangsaldo_detail'],
            'cabang_id' => $payloadSaldoCustomer['cabang_id']
        ];
        SaldoDetail::create($dataSaldoDetail);


        if ($payloadPenerimaanServis['isdp_pservis'] == true) {
            $newPayloadPembayaranServis = [];
            foreach ($payloadPembayaranServis as $key => $value) {
                $merge = array_merge($value, ['penerimaan_servis_id' => $penerimaan_servis_id]);
                $newPayloadPembayaranServis[] = $merge;
            }
        }
        PembayaranServis::insert($newPayloadPembayaranServis);
        return response()->json([
            'message' => "Berhasil tambah penerimaan serivs",
        ], 200);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('service::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $action = url('master/penerimaanServis/' . $id . '?_method=put');
        $row = Kategori::find($id);
        $kategoriServis = KategoriServis::dataTable()->get();
        $tipeServis = $this->datastatis['tipe_servis'];
        return view('master::penerimaanServis.form', compact('action', 'row', 'kategoriServis', 'tipeServis'));
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
        $data = [
            'nama_penerimaanServis' => $request->input('nama_penerimaanServis'),
            'status_penerimaanServis' => $request->input('status_penerimaanServis') !== null ? true : false,
            'cabang_id' => session()->get('cabang_id'),
        ];
        Kategori::find($id)->update($data);
        return response()->json('Berhasil update data', 200);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
        Kategori::destroy($id);
        return response()->json('Berhasil hapus data', 200);
    }

    public function print()
    {
    }
}
