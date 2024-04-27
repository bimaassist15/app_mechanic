<?php

namespace Modules\Service\Http\Controllers;

use App\Http\Helpers\UtilsHelper;
use App\Models\Barang;
use App\Models\HargaServis;
use App\Models\KategoriPembayaran;
use App\Models\KategoriServis;
use App\Models\Kendaraan;
use App\Models\PembayaranServis;
use App\Models\PenerimaanServis;
use App\Models\SaldoCustomer;
use App\Models\SaldoDetail;
use App\Models\ServiceHistory;
use App\Models\SubPembayaran;
use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class EstimasiServisController extends Controller
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
            $data = PenerimaanServis::dataTable()->where('status_pservis', 'estimasi servis');
            return DataTables::eloquent($data)
                ->addColumn('noantrian_pservis', function ($row) {
                    return ($row->noantrian_pservis == null ? '-' : $row->noantrian_pservis);
                })
                ->addColumn('estimasi_pservis', function ($row) {
                    return UtilsHelper::formatDateLaporan($row->estimasi_pservis);
                })
                ->addColumn('isrememberestimasi_pservis', function ($row) {
                    return $row->isrememberestimasi_pservis == true ? '<i class="fa-solid fa-check"></i>' : '<i class="fa-solid fa-x"></i>';
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
                            <a target="_blank" href="' . url('service/penerimaanServis/' . $row->id) . '"
                                class="dropdown-item d-flex align-items-center" target="_blank">
                                <i class="fa-solid fa-pencil"></i> &nbsp; Update Servis
                            </a>
                        </li>
                        <li>
                            <a href="' . url('service/penerimaanServis/' . $row->id . '?_method=delete') . '"
                                class="dropdown-item d-flex align-items-center btn-delete">
                                <i class="fa-solid fa-trash"></i> &nbsp; Delete</a>
                        </li>
                        <li>
                            <a href="' . url('service/penerimaanServis/create?isEdit=true&id=' . $row->id) . '"
                                class="dropdown-item d-flex align-items-center btn-edit" data-typemodal="extraLargeModal">
                                <i class="fa-solid fa-pencil"></i> &nbsp; Edit</a>
                        </li>
                        <li>
                            <a href="' . url('service/penerimaanServis/print/' . $row->id . '/penerimaanServis') . '"
                                class="dropdown-item d-flex align-items-center btn-print">
                                <i class="fa-solid fa-print"></i> &nbsp; Print Antrian</a>
                        </li>';

                    if (!$row->isrememberestimasi_pservis) {
                        $buttonAksi .= '
                        <li>
                            <a href="' . url('service/estimasiServis/remember/' . $row->id . '/estimasi?_method=put') . '"
                                class="dropdown-item d-flex align-items-center btn-remember-estimasi">
                                <i class="fa-brands fa-whatsapp"></i> &nbsp; Ingatkan Customer</a>
                        </li>';
                    }


                    $buttonAksi .= '
                    </ul>';



                    $button = '
                <div class="text-center">
                    ' . $buttonAksi . '
                </div>
                ';
                    return $button;
                })
                ->rawColumns(['action', 'isrememberestimasi_pservis'])
                ->toJson();
        }

        return view('service::estimasiServis.index');
    }


    public function remember(Request $request, $id)
    {
        $penerimaanServis = new PenerimaanServis();
        $getPenerimaanServis = $penerimaanServis->transaksiServis($id);

        $nowa_customer = $getPenerimaanServis->customer->nowa_customer;
        // $nowa_customer = 6282277506232;
        $nama_customer = $getPenerimaanServis->customer->nama_customer;
        $message = $this->datastatis['pesanwa_estimasi'];
        $created_at = UtilsHelper::formatDateLaporan($getPenerimaanServis->created_at);
        $createdApp = UtilsHelper::createdApp();

        // update
        $penerimaanServis = PenerimaanServis::find($id);
        $penerimaanServis->isrememberestimasi_pservis = true;
        $penerimaanServis->save();


        return response()->json([
            'status' => 'success',
            'message' => 'https://wa.me/' .
                $nowa_customer .
                '?text=' .
                urlencode(
                    "Kepada Yth: \nCustomer: " .
                        $nama_customer .
                        "\n" .
                        $message .
                        "\nterhitung semenjak transaksi dari tanggal " .
                        $created_at .
                        ".\nTerimakasih,\nSalam dari " .
                        $createdApp,
                ) .
                ''
        ]);
    }

    public function nextProcess(Request $request, $id)
    {
        $penerimaanServis = new PenerimaanServis();
        $getPenerimaanServis = $penerimaanServis->transaksiServis($id);
        $qtyOrderBarang = $getPenerimaanServis->orderBarang;

        foreach ($qtyOrderBarang as $key => $item) {
            $qty_orderbarang = $item->qty_orderbarang;
            $barang_id = $item->barang_id;

            $barang = Barang::find($barang_id);
            $barang->stok_barang = floatval($barang->stok_barang) - floatval($qty_orderbarang);
            $barang->save();
        }

        // update penerimaan servis
        $dateNow = date('Y-m-d');
        $noAntrianStatis = PenerimaanServis::dataTable()
            ->whereDate('created_at', $dateNow)
            ->where('status_pservis', '!=', null)
            ->orderBy('id', 'asc')
            ->pluck('noantrian_pservis')
            ->max();
        $noNotaStatis = PenerimaanServis::dataTable()
            ->where('status_pservis', '!=', null)
            ->orderBy('id', 'asc')
            ->pluck('nonota_pservis')
            ->max();

        $noAntrianStatis++;
        $noNotaStatis++;
        PenerimaanServis::find($id)->update([
            'noantrian_pservis' => $noAntrianStatis,
            'nonota_pservis' => $noNotaStatis,
        ]);

        return response()->json('Berhasil melanjutkan proses dari estimasi servis ke antrian servis masuk');
    }
}
