<?php

namespace Modules\Report\Http\Controllers;

use App\Http\Helpers\UtilsHelper;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DataTables;
use Illuminate\Support\Facades\DB;

class StokTerkecilController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $getBarang = new Barang();
            $dataBarang = $getBarang->getReportBarang()->orderBy('stok_barang', 'asc');

            return DataTables::eloquent($dataBarang)
                ->addColumn('hargajual_barang', function ($row) {
                    return UtilsHelper::formatUang($row->hargajual_barang);
                })
                ->addColumn('stok_barang', function ($row) {
                    return UtilsHelper::formatUang($row->stok_barang);
                })
                ->toJson();
        }

        return view('report::stokTerkecil.index');
    }
}
