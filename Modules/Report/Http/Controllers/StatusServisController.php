<?php

namespace Modules\Report\Http\Controllers;

use App\Http\Helpers\UtilsHelper;
use App\Models\PenerimaanServis;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DataTables;
use Illuminate\Support\Facades\Config;

class StatusServisController extends Controller
{

    public $datastatis;
    public function __construct()
    {
        $this->datastatis = Config::get('datastatis');
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $status_pservis = $request->input('status_pservis');

            $getPenerimaanServis = new PenerimaanServis();
            $dataServis = $getPenerimaanServis->getReportServis();
            if ($status_pservis != null) {
                $dataServis->where('status_pservis', $status_pservis);
            }
            $dataServis = $dataServis;
            return DataTables::eloquent($dataServis)
                ->addColumn('created_at', function ($row) {
                    return UtilsHelper::tanggalBulanTahunKonversi($row->created_at);
                })
                ->addColumn('updated_at', function ($row) {
                    return UtilsHelper::tanggalBulanTahunKonversi($row->updated_at);
                })
                ->addColumn('mulai_servis', function ($row) {
                    $status_history = $row->serviceHistory;
                    $filterData = $status_history->firstWhere('status_histori', 'proses servis');

                    $output = $row->created_at;
                    if ($filterData != null) {
                        $output = $filterData->created_at;
                    }
                    $mulaiServis = UtilsHelper::tanggalBulanTahunKonversi($output);
                    return $mulaiServis;
                })
                ->addColumn('lama_servis', function ($row) {
                    return $row->days_difference . ' Hari';
                })
                ->addColumn('action', function ($row) {
                    $buttonAksi = '
                        <a target="_blank" href="' . url('service/kendaraanServis/' . $row->id) . '"
                        class="btn btn-primary">
                            <i class="fa-solid fa-pen-to-square"></i> &nbsp; Servis
                        </a>
                    ';

                    $button = '
                <div class="text-center">
                    ' . $buttonAksi . '
                </div>
                ';
                    return $button;
                })
                ->rawColumns(['action'])
                ->toJson();
        }

        $statusServis = $this->datastatis['status_kendaraan_servis'];
        $statusServis = array_merge($statusServis, [
            'komplain garansi' => 'Komplain Garansi',
            'sudah diambil' => 'Sudah Diambil',
        ]);
        $arrayStatusServis = [];
        foreach ($statusServis as $id => $value) {
            $arrayStatusServis[] = [
                'id' => $id,
                'label' => $value,
            ];
        }
        $data = ['status_pservis' => $arrayStatusServis];
        return view('report::statusPServis.index', $data);
    }
}
