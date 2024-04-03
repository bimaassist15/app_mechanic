<?php

namespace Modules\Report\Http\Controllers;

use App\Http\Helpers\UtilsHelper;
use App\Models\Penjualan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DataTables;


class KasirController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $dari_tanggal = $request->input('dari_tanggal');
            $sampai_tanggal = $request->input('sampai_tanggal');
            $users_id = $request->input('users_id');
            if ($users_id == '-') {
                $users_id = null;
            }

            $getPenjualan = new Penjualan();
            $dataPenjualan = $getPenjualan->getReportPenjualan();
            if ($dari_tanggal != null) {
                $dataPenjualan = $dataPenjualan->whereDate('created_at', '>=', $dari_tanggal);
            }
            if ($sampai_tanggal != null) {
                $dataPenjualan = $dataPenjualan->whereDate('updated_at', '<=', $sampai_tanggal);
            }
            if ($users_id != null) {
                $dataPenjualan = $dataPenjualan->where('users_id', $users_id);
            }

            return DataTables::eloquent($dataPenjualan)
                ->addColumn('transaksi_penjualan', function ($row) {
                    return UtilsHelper::tanggalBulanTahunKonversi($row->transaksi_penjualan);
                })
                ->addColumn('total_penjualan', function ($row) {
                    $bayarPenjualan = $row->bayar_penjualan;
                    $kembalianPenjualan = $row->kembalian_penjualan;
                    $calculate = $bayarPenjualan - $kembalianPenjualan;
                    return UtilsHelper::formatUang($calculate);
                })
                ->rawColumns(['transaksi_penjualan', 'total_penjualan'])
                ->toJson();;
        }

        $dari_tanggal = date('d/m/Y');
        $sampai_tanggal = date('d/m/Y');
        $data = [
            'dari_tanggal' => $dari_tanggal,
            'sampai_tanggal' => $sampai_tanggal,
        ];
        return view('report::kasir.index', $data);
    }
}
