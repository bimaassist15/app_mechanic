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
