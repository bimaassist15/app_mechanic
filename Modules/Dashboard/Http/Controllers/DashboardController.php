<?php

namespace Modules\Dashboard\Http\Controllers;

use App\Http\Helpers\UtilsHelper;
use App\Models\Barang;
use App\Models\Pembelian;
use App\Models\PenerimaanServis;
use App\Models\Penjualan;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use DataTables;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $date = date('Y-m-d');

        // total penjualan
        $penjualan = new Penjualan();
        $getPenjualan = $penjualan->getReportPenjualan()
            ->whereDate('penjualan.transaksi_penjualan', $date)
            ->select(
                "*",
                DB::raw('sum(bayar_penjualan) as total_bayar_penjualan'),
                DB::raw('sum(kembalian_penjualan) as total_kembalian_penjualan'),
                DB::raw('sum(bayar_penjualan) + sum(kembalian_penjualan) as total_penjualan'),
            )
            ->get()
            ->sum('total_penjualan');
        //  end total penjualan

        // total penjualan cash
        $penjualanCash = new Penjualan();
        $getPenjualanCash = $penjualanCash->getReportPenjualan()
            ->where('tipe_penjualan', 'cash')
            ->whereDate('penjualan.transaksi_penjualan', $date)
            ->select(
                "*",
                DB::raw('sum(bayar_penjualan) as total_bayar_penjualan'),
                DB::raw('sum(kembalian_penjualan) as total_kembalian_penjualan'),
                DB::raw('sum(bayar_penjualan) + sum(kembalian_penjualan) as total_penjualan'),
            )
            ->get()
            ->sum('total_penjualan');
        //  end total penjualan cash

        // total penerimaan
        $penerimaan = new PenerimaanServis();
        $getPenerimaan = $penerimaan->getReportServis()
            ->whereDate('penerimaan_servis.created_at', $date)
            ->select(
                "*",
                DB::raw('sum(bayar_pservis) as total_bayar_pservis'),
                DB::raw('sum(kembalian_pservis) as total_kembalian_pservis'),
                DB::raw('sum(bayar_pservis) + sum(kembalian_pservis) as total_penerimaan'),
            )
            ->get()
            ->sum('total_penerimaan');
        //  end total penerimaan

        // total penerimaan cash
        $penerimaan = new PenerimaanServis();
        $getPenerimaanCash = $penerimaan->getReportServis()
            ->where('hutang_pservis', 0)
            ->whereDate('penerimaan_servis.created_at', $date)
            ->select(
                "*",
                DB::raw('sum(bayar_pservis) as total_bayar_pservis'),
                DB::raw('sum(kembalian_pservis) as total_kembalian_pservis'),
                DB::raw('sum(bayar_pservis) + sum(kembalian_pservis) as total_penerimaan'),
            )
            ->get()
            ->sum('total_penerimaan');
        //  end total penerimaan cash

        // jumlah barang terjual
        $getBarang = new Barang();
        $barangTerjual = $getBarang->getReportBarang()
            ->join('penjualan_product', 'penjualan_product.barang_id', '=', 'barang.id', 'left')
            ->select(
                'barang.*',
                'penjualan_product.created_at',
                'penjualan_product.jumlah_penjualanproduct'
            )
            ->whereDate('penjualan_product.created_at', $date)
            ->sum('penjualan_product.jumlah_penjualanproduct');
        // end jumlah barang

        // jumlah barang
        $jumlahBarang = Barang::dataTable()->get()->count();
        // jumlah barang

        // invoice penjualan
        $invoicePenjualan = new Penjualan();
        $getInvoicePenjualan = $invoicePenjualan->getReportPenjualan()->whereDate('penjualan.transaksi_penjualan', $date)->get()->count();
        // end invoice penjualan

        // servis masuk
        $penerimaanServis = new PenerimaanServis();
        $getServisMasuk = $penerimaanServis->getReportServis()
            ->whereDate('penerimaan_servis.created_at', $date)
            ->where('status_pservis', 'antrian servis masuk')
            ->get()->count();
        $getProsesServis = $penerimaanServis->getReportServis()
            ->whereDate('penerimaan_servis.created_at', $date)
            ->where('status_pservis', 'proses servis')
            ->get()->count();
        $getBisaDiambil = $penerimaanServis->getReportServis()
            ->whereDate('penerimaan_servis.created_at', $date)
            ->where('status_pservis', 'bisa diambil')
            ->get()->count();
        $getSudahDiambil = $penerimaanServis->getReportServis()
            ->whereDate('penerimaan_servis.created_at', $date)
            ->where('status_pservis', 'sudah diambil')
            ->get()->count();
        // end servis masuk



        $data = [
            'total_penjualan' => $getPenjualan,
            'total_penjualan_cash' => $getPenjualanCash,
            'barang_terjual' => $barangTerjual,
            'jumlah_barang' => $jumlahBarang,
            'invoice_penjualan' => $getInvoicePenjualan,
            'servis_masuk' => $getServisMasuk,
            'proses_servis' => $getProsesServis,
            'bisa_diambil' => $getBisaDiambil,
            'sudah_diambil' => $getSudahDiambil,
        ];
        return view('dashboard::index', $data);
    }

    public function piutangPenjualan()
    {
        $date = Carbon::now()->addDays(30);

        // total penjualan
        $penjualan = new Penjualan();
        $data = $penjualan->getReportPenjualan()
            ->where('tipe_penjualan', 'hutang')
            ->where('jatuhtempo_penjualan', '<', $date);

        return DataTables::eloquent($data)
            ->addColumn('transaksi_penjualan', function ($row) {
                return UtilsHelper::tanggalBulanTahunKonversi($row->transaksi_penjualan);
            })
            ->addColumn('jatuhtempo_penjualan', function ($row) {
                return UtilsHelper::formatDateLaporan($row->jatuhtempo_penjualan);
            })
            ->addColumn('total_penjualan', function ($row) {
                return UtilsHelper::formatUang($row->total_penjualan);
            })
            ->addColumn('action', function ($row) {
                $buttonDetail = '
                <a class="btn btn-info btn-detail-penjualan btn-sm" 
                data-typemodal="extraLargeModal"
                data-urlcreate="' . url('purchase/belumLunas/' . $row->id . '/show') . '"
                data-modalId="extraLargeModal"
                >
                    <i class="fa-solid fa-eye"></i>
                </a>
                ';

                $button = '
            <div class="text-center">
                ' . $buttonDetail . '
            </div>
            ';
                return $button;
            })
            ->toJson();
    }

    public function piutangPembelian()
    {
        $date = Carbon::now()->addDays(30);

        // total pembelian
        $pembelian = new Pembelian();
        $data = $pembelian->getReportpembelian()
            ->where('tipe_pembelian', 'hutang')
            ->where('jatuhtempo_pembelian', '<', $date);

        return DataTables::eloquent($data)
            ->addColumn('transaksi_pembelian', function ($row) {
                return UtilsHelper::tanggalBulanTahunKonversi($row->transaksi_pembelian);
            })
            ->addColumn('jatuhtempo_pembelian', function ($row) {
                return UtilsHelper::formatDateLaporan($row->jatuhtempo_pembelian);
            })
            ->addColumn('total_pembelian', function ($row) {
                return UtilsHelper::formatUang($row->total_pembelian);
            })
            ->addColumn('action', function ($row) {
                $buttonDetail = '
                <a class="btn btn-info btn-detail-pembelian btn-sm" 
                data-typemodal="extraLargeModal"
                data-urlcreate="' . url('transaction/belumLunas/' . $row->id . '/show') . '"
                data-modalId="extraLargeModal"
                >
                    <i class="fa-solid fa-eye"></i>
                </a>
                ';

                $button = '
            <div class="text-center">
                ' . $buttonDetail . '
            </div>
            ';
                return $button;
            })
            ->toJson();
    }
}
