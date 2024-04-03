<?php

namespace Modules\Transaction\Http\Controllers;

use App\Http\Helpers\UtilsHelper;
use App\Models\KategoriPembayaran;
use App\Models\Pembelian;
use App\Models\PembelianCicilan;
use App\Models\SubPembayaran;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class PembelianCicilanController extends Controller
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
            $pembelianCiciclan = new PembelianCicilan();
            $pembelian_id = $request->query('pembelian_id');
            $data = $pembelianCiciclan->dataTable($pembelian_id);

            return DataTables::eloquent($data)
                ->addColumn('bayar_pbcicilan', function ($row) {
                    $output = UtilsHelper::formatUang($row->bayar_pbcicilan);
                    return $output;
                })
                ->addColumn('hutang_pbcicilan', function ($row) {
                    $output = UtilsHelper::formatUang($row->hutang_pbcicilan);
                    return $output;
                })
                ->addColumn('kembalian_pbcicilan', function ($row) {
                    $output = UtilsHelper::formatUang($row->kembalian_pbcicilan);
                    return $output;
                })
                ->addColumn('action', function ($row) {
                    $buttonDetail = '
                    <a class="btn btn-info btn-detail btn-sm" 
                    data-typemodal="extraLargeModal"
                    data-urlcreate="' . url('transaction/pembelianCicilan/' . $row->id) . '"
                    data-modalId="extraLargeModal"
                    >
                        <i class="fa-solid fa-eye"></i>
                    </a>
                    ';

                    $button = '
                <div class="text-center">
                    ' . $buttonDetail . '
                </div>
                ';
                    return $button;
                })
                ->rawColumns(['action'])
                ->toJson();
        }
        $pembelian_id = $request->query('pembelian_id');
        $pembelian = Pembelian::find($pembelian_id);

        return view('transaction::pembelianCicilan.index', compact('pembelian'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create(Request $request)
    {
        $array_kategori_pembayaran = [];
        $kategoriPembayaran = KategoriPembayaran::dataTable()->where('status_kpembayaran', true)
            ->whereNot('nama_kpembayaran', 'like', '%deposit%')
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
        $pembelianId = $request->query('pembelian_id');
        $isEdit = $request->query('isEdit');
        $pembelian = new Pembelian();
        $dataSupplier = Supplier::dataTable()->get();

        $array_supplier = [];
        foreach ($dataSupplier as $key => $item) {
            $array_supplier[] = [
                'id' => $item->id,
                'label' => '<strong>Supplier: ' . $item->nama_supplier . '</strong> <br />
                <span>Perusahaan: ' . $item->perusahaan_supplier . '</span>
                ',
            ];
        }

        $pembelian = new Pembelian();
        $pembelian = $pembelian->invoicePembelian($pembelianId);
        $dataHutang = $pembelian->pembelianCicilan;

        $totalHutang = 0;
        $totalBayar = 0;
        $totalKembalian = 0;
        if (count($dataHutang) > 0) {
            foreach ($dataHutang as $key => $item) {
                $totalBayar += $item->bayar_pbcicilan;
                $totalKembalian += $item->kembalian_pbcicilan;
            }
            $totalHutang = $totalKembalian > 0 ?  $totalBayar - $totalKembalian : $dataHutang[0]->bayar_pbcicilan + $dataHutang[0]->hutang_pbcicilan;
        }

        $totalHutang = $isEdit == true ? $totalHutang : $pembelian->hutang_pembelian;
        $data = [
            'array_kategori_pembayaran' => $array_kategori_pembayaran,
            'kategoriPembayaran' => $kategoriPembayaran,
            'subPembayaran' => $subPembayaran,
            'array_sub_pembayaran' => $array_sub_pembayaran,
            'dataUser' => $dataUser,
            'defaultUser' => $defaultUser,
            'cabangId' => $cabangId,
            'pembelian_id' => $pembelianId,
            'isEdit' => $isEdit,
            'pembelian' => $pembelian,
            'totalHutang' => $totalHutang,
            'getPembelian' => UtilsHelper::paymentStatisPembelian($pembelianId),
        ];
        if ($request->input('refresh_dataset')) {
            return response()->json($data);
        }

        return view('transaction::pembelianCicilan.form', $data);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        // payload is edit
        $payloadIsEdit = $request->input('payload_is_edit');
        if ($payloadIsEdit['isEdit'] == true) {
            $pembelian_id = $payloadIsEdit['pembelian_id'];
            $pembelianCicilan = PembelianCicilan::dataTableCabang()->where('pembelian_id', $pembelian_id)
                ->orderBy('id', 'desc')->get();
            foreach ($pembelianCicilan as $key => $item) {
                $id = $item->id;
                $getData = PembelianCicilan::find($id);
                $pembelian_id = $getData->pembelian_id;

                $dataBayar = $getData->bayar_pbcicilan;
                $dataKembalian = $getData->kembalian_pbcicilan;

                $pembelian = Pembelian::find($pembelian_id);
                $totalPembelian = $pembelian->total_pembelian;

                $getBayar = floatval($pembelian->bayar_pembelian) - floatval($dataBayar);
                $getHutang = floatval($totalPembelian) - floatval($getBayar);
                $getKembalian = floatval($pembelian->kembalian_pembelian) - floatval($dataKembalian);

                $pembelian->bayar_pembelian = $getBayar;
                $pembelian->hutang_pembelian = $getHutang < 0 ? 0 : $getHutang;
                $pembelian->kembalian_pembelian = $getKembalian;
                $pembelian->save();

                PembelianCicilan::destroy($id);
            }
        }

        // pembelian
        $pembelian = $request->input('pembelian');
        $getPembelian = Pembelian::find($pembelian['pembelian_id']);
        $getPembelian->hutang_pembelian = floatval($pembelian['hutang_pembelian']);
        $getPembelian->kembalian_pembelian = floatval($pembelian['kembalian_pembelian']);
        $getPembelian->tipe_pembelian = $pembelian['tipe_pembelian'];
        $getPembelian->bayar_pembelian = floatval($getPembelian->bayar_pembelian) + floatval($pembelian['bayar_pembelian']);
        $getPembelian->tipe_pembelian = $pembelian['tipe_pembelian'];
        $getPembelian->updated_at = date('Y-m-d H:i:s');
        $getPembelian->save();

        // pembelian cicilan
        $pembelianCicilan = $request->input('pembelian_cicilan');
        PembelianCicilan::insert($pembelianCicilan);

        $message = 'Berhasil tambah data';
        if ($payloadIsEdit['isEdit'] == true) {
            $message = 'Berhasil edit transaksi';
        }

        return response()->json([
            'message' => $message,
            'result' => $getPembelian->id,
        ], 201);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $pembelianCicilan = PembelianCicilan::find($id);
        $pembelian_id = $pembelianCicilan->pembelian_id;
        $pembelian = new Pembelian();
        $row = $pembelian->invoicePembelian($pembelian_id);
        $jsonRow = json_encode($row);
        return view('transaction::pembelianCicilan.detail', compact('row', 'jsonRow', 'pembelianCicilan'));
    }

    public function print()
    {
        $pembelian = new Pembelian();
        $pembelian_id = request()->query('pembelian_id');
        $pembelian = $pembelian->invoicePembelian($pembelian_id);
        $myCabang = UtilsHelper::myCabang();
        return view('transaction::pembelianCicilan.print', compact('pembelian', 'myCabang'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('transaction::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $getData = PembelianCicilan::find($id);
        $pembelian_id = $getData->pembelian_id;

        $dataBayar = $getData->bayar_pbcicilan;
        $dataKembalian = $getData->kembalian_pbcicilan;

        $pembelian = Pembelian::find($pembelian_id);
        $totalPembelian = $pembelian->total_pembelian;

        $getBayar = floatval($pembelian->bayar_pembelian) - floatval($dataBayar);
        $getHutang = floatval($totalPembelian) - floatval($getBayar);
        $getKembalian = floatval($pembelian->kembalian_pembelian) - floatval($dataKembalian);

        $pembelian->bayar_pembelian = $getBayar;
        $pembelian->hutang_pembelian = $getHutang < 0 ? 0 : $getHutang;
        $pembelian->kembalian_pembelian = $getKembalian;
        $pembelian->save();

        PembelianCicilan::destroy($id);
        return response()->json('Berhasil menghapus transaksi', 200);
    }
}
