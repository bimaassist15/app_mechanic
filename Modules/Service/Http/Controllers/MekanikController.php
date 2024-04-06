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
        $penerimaanServis = new PenerimaanServis();
        $row = $penerimaanServis->transaksiServis($id);

        $hargaServis = new HargaServis();
        $getServis = $hargaServis->getServis()->get();

        foreach ($getServis as $key => $item) {
            $array_harga_servis[] = [
                'label' => '<strong>Nama Servis: ' . $item->nama_hargaservis . '</strong> <br />
                <span>Harga Servis: ' . UtilsHelper::formatUang($item->total_hargaservis) . '</span>',
                'id' => $item->id,
            ];
        }
        $usersId = Auth::id();
        $penerimaanServisId = $id;

        $barang = Barang::dataTable()
            ->with('satuan', 'kategori')
            ->where('status_barang', 'dijual & untuk servis')
            ->orWhere('status_barang', 'khusus servis')
            ->get();
        $array_barang = [];
        foreach ($barang as $key => $item) {
            $array_barang[] = [
                'id' => $item->id,
                'label' => '
            <strong>[' . $item->barcode_barang . '] ' . $item->nama_barang . '</strong> <br />
            <span>Stok: ' . $item->stok_barang . '</span>
            '
            ];
        }
        $tipeDiskon = json_encode($this->datastatis['tipe_diskon']);
        $statusKendaraanServis = ($this->datastatis['status_kendaraan_servis']);
        $serviceBerkala = ($this->datastatis['servis_berkala']);
        $cabangId = session()->get('cabang_id');

        $array_status_kendaraan = [];
        foreach ($statusKendaraanServis as $key => $item) {
            $array_status_kendaraan[] = [
                'label' => $item,
                'id' => $key,
            ];
        }

        $array_service_berkala = [];
        foreach ($serviceBerkala as $key => $item) {
            $array_service_berkala[] = [
                'label' => $item,
                'id' => $key,
            ];
        }

        $array_service_garansi = [];
        foreach ($serviceBerkala as $key => $item) {
            $array_service_garansi[] = [
                'label' => $item,
                'id' => $key,
            ];
        }

        // pembayaran
        $array_kategori_pembayaran = [];
        $kategoriPembayaran = KategoriPembayaran::dataTable()->where('status_kpembayaran', true)
            ->get();
        foreach ($kategoriPembayaran as $value => $item) {
            $array_kategori_pembayaran[] = [
                'id' => $item->id,
                'label' => $item->nama_kpembayaran
            ];
        }
        $kategoriPembayaran = json_encode($kategoriPembayaran);
        $array_kategori_pembayaran = json_encode($array_kategori_pembayaran);

        $array_sub_pembayaran = [];
        $subPembayaran = SubPembayaran::dataTable()->where('status_spembayaran', true)
            ->get();
        foreach ($subPembayaran as $value => $item) {
            $array_sub_pembayaran[] = [
                'id' => $item->id,
                'label' => $item->nama_spembayaran,
                'kategori_pembayaran_id' => $item->kategori_pembayaran_id
            ];
        }
        $subPembayaran = json_encode($subPembayaran);
        $array_sub_pembayaran = json_encode($array_sub_pembayaran);

        $dataUser = User::dataTable()
            ->join('roles', 'roles.id', '=', 'users.roles_id')
            ->with('profile')
            ->select('users.*', 'roles.id as roles_id', 'roles.name as roles_name', 'roles.guard_name as roles_guard')
            ->get();
        $dataUser = json_encode($dataUser);
        $defaultUser = Auth::id();
        $cabangId = session()->get('cabang_id');

        $penerimaanServis = new PenerimaanServis();
        $penerimaanServis = $penerimaanServis->transaksiServis($penerimaanServisId);
        $dataHutang = $penerimaanServis->pembayaranServis;

        $getPembayaranServis = UtilsHelper::paymentStatisPenerimaanServis($penerimaanServisId);
        $totalHutang = $getPembayaranServis['hutang'];
        if (count($dataHutang) > 0) {
            $getPembayaranServis = UtilsHelper::paymentStatisPenerimaanServis($penerimaanServisId);
            $totalHutang = $getPembayaranServis['hutang'];
        }

        $totalHutang = $totalHutang;
        // end pembayaran

        $pesanwa_berkala = $this->datastatis['pesanwa_berkala'];
        $data = [
            'row' => $row,
            'jsonRow' => json_encode($row),
            'array_harga_servis' => $array_harga_servis,
            'getServis' => $getServis,
            'usersId' => $usersId,
            'barang' => $barang,
            'array_barang' => $array_barang,
            'tipeDiskon' => $tipeDiskon,
            'statusKendaraanServis' => $array_status_kendaraan,
            'serviceBerkala' => $array_service_berkala,
            'serviceGaransi' => $array_service_garansi,

            'kategoriPembayaran' => $kategoriPembayaran,
            'array_kategori_pembayaran' => $array_kategori_pembayaran,
            'subPembayaran' => $subPembayaran,
            'array_sub_pembayaran' => $array_sub_pembayaran,
            'dataUser' => $dataUser,
            'defaultUser' => $defaultUser,
            'cabangId' => $cabangId,
            'penerimaanServisId' => $penerimaanServisId,
            'totalHutang' => $totalHutang,
            'is_deposit' => $row->isdp_pservis,
            'getPembayaranServis' => json_encode(UtilsHelper::paymentStatisPenerimaanServis($penerimaanServisId)),
            'pesanwa_berkala' => $pesanwa_berkala
        ];
        if ($request->ajax()) {
            $refresh = $request->input('refresh');
            if ($refresh) {
                return response()->json($data);
            }
        }

        return view('service::mekanik.detail', $data);
    }
}
