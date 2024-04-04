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
        $getPembelian = new Pembelian();
        $dataPembelian = $getPembelian->getReportPembelian()
            ->withCount([
                'pembelianPembayaran as total_pembelian_transaksi' => function ($query) {
                    $query->select(DB::raw("SUM(bayar_pbpembayaran) - SUM(kembalian_pbpembayaran)"));
                },
            ])
            ->get();
        dd($dataPembelian);

        if ($request->ajax()) {
            $dari_tanggal = $request->input('dari_tanggal');
            $sampai_tanggal = $request->input('sampai_tanggal');
            $supplier_id = $request->input('supplier_id');
            if ($supplier_id == '-') {
                $supplier_id = null;
            }

            $getPembelian = new Pembelian();
            $dataPembelian = $getPembelian->getReportPembelian()
                ->withSum('pembelianPembayaran as total_bayar_pembayaran', 'bayar_pembayaran')
                ->withSum('pembelianPembayaran as total_kembalian_pembayaran', 'kembalian_pembayaran');

            if ($dari_tanggal != null) {
                $dataPembelian = $dataPembelian->whereDate('pembelian.created_at', '>=', $dari_tanggal);
            }
            if ($sampai_tanggal != null) {
                $dataPembelian = $dataPembelian->whereDate('pembelian.updated_at', '<=', $sampai_tanggal);
            }
            if ($supplier_id != null) {
                $dataPembelian = $dataPembelian->where('supplier_id', $supplier_id);
            }

            return DataTables::eloquent($dataPembelian)
                ->addColumn('transaksi_pembelian', function ($row) {
                    return UtilsHelper::formatDate($row->transaksi_pembelian);
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
