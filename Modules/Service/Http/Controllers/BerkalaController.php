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
                ->addColumn('action', function ($row) {
                    $nowa_customer = $row->customer->nowa_customer;
                    $nama_customer = $row->customer->nama_customer;
                    $created_at = UtilsHelper::formatDate($row->created_at);
                    $createdApp = UtilsHelper::createdApp();
                    $message = $row->pesanwa_pservis ?? "Kendaraan Anda Sudah Waktunya Melakukan Servis Berkala sesuai dengan tanggal yang sudah ditentukan dari kami.";

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
        $totalHutang = 0;
        $totalHutang = 0;
        if (count($dataHutang) > 0) {
            $getPembayaranServis = UtilsHelper::paymentStatisPenerimaanServis($penerimaanServisId);
            $totalHutang = $getPembayaranServis['hutang'];
        }

        $totalHutang = $totalHutang;
        // end pembayaran

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
        ];
        if ($request->ajax()) {
            $refresh = $request->input('refresh');
            if ($refresh) {
                return response()->json($data);
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