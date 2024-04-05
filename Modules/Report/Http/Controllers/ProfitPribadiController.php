<?php

namespace Modules\Report\Http\Controllers;

use App\Http\Helpers\UtilsHelper;
use App\Models\Barang;
use App\Models\PenerimaanServis;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DataTables;
use Illuminate\Support\Facades\Auth;

class ProfitPribadiController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $dari_tanggal = $request->input('dari_tanggal');
            $sampai_tanggal = $request->input('sampai_tanggal');

            $getPenerimaanServis = new PenerimaanServis();
            $dataServis = $getPenerimaanServis->getReportServis();
            $dataServis = $dataServis->join('order_servis', 'order_servis.penerimaan_servis_id', '=', 'penerimaan_servis.id', 'left')
                ->join('harga_servis', 'harga_servis.id', '=', 'order_servis.harga_servis_id', 'left')
                ->join('users', 'users.id', '=', 'order_servis.users_id_mekanik', 'left')
                ->select('penerimaan_servis.*', 'order_servis.harga_servis_id', 'order_servis.users_id_mekanik', 'harga_servis.nama_hargaservis', 'harga_servis.jasa_hargaservis', 'harga_servis.profit_hargaservis', 'harga_servis.total_hargaservis', 'users.name as nama_mekanik');

            if ($dari_tanggal != null) {
                $dataServis = $dataServis->whereDate('penerimaan_servis.created_at', '>=', $dari_tanggal);
            }

            if ($sampai_tanggal != null) {
                $dataServis = $dataServis->whereDate('penerimaan_servis.updated_at', '<=', $sampai_tanggal);
            }
            if (Auth::id() != null) {
                $dataServis = $dataServis->where('order_servis.users_id_mekanik', '=', Auth::id());
            }

            return DataTables::eloquent($dataServis)
                ->addColumn('nama_mekanik', function ($row) {
                    $output = $row->nama_mekanik == null ? '-' : $row->nama_mekanik;
                    return $output;
                })
                ->addColumn('total_hargaservis', function ($row) {
                    $output = UtilsHelper::formatUang($row->total_hargaservis);
                    return $output;
                })
                ->addColumn('profit_hargaservis', function ($row) {
                    $output = UtilsHelper::formatUang($row->profit_hargaservis);
                    return $output;
                })
                ->addColumn('jasa_hargaservis', function ($row) {
                    $output = UtilsHelper::formatUang($row->jasa_hargaservis);
                    return $output;
                })
                ->toJson();
        }

        $dari_tanggal = date('d/m/Y');
        $sampai_tanggal = date('d/m/Y');
        $data = [
            'dari_tanggal' => $dari_tanggal,
            'sampai_tanggal' => $sampai_tanggal,
        ];

        return view('report::profitPribadi.index', $data);
    }
}
