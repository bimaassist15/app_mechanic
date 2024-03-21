<?php

namespace Modules\Service\Http\Controllers;

use App\Http\Helpers\UtilsHelper;
use App\Models\KategoriPembayaran;
use App\Models\KategoriServis;
use App\Models\Kendaraan;
use App\Models\PembayaranServis;
use App\Models\PenerimaanServis;
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
            $data = PenerimaanServis::dataTable();
            return DataTables::eloquent($data)
                ->addColumn('action', function ($row) {
                    $buttonAksi = '
                    <button type="button" 
                    class="btn btn-primary dropdown-toggle" 
                    data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <i class="bx bx-menu me-1"></i> 
                    Aksi
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <a target="_blank" href="' . url('service/penerimaanServis/' . $row->id) . '"
                                class="dropdown-item d-flex align-items-center" target="_blank">
                                <i class="fa-solid fa-pencil"></i> &nbsp; Update Servis
                            </a>
                        </li>
                        <li>
                            <a href="' . url('service/penerimaanServis/' . $row->id . '?_method=delete') . '"
                                class="dropdown-item d-flex align-items-center btn-delete">
                                <i class="fa-solid fa-trash"></i> &nbsp; Delete</a>
                        </li>
                        <li>
                            <a href="' . url('service/penerimaanServis/print/' . $row->id . '/penerimaanServis') . '"
                                class="dropdown-item d-flex align-items-center btn-print">
                                <i class="fa-solid fa-print"></i> &nbsp; Print Nota</a>
                        </li>
                    </ul>';



                    $button = '
                <div class="text-center">
                    ' . $buttonAksi . '
                </div>
                ';
                    return $button;
                })
                ->rawColumns(['action'])
                ->toJson();
        }
        return view('service::penerimaanServis.index');
    }

    public function show($id)
    {
        $penerimaanServis = new PenerimaanServis();
        $row = $penerimaanServis->transaksiServis($id);
        return view('service::penerimaanServis.detail', compact('row'));
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
        $dateNow = date('Y-m-d');
        $noAntrianStatis = PenerimaanServis::whereDate('created_at', $dateNow)
            ->orderBy('id', 'asc')
            ->pluck('noantrian_pservis')
            ->max();
        $noNotaStatis = PenerimaanServis::orderBy('id', 'asc')
            ->pluck('nonota_pservis')
            ->max();

        $customer_id = $payloadSaldoCustomer['customer_id'];
        $noAntrianStatis++;
        $noNotaStatis++;
        $mergePenerimaanServis = array_merge(
            $payloadPenerimaanServis,
            [
                'noantrian_pservis' => $noAntrianStatis,
                'nonota_pservis' => $noNotaStatis,
                'status_pservis' => 'antrian servis masuk',
                'users_id' => Auth::id(),
                'customer_id' => $customer_id,
            ],
        );
        $penerimaanServis = PenerimaanServis::create($mergePenerimaanServis);
        $penerimaan_servis_id = $penerimaanServis->id;

        // saldo customer
        $checkSaldo = SaldoCustomer::where('customer_id', $customer_id)->get()->count();
        $saldo_customer_id = 0;
        if ($checkSaldo == 0) {
            $saldoCustomer = SaldoCustomer::create([
                'customer_id' => $customer_id,
                'jumlah_saldocustomer' => $payloadSaldoCustomer['totalsaldo_detail'],
                'cabang_id' => $payloadSaldoCustomer['cabang_id'],
            ]);
            $saldo_customer_id = $saldoCustomer->id;
        } else {
            $saldoCustomer = SaldoCustomer::where('customer_id', $customer_id)->first();
            $saldoCustomer->jumlah_saldocustomer = $saldoCustomer->jumlah_saldocustomer + $payloadSaldoCustomer['totalsaldo_detail'];
            $saldoCustomer->save();
            $saldo_customer_id = $saldoCustomer->id;
        }

        // saldo detail
        $dataSaldoDetail = [
            'saldo_customer_id' => $saldo_customer_id,
            'penerimaan_servis_id' => $penerimaan_servis_id,
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
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
        $penerimaanServis = new PenerimaanServis();

        $getPenerimaanServis = $penerimaanServis->transaksiServis($id);
        $saldoDetail = SaldoDetail::where("penerimaan_servis_id", $id)->first();

        if ($saldoDetail) {
            $totalDpDetail = $saldoDetail->totalsaldo_detail;

            // update saldo customer
            $customer_id = $getPenerimaanServis->kendaraan->customer_id;
            $saldoCustomer = SaldoCustomer::where('customer_id', $customer_id)->first();
            $saldoCustomer->jumlah_saldocustomer = $saldoCustomer->jumlah_saldocustomer - $totalDpDetail;
            $saldoCustomer->save();

            // delete saldo detail
            $saldoDetail->delete();
        }

        PenerimaanServis::destroy($id);
        return response()->json('Berhasil hapus data', 200);
    }

    public function print($id)
    {
        $penerimaanServis = new PenerimaanServis();
        $penerimaanServis = $penerimaanServis->transaksiServis($id);
        $myCabang = UtilsHelper::myCabang();
        return view('service::penerimaanServis.print', compact('penerimaanServis', 'myCabang'));
    }
}
