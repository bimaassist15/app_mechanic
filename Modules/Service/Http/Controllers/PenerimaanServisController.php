<?php

namespace Modules\Service\Http\Controllers;

use App\Http\Helpers\UtilsHelper;
use App\Models\Barang;
use App\Models\HargaServis;
use App\Models\KategoriPembayaran;
use App\Models\KategoriServis;
use App\Models\Kendaraan;
use App\Models\PembayaranServis;
use App\Models\PenerimaanServis;
use App\Models\SaldoCustomer;
use App\Models\SaldoDetail;
use App\Models\ServiceHistory;
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
            $data = PenerimaanServis::dataTable()->where('status_pservis', 'antrian servis masuk');
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
                            <a href="' . url('service/penerimaanServis/create?isEdit=true&id=' . $row->id) . '"
                                class="dropdown-item d-flex align-items-center btn-edit" data-typemodal="extraLargeModal">
                                <i class="fa-solid fa-pencil"></i> &nbsp; Edit</a>
                        </li>
                        <li>
                            <a href="' . url('service/penerimaanServis/print/' . $row->id . '/penerimaanServis') . '"
                                class="dropdown-item d-flex align-items-center btn-print">
                                <i class="fa-solid fa-print"></i> &nbsp; Print Antrian</a>
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

    public function show(Request $request, $id)
    {
        $data = UtilsHelper::dataUpdateServis($id, $this->datastatis);
        if ($request->ajax()) {
            $loadData = $request->input('loadData');
            if ($loadData) {
                return response()->json([
                    'view' => view('service::penerimaanServis.output_detail', $data)->render(),
                    'data' => $data,
                ], 200);
            }
        }

        return view('service::penerimaanServis.detail', $data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create(Request $request)
    {
        $action = url('service/penerimaanServis');
        $kategoriServis = KategoriServis::dataTable()->get();
        $tipeServis = $this->datastatis['tipe_servis'];
        $kendaraanServis = Kendaraan::dataTable()->with('customer', 'cabang')->get();
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
        $penerimaanServis = new PenerimaanServis();

        $pesanwa_estimasi = $this->datastatis['pesanwa_estimasi'];
        $totalHutang = 0;
        $id = $request->input('id');
        $isEdit = $request->input('isEdit');
        $data = [
            'array_kategori_pembayaran' => $array_kategori_pembayaran,
            'kategoriPembayaran' => $kategoriPembayaran,
            'subPembayaran' => $subPembayaran,
            'array_sub_pembayaran' => $array_sub_pembayaran,
            'dataUser' => $dataUser,
            'defaultUser' => $defaultUser,
            'cabangId' => $cabangId,
            'penerimaanServis' => $penerimaanServis,
            'totalHutang' => $totalHutang,
            'array_kategori_servis' => $array_kategori_servis,
            'array_kendaraan_servis' => $array_kendaraan_servis,
            'array_tipe_servis' => $array_tipe_servis,
            'action' => $action,
            'kendaraanServis' => $kendaraanServis,
            'pesanwa_estimasi' => $pesanwa_estimasi,
            'row' => $penerimaanServis->transaksiServis($id),
            'isEdit' => $isEdit,
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
        $payloadEdit = $request->input('payloadEdit');
        $isEdit = $payloadEdit['isEdit'];
        if ($isEdit) {
            $penerimaan_servis_id = $payloadEdit['penerimaan_servis_id'];
            $this->deletePenerimaanServis($penerimaan_servis_id);
        }

        $payloadPenerimaanServis = $request->input('payloadPenerimaanServis');
        $payloadPembayaranServis = $request->input('payloadPembayaranServis');
        $payloadSaldoCustomer = $request->input('payloadSaldoCustomer');

        // penerimaan servis
        $dateNow = date('Y-m-d');
        $noAntrianStatis = PenerimaanServis::dataTable()
            ->whereDate('created_at', $dateNow)
            ->where('status_pservis', '!=', null)
            ->orderBy('id', 'asc')
            ->pluck('noantrian_pservis')
            ->max();
        $noNotaStatis = PenerimaanServis::dataTable()
            ->where('status_pservis', '!=', null)
            ->orderBy('id', 'asc')
            ->pluck('nonota_pservis')
            ->max();

        $customer_id = $payloadSaldoCustomer['customer_id'];
        $noAntrianStatis++;
        $noNotaStatis++;

        $status_pservis = 'antrian servis masuk';
        if ($payloadPenerimaanServis['isestimasi_pservis'] == 1) {
            $status_pservis = 'estimasi servis';
            $noAntrianStatis = null;
            $noNotaStatis = null;
        }

        $mergePenerimaanServis = array_merge(
            $payloadPenerimaanServis,
            [
                'noantrian_pservis' => $noAntrianStatis,
                'nonota_pservis' => $noNotaStatis,
                'status_pservis' => $status_pservis,
                'users_id' => Auth::id(),
                'customer_id' => $customer_id,
            ],
        );
        $penerimaanServis = PenerimaanServis::create($mergePenerimaanServis);
        $penerimaan_servis_id = $penerimaanServis->id;

        // history servis
        ServiceHistory::create([
            'penerimaan_servis_id' => $penerimaan_servis_id,
            'status_histori' => $status_pservis,
            'cabang_id' => session()->get('cabang_id'),
        ]);

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
            PembayaranServis::insert($newPayloadPembayaranServis);
        }
        return response()->json([
            'message' => "Berhasil tambah penerimaan serivs",
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    private function deletePenerimaanServis($id)
    {
        //
        $penerimaanServis = new PenerimaanServis();

        // update if order stock barang
        $getPenerimaanServis = $penerimaanServis->transaksiServis($id);
        // update stok barang
        $orderBarang = $getPenerimaanServis->orderBarang;
        if (count($orderBarang) > 0) {
            foreach ($orderBarang as $key => $item) {
                // update stok barang
                $barang = Barang::find($item->barang_id);
                $barang->stok_barang = $barang->stok_barang + $item->qty_orderbarang;
                $barang->save();
            }
        }

        // saldo customer
        $refundSaldo = 0;
        $pembayaranServis = $getPenerimaanServis->pembayaranServis;
        foreach ($pembayaranServis as $key => $item) {
            if (strtolower($item->kategoriPembayaran->nama_kpembayaran) == 'deposit') {
                $refundSaldo = $item->saldodeposit_pservis - $item->bayar_pservis;
            }
        }

        if ($getPenerimaanServis->tanggalambil_pservis != null && $refundSaldo != 0) {
            // update saldo customer
            $customer_id = $getPenerimaanServis->kendaraan->customer_id;
            $saldoCustomer = SaldoCustomer::where('customer_id', $customer_id)->first();
            $saldoCustomer->jumlah_saldocustomer = $saldoCustomer->jumlah_saldocustomer - $refundSaldo;
            $saldoCustomer->save();
        } else {
            $saldoDetail = SaldoDetail::where("penerimaan_servis_id", $id)->first();
            if ($saldoDetail && $getPenerimaanServis->tanggalambil_pservis == null) {
                $totalDpDetail = $saldoDetail->totalsaldo_detail;

                // update saldo customer
                $customer_id = $getPenerimaanServis->kendaraan->customer_id;
                $saldoCustomer = SaldoCustomer::where('customer_id', $customer_id)->first();
                $saldoCustomer->jumlah_saldocustomer = $saldoCustomer->jumlah_saldocustomer - $totalDpDetail;
                $saldoCustomer->save();

                // delete saldo detail
                $saldoDetail->delete();
            }
        }
        // update saldo customer case 2
        PenerimaanServis::destroy($id);
    }

    public function destroy($id)
    {
        $this->deletePenerimaanServis($id);
        return response()->json('Berhasil hapus data', 200);
    }

    public function print($id)
    {
        $penerimaanServis = new PenerimaanServis();
        $penerimaanServis = $penerimaanServis->transaksiServis($id);
        $myCabang = UtilsHelper::myCabang();
        return view('service::penerimaanServis.print', compact('penerimaanServis', 'myCabang'));
    }

    public function detail($id)
    {
        $penerimaanServis = new PenerimaanServis();
        $row = $penerimaanServis->transaksiServis($id);

        return view('service::penerimaanServis.show', compact('row'));
    }

    public function update(Request $request, $id)
    {
        $is_pengembalian_servis = $request->input('is_pengembalian_servis');
        $pengembalian_servis = $request->input('pengembalian_servis');
        $data = $request->except(['_method']);
        if ($data['status_pservis'] == 'proses servis' || $data['status_pservis'] == 'bisa diambil') {
            $tanggal_service_berkala = UtilsHelper::checkTanggalBerkala($data);
            $data = array_merge($data, ['servisberkala_pservis' => $tanggal_service_berkala]);
        }
        if ($is_pengembalian_servis) {
            $data = collect($data)
                ->forget('is_pengembalian_servis')
                ->forget('pengembalian_servis')
                ->toArray();
        }
        PenerimaanServis::find($id)->update($data);

        $status_pservis = $data['status_pservis'];
        if (!$is_pengembalian_servis) {
            ServiceHistory::create([
                'penerimaan_servis_id' => $id,
                'status_histori' => $status_pservis,
                'cabang_id' => session()->get('cabang_id'),
            ]);
        }

        // // check if cancel
        $statusServis = ['cancel', 'tidak bisa'];
        if (in_array($status_pservis, $statusServis)) {

            $penerimaanServis = new PenerimaanServis();
            $getPenerimaanServis = $penerimaanServis->transaksiServis($id);

            // update if order stock barang
            $orderBarang = $getPenerimaanServis->orderBarang;
            if (count($orderBarang) > 0) {
                foreach ($orderBarang as $key => $item) {
                    // update stok barang
                    $barang = Barang::find($item->barang_id);
                    $barang->stok_barang = $barang->stok_barang + $item->qty_orderbarang;
                    $barang->save();
                }
            }

            // saldo customer
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
        }

        $penerimaanServis = new PenerimaanServis();
        $dataServis = $penerimaanServis->transaksiServis($id);

        // pengembalian servis
        if ($is_pengembalian_servis) {
            $penerimaan_servis = $pengembalian_servis['penerimaan_servis'];
            $nilaigaransi_pservis = $penerimaan_servis['nilaigaransi_pservis'];
            $tipegaransi_pservis = $penerimaan_servis['tipegaransi_pservis'];
            $checkTanggalGaransi = UtilsHelper::checkTanggalGaransi($penerimaan_servis);
            $servisgaransi_pservis = $checkTanggalGaransi;

            // pembayaran servis
            $pembayaran_servis = $pengembalian_servis['pembayaran_servis'];
            PembayaranServis::insert($pembayaran_servis);

            // penerimaan servis
            $penerimaan_servis = $pengembalian_servis['penerimaan_servis'];
            PenerimaanServis::find($id)->update([
                'bayar_pservis' => $penerimaan_servis['bayar_pservis'],
                'hutang_pservis' => $penerimaan_servis['hutang_pservis'],
                'kembalian_pservis' => $penerimaan_servis['kembalian_pservis'],
                'nilaigaransi_pservis' => $nilaigaransi_pservis,
                'tipegaransi_pservis' => $tipegaransi_pservis,
                'servisgaransi_pservis' => $servisgaransi_pservis,
                'tanggalambil_pservis' => date('Y-m-d H:i:s'),
            ]);

            if ($servisgaransi_pservis != null) {
                $getPenerimaanServis = PenerimaanServis::find($id);
                $getPenerimaanServis->status_pservis = 'sudah diambil';
                $getPenerimaanServis->save();

                ServiceHistory::create([
                    'penerimaan_servis_id' => $id,
                    'status_histori' => 'sudah diambil',
                    'cabang_id' => session()->get('cabang_id'),
                ]);
            }

            // saldo customer
            $saldo_customer = $pengembalian_servis['saldo_customer'];
            $customer_id = $saldo_customer['customer_id'];
            $saldo_customer_model = SaldoCustomer::where('customer_id', $customer_id)->first();
            if ($saldo_customer_model) {
                $saldo_customer_model->update([
                    'customer_id' => $saldo_customer['customer_id'],
                    'jumlah_saldocustomer' => $saldo_customer['jumlah_saldocustomer'],
                    'cabang_id' => $saldo_customer['cabang_id'],
                ]);

                // saldo detail
                $saldo_detail = $pengembalian_servis['saldo_detail'];
                SaldoDetail::create([
                    'saldo_customer_id' => $saldo_customer_model->id,
                    'penerimaan_servis_id' => $saldo_detail['penerimaan_servis_id'],
                    'totalsaldo_detail' => $saldo_detail['totalsaldo_detail'],
                    'kembaliansaldo_detail' => $saldo_detail['kembaliansaldo_detail'],
                    'hutangsaldo_detail' => $saldo_detail['hutangsaldo_detail'],
                    'cabang_id' => $saldo_detail['cabang_id'],
                ]);
            }
        }

        $dataServis = $penerimaanServis->transaksiServis($id);
        $getPembayaranServis = UtilsHelper::paymentStatisPenerimaanServis($id);

        return response()->json([
            'message' => 'Berhasil menambahkan progress pengerjaan',
            'row' => $dataServis,
            'getPembayaranServis' => $getPembayaranServis,
        ], 200);
    }

    // output
    public function outputUpdateService(Request $request, $id)
    {
        $penerimaanServis = new PenerimaanServis();
        // informasi servis
        $serviceBerkala = ($this->datastatis['servis_berkala']);
        $array_service_berkala = [];
        foreach ($serviceBerkala as $key => $item) {
            $array_service_berkala[] = [
                'label' => $item,
                'id' => $key,
            ];
        }
        $pesanwa_berkala = $this->datastatis['pesanwa_berkala'];
        $row = $penerimaanServis->transaksiServis($id);
        $array_kategori_pembayaran = [];
        $kategoriPembayaran = KategoriPembayaran::dataTable()->where('status_kpembayaran', true)
            ->get();
        foreach ($kategoriPembayaran as $value => $item) {
            $array_kategori_pembayaran[] = [
                'id' => $item->id,
                'label' => $item->nama_kpembayaran
            ];
        }
        $array_kategori_pembayaran = json_encode($array_kategori_pembayaran);
        $getPembayaranServis = json_encode(UtilsHelper::paymentStatisPenerimaanServis($id));

        $loadDataServis = $request->input('loadDataServis');
        if ($loadDataServis) {
            $penerimaanServis = new PenerimaanServis();
            $row = $penerimaanServis->transaksiServis($id);
            $statusKendaraanServis = ($this->datastatis['status_kendaraan_servis']);
            $array_status_kendaraan = [];
            foreach ($statusKendaraanServis as $key => $item) {
                $array_status_kendaraan[] = [
                    'label' => $item,
                    'id' => $key,
                ];
            }
            // servis
            $data = [
                'row' => $row,
                'statusKendaraanServis' => $array_status_kendaraan,
            ];

            $htmlOrderServis = view('service::penerimaanServis.output.servis', $data)->render();

            // informasi servis
            $row = $penerimaanServis->transaksiServis($id);
            $data = [
                'row' => $row,
                'statusKendaraanServis' => $array_status_kendaraan,
                'statusKendaraanServis' => $array_status_kendaraan,
                'serviceBerkala' => $array_service_berkala,
                'serviceGaransi' => $array_service_berkala,
                'pesanwa_berkala' => $pesanwa_berkala,
                'array_kategori_pembayaran' => $array_kategori_pembayaran,
            ];
            $htmlInformasiServis = view('service::penerimaanServis.output.informasiServis', $data)->render();


            return response()->json([
                'row' => $row,
                'order_servis' => $htmlOrderServis,
                'informasi_servis' => $htmlInformasiServis,
                'getPembayaranServis' => $getPembayaranServis
            ]);
        }

        $loadDataSparepart = $request->input('loadDataSparepart');
        if ($loadDataSparepart) {
            $penerimaanServis = new PenerimaanServis();
            $row = $penerimaanServis->transaksiServis($id);
            $statusKendaraanServis = ($this->datastatis['status_kendaraan_servis']);
            $array_status_kendaraan = [];
            foreach ($statusKendaraanServis as $key => $item) {
                $array_status_kendaraan[] = [
                    'label' => $item,
                    'id' => $key,
                ];
            }
            // servis
            $tipeDiskon = ($this->datastatis['tipe_diskon']);
            $data = [
                'row' => $row,
                'tipeDiskon' => $tipeDiskon,
            ];

            $htmlOrderBarang = view('service::penerimaanServis.output.orderBarang', $data)->render();

            $data = [
                'row' => $row,
                'statusKendaraanServis' => $array_status_kendaraan,
                'serviceBerkala' => $array_service_berkala,
                'serviceGaransi' => $array_service_berkala,
                'pesanwa_berkala' => $pesanwa_berkala,
                'array_kategori_pembayaran' => $array_kategori_pembayaran,
            ];
            $htmlInformasiServis = view('service::penerimaanServis.output.informasiServis', $data)->render();

            return response()->json([
                'row' => $row,
                'order_barang' => $htmlOrderBarang,
                'informasi_servis' => $htmlInformasiServis,
                'getPembayaranServis' => $getPembayaranServis
            ]);
        }

        $loadDataHistory = $request->input('loadDataHistory');
        if ($loadDataHistory) {
            $penerimaanServis = new PenerimaanServis();
            // informasi servis
            $row = $penerimaanServis->transaksiServis($id);
            $data = [
                'row' => $row,
            ];
            $htmlServiceHistory = view('service::penerimaanServis.output.histori', $data)->render();

            return response()->json([
                'service_history' => $htmlServiceHistory,
            ]);
        }
    }
}
