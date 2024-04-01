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

class PengembalianServisController extends Controller
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
            $data = PenerimaanServis::dataTable()
                ->where('status_pservis', 'bisa diambil')
                ->where('tanggalambil_pservis', null);

            return DataTables::eloquent($data)
                ->addColumn('created_at', function ($row) {
                    return UtilsHelper::tanggalBulanTahunKonversi($row->created_at);
                })
                ->addColumn('totalbiaya_pservis', function ($row) {
                    return UtilsHelper::formatUang($row->totalbiaya_pservis);
                })
                ->addColumn('action', function ($row) {
                    $buttonAntrian = '
                    <a class="btn btn-success btn-call btn-sm"
                    title="Panggil Antrian"
                    data-noantrian="' . $row->noantrian_pservis . '"
                    >
                        <i class="fa-solid fa-volume-high"></i>
                    </a>
                    ';
                    $buttonDetail = '
                    <a title="Detail transaksi" class="btn btn-primary btn-sm" href="' . url('service/pengembalianServis/' . $row->id) . '">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </a>
                    ';

                    $button = '
                <div class="text-center">
                    ' . $buttonAntrian . '
                    ' . $buttonDetail . '
                </div>
                ';
                    return $button;
                })
                ->rawColumns(['action', 'created_at'])
                ->toJson();
        }

        return view('service::pengembalianServis.index');
    }

    public function show(Request $request, $id)
    {
        $penerimaanServis = new PenerimaanServis();
        $row = $penerimaanServis->transaksiServis($id);

        $hargaServis = new HargaServis();
        $getServis = $hargaServis->getServis()->get();

        foreach ($getServis as $key => $item) {
            $array_harga_servis[] = [
                'label' => '<strong>Nama Servis: ' . $item->nama_hargaservis . '</strong> <br />
                <span>Harga Servis: ' . UtilsHelper::formatUang($item->total_hargaservis) . '</span>',
                'id' => $item->id,
            ];
        }
        $usersId = Auth::id();
        $penerimaanServisId = $id;

        $barang = Barang::dataTable()
            ->with('satuan', 'kategori')
            ->where('status_barang', 'dijual & untuk servis')
            ->orWhere('status_barang', 'khusus servis')
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
        $tipeDiskon = json_encode($this->datastatis['tipe_diskon']);
        $statusKendaraanServis = ($this->datastatis['status_kendaraan_servis']);
        $serviceBerkala = ($this->datastatis['servis_berkala']);
        $cabangId = session()->get('cabang_id');

        $array_status_kendaraan = [];
        foreach ($statusKendaraanServis as $key => $item) {
            $array_status_kendaraan[] = [
                'label' => $item,
                'id' => $key,
            ];
        }

        $array_service_berkala = [];
        foreach ($serviceBerkala as $key => $item) {
            $array_service_berkala[] = [
                'label' => $item,
                'id' => $key,
            ];
        }

        $array_service_garansi = [];
        foreach ($serviceBerkala as $key => $item) {
            $array_service_garansi[] = [
                'label' => $item,
                'id' => $key,
            ];
        }

        // pembayaran
        $array_kategori_pembayaran = [];
        $kategoriPembayaran = KategoriPembayaran::dataTable()->where('status_kpembayaran', true)
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
        $penerimaanServis = $penerimaanServis->transaksiServis($penerimaanServisId);
        $dataHutang = $penerimaanServis->pembayaranServis;
        $totalHutang = 0;
        $totalHutang = 0;
        if (count($dataHutang) > 0) {
            $getPembayaranServis = UtilsHelper::paymentStatisPenerimaanServis($penerimaanServisId);
            $totalHutang = $getPembayaranServis['hutang'];
        }

        $totalHutang = $totalHutang;
        // end pembayaran

        $data = [
            'row' => $row,
            'jsonRow' => json_encode($row),
            'array_harga_servis' => $array_harga_servis,
            'getServis' => $getServis,
            'usersId' => $usersId,
            'barang' => $barang,
            'array_barang' => $array_barang,
            'tipeDiskon' => $tipeDiskon,
            'statusKendaraanServis' => $array_status_kendaraan,
            'serviceBerkala' => $array_service_berkala,
            'serviceGaransi' => $array_service_garansi,

            'kategoriPembayaran' => $kategoriPembayaran,
            'array_kategori_pembayaran' => $array_kategori_pembayaran,
            'subPembayaran' => $subPembayaran,
            'array_sub_pembayaran' => $array_sub_pembayaran,
            'dataUser' => $dataUser,
            'defaultUser' => $defaultUser,
            'cabangId' => $cabangId,
            'penerimaanServisId' => $penerimaanServisId,
            'totalHutang' => $totalHutang,
            'is_deposit' => $row->isdp_pservis,
            'getPembayaranServis' => json_encode(UtilsHelper::paymentStatisPenerimaanServis($penerimaanServisId)),
        ];

        if ($request->input('refresh_dataset')) {
            return response()->json($data);
        }

        return view('service::pengembalianServis.detail', $data);
    }


    public function update(Request $request, $id)
    {
        $penerimaan_servis = $request->input('penerimaan_servis');
        $nilaigaransi_pservis = $penerimaan_servis['nilaigaransi_pservis'];
        $tipegaransi_pservis = $penerimaan_servis['tipegaransi_pservis'];
        $checkTanggalGaransi = UtilsHelper::checkTanggalGaransi($penerimaan_servis);
        $servisgaransi_pservis = $checkTanggalGaransi;

        // pembayaran servis
        $pembayaran_servis = $request->input('pembayaran_servis');
        PembayaranServis::insert($pembayaran_servis);

        // penerimaan servis
        $penerimaan_servis = $request->input('penerimaan_servis');
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
        $saldo_customer = $request->input('saldo_customer');
        $customer_id = $saldo_customer['customer_id'];
        $saldo_customer_model = SaldoCustomer::where('customer_id', $customer_id)->first();
        if ($saldo_customer_model) {
            $saldo_customer_model->update([
                'customer_id' => $saldo_customer['customer_id'],
                'jumlah_saldocustomer' => $saldo_customer['jumlah_saldocustomer'],
                'cabang_id' => $saldo_customer['cabang_id'],
            ]);

            // saldo detail
            $saldo_detail = $request->input('saldo_detail');
            SaldoDetail::create([
                'saldo_customer_id' => $saldo_customer_model->id,
                'penerimaan_servis_id' => $saldo_detail['penerimaan_servis_id'],
                'totalsaldo_detail' => $saldo_detail['totalsaldo_detail'],
                'kembaliansaldo_detail' => $saldo_detail['kembaliansaldo_detail'],
                'hutangsaldo_detail' => $saldo_detail['hutangsaldo_detail'],
                'cabang_id' => $saldo_detail['cabang_id'],
            ]);
        }

        return response()->json([
            'message' => 'Berhasil melakukan transaksi pengembalian kendaraan',
        ], 201);
    }
}
