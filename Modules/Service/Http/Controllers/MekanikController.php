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

class MekanikController extends Controller
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
                    $buttonAksi = '<a href="' . url('service/mekanik/' . $row->id) . '" class="btn btn-primary btn-sm" title="Detail Mekanik"><i class="fa-solid fa-pen-to-square"></i></a>';

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
        return view('service::mekanik.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('service::mekanik.form');
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

        return view('service::mekanik.detail', $data);
    }
}
