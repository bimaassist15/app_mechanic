<?php

namespace Modules\Report\Http\Controllers;

use App\Http\Helpers\UtilsHelper;
use App\Models\Barang;
use App\Models\Penjualan;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DataTables;
use Illuminate\Support\Facades\DB;

class ProdukController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $dari_tanggal = $request->input('dari_tanggal');
            $sampai_tanggal = $request->input('sampai_tanggal');
            $barang_id = $request->input('barang_id');
            if ($barang_id == '-') {
                $barang_id = null;
            }

            $getBarang = new Barang();
            $dataBarang = $getBarang->getReportBarang()
                ->withCount(['penjualanProduct', 'orderBarang'])
                ->withSum('penjualanProduct as penjualanProduct_sum', 'jumlah_penjualanproduct')
                ->withSum('orderBarang as orderBarang_sum', 'qty_orderbarang');

            if ($dari_tanggal != null) {
                $dataBarang = $dataBarang->whereDate('barang.updated_at', '>=', $dari_tanggal);
            }
            if ($sampai_tanggal != null) {
                $dataBarang = $dataBarang->whereDate('barang.updated_at', '<=', $sampai_tanggal);
            }
            if ($barang_id != null) {
                $dataBarang = $dataBarang->where('barang.id', $barang_id);
            }

            $dataBarang = $dataBarang
                ->get()
                ->map(function ($item) {
                    $item->total_sum = $item->penjualanProduct_sum + $item->orderBarang_sum;
                    return $item;
                });


            return DataTables::of($dataBarang)
                ->addColumn('updated_at', function ($row) {
                    return UtilsHelper::formatDate($row->updated_at);
                })
                ->addColumn('total_sum', function ($row) {
                    return UtilsHelper::formatUang($row->total_sum);
                })
                ->rawColumns(['total_sum'])
                ->toJson();
        }

        $dari_tanggal = date('d/m/Y');
        $sampai_tanggal = date('d/m/Y');
        $data = [
            'dari_tanggal' => $dari_tanggal,
            'sampai_tanggal' => $sampai_tanggal,
        ];
        return view('report::produk.index', $data);
    }
}
