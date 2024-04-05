<?php

namespace Modules\Report\Http\Controllers;

use App\Http\Helpers\UtilsHelper;
use App\Models\Pembelian;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DataTables;
use Illuminate\Support\Facades\DB;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $dari_tanggal = $request->input('dari_tanggal');
            $sampai_tanggal = $request->input('sampai_tanggal');
            $supplier_id = $request->input('supplier_id');
            if ($supplier_id == '-') {
                $supplier_id = null;
            }

            $getPembelian = new Pembelian();
            $dataPembelian = $getPembelian->getReportPembelian()
                ->withSum('pembelianPembayaran as total_bayar_pembayaran', 'bayar_pbpembayaran')
                ->withSum('pembelianPembayaran as total_kembalian_pembayaran', 'kembalian_pbpembayaran');

            if ($dari_tanggal != null) {
                $dataPembelian = $dataPembelian->whereDate('pembelian.transaksi_pembelian', '>=', $dari_tanggal);
            }
            if ($sampai_tanggal != null) {
                $dataPembelian = $dataPembelian->whereDate('pembelian.updated_at', '<=', $sampai_tanggal);
            }
            if ($supplier_id != null) {
                $dataPembelian = $dataPembelian->where('supplier_id', $supplier_id);
            }
            $dataPembelian = $dataPembelian->get()->map(function ($item) {
                $item->total_pembayaran = $item->total_bayar_pembayaran - $item->total_kembalian_pembayaran;
                return $item;
            });

            return DataTables::of($dataPembelian)
                ->addColumn('transaksi_pembelian', function ($row) {
                    return UtilsHelper::tanggalBulanTahunKonversi($row->transaksi_pembelian);
                })
                ->addColumn('total_pembayaran', function ($row) {
                    return UtilsHelper::formatUang($row->total_pembayaran);
                })
                ->rawColumns(['transaksi_pembelian'])
                ->toJson();
        }

        $dari_tanggal = date('d/m/Y');
        $sampai_tanggal = date('d/m/Y');
        $data = [
            'dari_tanggal' => $dari_tanggal,
            'sampai_tanggal' => $sampai_tanggal,
        ];
        return view('report::supplier.index', $data);
    }
}
