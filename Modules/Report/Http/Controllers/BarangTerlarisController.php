<?php

namespace Modules\Report\Http\Controllers;

use App\Http\Helpers\UtilsHelper;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DataTables;
use Illuminate\Support\Facades\DB;

class BarangTerlarisController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $getBarang = new Barang();
            $dataBarang = $getBarang->getReportBarang()
                ->join('penjualan_product', 'penjualan_product.barang_id', '=', 'barang.id', 'left')
                ->join('order_barang', 'order_barang.barang_id', '=', 'barang.id', 'left')
                ->select(
                    'barang.*',
                    'penjualan_product.transaksi_penjualanproduct',
                    'order_barang.updated_at as tanggal_orderbarang',
                    DB::raw('SUM(penjualan_product.jumlah_penjualanproduct) as jumlah_penjualanproduct'),
                    DB::raw('SUM(order_barang.qty_orderbarang) as qty_orderbarang'),
                )
                ->groupBy('barang.id');
            $dataBarang = $dataBarang->get();
            $dataBarang = $dataBarang->map(function ($item) {
                $item->total_sum = $item->jumlah_penjualanproduct + $item->qty_orderbarang;
                return $item;
            });
            $dataBarang = $dataBarang->sortByDesc('total_sum');

            return DataTables::of($dataBarang)
                ->addColumn('transaksi_penjualanproduct', function ($row) {
                    return $row->transaksi_penjualanproduct == null ? $row->tanggal_orderbarang == null ? '-' : UtilsHelper::tanggalBulanTahunKonversi($row->tanggal_orderbarang) : UtilsHelper::tanggalBulanTahunKonversi($row->transaksi_penjualanproduct);
                })
                ->addColumn('hargajual_barang', function ($row) {
                    return UtilsHelper::formatUang($row->hargajual_barang);
                })
                ->addColumn('total_sum', function ($row) {
                    return UtilsHelper::formatUang($row->total_sum);
                })
                ->rawColumns(['total_sum'])
                ->toJson();
        }

        return view('report::barangTerlaris.index');
    }
}
