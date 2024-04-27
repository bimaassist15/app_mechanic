<?php

namespace Modules\Service\Http\Controllers;

use App\Http\Helpers\UtilsHelper;
use App\Models\Barang;
use App\Models\PenerimaanServis;
use App\Models\HargaServis;
use App\Models\KategoriPembayaran;
use App\Models\SubPembayaran;
use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class KendaraanServisController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public $datastatis;
    public function __construct()
    {
        $this->datastatis = Config::get('datastatis');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = PenerimaanServis::dataTable()->orderBy('id', 'desc');
            return DataTables::eloquent($data)
                ->addColumn('created_at', function ($row) {
                    return UtilsHelper::tanggalBulanTahunKonversi($row->created_at);
                })
                ->addColumn('tanggalambil_pservis', function ($row) {
                    return  $row->tanggalambil_pservis == null ? '-' : UtilsHelper::tanggalBulanTahunKonversi($row->tanggalambil_pservis);
                })
                ->addColumn('action', function ($row) {
                    $buttonAksi = '
                    <button type="button" 
                    class="btn btn-primary dropdown-toggle" 
                    data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <i class="bx bx-menu me-1"></i> 
                    Aksi
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="' . url('service/print/kendaraan/selesaiServis?penerimaan_servis_id=' . $row->id) . '"
                                class="dropdown-item d-flex align-items-center btn-print">
                                <i class="fa-solid fa-print"></i> &nbsp; Print Nota</a>
                        </li>
                        <li>
                            <a href="' . url('service/kendaraanServis/' . $row->id) . '"
                                class="dropdown-item d-flex align-items-center">
                                <i class="fa-solid fa-pen-to-square"></i> &nbsp; Servis</a>
                        </li>
                        <li>
                            <a href="' . url('service/penerimaanServis/' . $row->id . '?_method=delete') . '"
                                class="dropdown-item d-flex align-items-center btn-delete">
                                <i class="fa-solid fa-trash"></i> &nbsp; Delete</a>
                        </li>
                        
                    </ul>';



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
        return view('service::kendaraanServis.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('service::kendaraanServis.form');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(Request $request, $id)
    {
        $data = UtilsHelper::dataUpdateServis($id, $this->datastatis);
        if ($request->ajax()) {
            $loadData = $request->input('loadData');
            if ($loadData) {
                return response()->json([
                    'view' => view('service::penerimaanServis.output_detail', $data)->render(),
                    'data' => $data,
                ], 200);
            }
        }

        return view('service::kendaraanServis.detail', $data);
    }
}
