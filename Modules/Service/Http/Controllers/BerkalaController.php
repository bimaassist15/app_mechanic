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

class BerkalaController extends Controller
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
                ->where('servisberkala_pservis', '!=', null)
                ->orderBy('id', 'desc');
            $pesanwa_berkala = $this->datastatis['pesanwa_berkala'];

            return DataTables::eloquent($data)
                ->addColumn('created_at', function ($row) {
                    return UtilsHelper::tanggalBulanTahunKonversi($row->created_at);
                })
                ->addColumn('tanggalambil_pservis', function ($row) {
                    return  $row->tanggalambil_pservis == null ? '-' : UtilsHelper::tanggalBulanTahunKonversi($row->tanggalambil_pservis);
                })
                ->addColumn('servisberkala_pservis', function ($row) {
                    return  $row->servisberkala_pservis == null ? '-' : UtilsHelper::formatDate($row->servisberkala_pservis);
                })
                ->addColumn('is_reminded', function ($row) {
                    return  $row->is_reminded ? '<i class="fa-solid fa-check"></i>' : '<i class="fa-solid fa-xmark"></i>';
                })
                ->addColumn('action', function ($row) use ($pesanwa_berkala) {
                    $nowa_customer = $row->customer->nowa_customer;
                    $nama_customer = $row->customer->nama_customer;
                    $created_at = UtilsHelper::formatDate($row->created_at);
                    $createdApp = UtilsHelper::createdApp();
                    $message = $row->pesanwa_pservis ?? $pesanwa_berkala;

                    $buttonAction = '
                    <div class="text-center">
                        <a class="btn btn-primary btn-sm" target="_blank" href="' . url('service/berkala/' . $row->id) . '">
                            <i class="fa-solid fa-pen-to-square text-white"></i>
                        </a>
                        <a class="btn btn-success btn-sm btn-send-wa" target="_blank" href="https://wa.me/' . $nowa_customer . '?text=' . urlencode("Kepada Yth: \nCustomer: " . $nama_customer . "\n" . $message . "\nterhitung semenjak kamu servis dari tanggal " . $created_at . ".\nTerimakasih,\nSalam dari " . $createdApp) . '" data-id="' . $row->id . '">
                            <i class="fa-brands fa-whatsapp"></i>
                        </a>
                    </div>
                    ';
                    return $buttonAction;
                })
                ->rawColumns(['action', 'is_reminded'])
                ->toJson();
        }
        return view('service::berkala.index');
    }

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

        return view('service::berkala.detail', $data);
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

    public function setReminded(Request $request, $id)
    {
        $data = [
            'is_reminded' => true,
        ];
        PenerimaanServis::find($id)->update($data);
        return response()->json('Berhasil menginfokankan customer');
    }
}
