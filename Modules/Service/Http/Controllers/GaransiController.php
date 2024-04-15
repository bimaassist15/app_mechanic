<?php

namespace Modules\Service\Http\Controllers;

use App\Http\Helpers\UtilsHelper;
use App\Models\Barang;
use App\Models\PenerimaanServis;
use App\Models\HargaServis;
use App\Models\KategoriPembayaran;
use App\Models\ServiceHistory;
use App\Models\SubPembayaran;
use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class GaransiController extends Controller
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
            $data = PenerimaanServis::dataTable()
                ->where('servisgaransi_pservis', '!=', null)
                ->orderBy('id', 'desc');
            return DataTables::eloquent($data)
                ->addColumn('created_at', function ($row) {
                    return UtilsHelper::tanggalBulanTahunKonversi($row->created_at);
                })
                ->addColumn('tanggalambil_pservis', function ($row) {
                    return  $row->tanggalambil_pservis == null ? '-' : UtilsHelper::tanggalBulanTahunKonversi($row->tanggalambil_pservis);
                })
                ->addColumn('servisgaransi_pservis', function ($row) {
                    return  $row->servisgaransi_pservis == null ? '-' : UtilsHelper::formatDate($row->servisgaransi_pservis);
                })
                ->addColumn('action', function ($row) {
                    $buttonAction = '
                    <a class="btn btn-primary btn-sm" target="_blank" href="' . url('service/garansi/' . $row->id) . '">
                        <i class="fa-solid fa-pen-to-square text-white"></i>
                    </a>
                    ';
                    return $buttonAction;
                })
                ->rawColumns(['action'])
                ->toJson();
        }
        return view('service::garansi.index');
    }

    // /**
    //  * Show the form for creating a new resource.
    //  * @return Renderable
    //  */
    // public function create()
    // {
    //     return view('service::kendaraanServis.form');
    // }

    // /**
    //  * Store a newly created resource in storage.
    //  * @param Request $request
    //  * @return Renderable
    //  */
    // public function store(Request $request)
    // {
    //     //
    // }

    // /**
    //  * Show the specified resource.
    //  * @param int $id
    //  * @return Renderable
    //  */
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

        return view('service::garansi.detail', $data);
    }
    public function update(Request $request, $id)
    {
        // validate date service
        $dateNow = date('Y-m-d');
        $servisgaransi_pservis = PenerimaanServis::find($id)->servisgaransi_pservis;

        if ($servisgaransi_pservis < $dateNow) {
            return response()->json(['status' => 'error', 'message' => 'Tanggal servis garansi sudah expired']);
        }

        // users
        $data = [
            'garansi_pservis' => $request->input('garansi_pservis'),
            'users_id_garansi' => Auth::id(),
            'status_pservis' => 'komplain garansi',
        ];
        PenerimaanServis::find($id)->update($data);

        // create history
        ServiceHistory::create([
            'penerimaan_servis_id' => $id,
            'status_histori' => 'komplain garansi',
            'cabang_id' => session()->get('cabang_id'),
        ]);
        return response()->json(['status' => 'success', 'message' => 'Berhasil mengajukan komplain garansi']);
    }
}
