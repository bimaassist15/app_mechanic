<?php

namespace Modules\Report\Http\Controllers;

use App\Http\Helpers\UtilsHelper;
use App\Models\PenerimaanServis;
use App\Models\ServiceHistory;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DataTables;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class StatusServisPeriodeController extends Controller
{

    public $datastatis;
    public function __construct()
    {
        $this->datastatis = Config::get('datastatis');
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $dari_tanggal = $request->input('dari_tanggal');
            $sampai_tanggal = $request->input('sampai_tanggal');

            $serviceHistory = ServiceHistory::dataTable()
                ->groupBy('status_histori')
                ->select("*", DB::raw("count(*) as total_histori"));

            if ($dari_tanggal != null) {
                $serviceHistory->whereDate('created_at', '>=', $dari_tanggal);
            }
            if ($sampai_tanggal != null) {
                $serviceHistory->whereDate('updated_at', '<=', $sampai_tanggal);
            }

            $serviceHistory = $serviceHistory;
            return DataTables::eloquent($serviceHistory)
                ->addColumn('total_histori', function ($row) {
                    return UtilsHelper::formatUang($row->total_histori);
                })
                ->toJson();
        }
        $data = [
            'dari_tanggal' => date('d/m/Y'),
            'sampai_tanggal' => date('d/m/Y'),
        ];
        return view('report::statusServisPeriode.index', $data);
    }
}
