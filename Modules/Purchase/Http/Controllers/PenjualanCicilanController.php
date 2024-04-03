<?php

namespace Modules\Purchase\Http\Controllers;

use App\Http\Helpers\UtilsHelper;
use App\Models\Barang;
use App\Models\Customer;
use App\Models\KategoriPembayaran;
use App\Models\Penjualan;
use App\Models\PenjualanCicilan;
use App\Models\SubPembayaran;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class PenjualanCicilanController extends Controller
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
            $penjualanCiciclan = new PenjualanCicilan();
            $penjualan_id = $request->query('penjualan_id');
            $data = $penjualanCiciclan->dataTable($penjualan_id);

            return DataTables::eloquent($data)
                ->addColumn('bayar_pcicilan', function ($row) {
                    $output = UtilsHelper::formatUang($row->bayar_pcicilan);
                    return $output;
                })
                ->addColumn('hutang_pcicilan', function ($row) {
                    $output = UtilsHelper::formatUang($row->hutang_pcicilan);
                    return $output;
                })
                ->addColumn('kembalian_pcicilan', function ($row) {
                    $output = UtilsHelper::formatUang($row->kembalian_pcicilan);
                    return $output;
                })
                ->addColumn('action', function ($row) {
                    $buttonDetail = '
                    <a class="btn btn-info btn-detail btn-sm" 
                    data-typemodal="extraLargeModal"
                    data-urlcreate="' . url('purchase/penjualanCicilan/' . $row->id) . '"
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
        $penjualan_id = $request->query('penjualan_id');
        $penjualan = Penjualan::find($penjualan_id);

        return view('purchase::penjualanCicilan.index', compact('penjualan'));
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
        $penjualanId = $request->query('penjualan_id');
        $isEdit = $request->query('isEdit');
        $penjualan = new Penjualan();
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

        $penjualan = new Penjualan();
        $penjualan = $penjualan->invoicePenjualan($penjualanId);
        $dataHutang = $penjualan->penjualanCicilan;
        $totalHutang = 0;
        $totalBayar = 0;
        $totalKembalian = 0;
        $totalHutang = 0;
        if (count($dataHutang) > 0) {
            foreach ($dataHutang as $key => $item) {
                $totalBayar += $item->bayar_pcicilan;
                $totalKembalian += $item->kembalian_pcicilan;
            }
            $totalHutang = $totalKembalian > 0 ?  $totalBayar - $totalKembalian : $dataHutang[0]->bayar_pcicilan + $dataHutang[0]->hutang_pcicilan;
        }

        $totalHutang = $isEdit == true ? $totalHutang : $penjualan->hutang_penjualan;
        $data = [
            'array_kategori_pembayaran' => $array_kategori_pembayaran,
            'kategoriPembayaran' => $kategoriPembayaran,
            'subPembayaran' => $subPembayaran,
            'array_sub_pembayaran' => $array_sub_pembayaran,
            'dataUser' => $dataUser,
            'defaultUser' => $defaultUser,
            'cabangId' => $cabangId,
            'penjualan_id' => $penjualanId,
            'isEdit' => $isEdit,
            'penjualan' => $penjualan,
            'totalHutang' => $totalHutang,
            'getPenjualan' => UtilsHelper::paymentStatisPenjualan($penjualanId),
        ];
        if ($request->input('refresh_dataset')) {
            return response()->json($data);
        }

        return view('purchase::penjualanCicilan.form', $data);
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
            $penjualan_id = $payloadIsEdit['penjualan_id'];
            $penjualanCicilan = PenjualanCicilan::where('penjualan_id', $penjualan_id)
                ->orderBy('id', 'desc')->get();
            foreach ($penjualanCicilan as $key => $item) {
                $id = $item->id;
                $getData = PenjualanCicilan::find($id);
                $penjualan_id = $getData->penjualan_id;

                $dataBayar = $getData->bayar_pcicilan;
                $dataKembalian = $getData->kembalian_pcicilan;

                $penjualan = Penjualan::find($penjualan_id);
                $totalPenjualan = $penjualan->total_penjualan;

                $getBayar = floatval($penjualan->bayar_penjualan) - floatval($dataBayar);
                $getHutang = floatval($totalPenjualan) - floatval($getBayar);
                $getKembalian = floatval($penjualan->kembalian_penjualan) - floatval($dataKembalian);

                $penjualan->bayar_penjualan = $getBayar;
                $penjualan->hutang_penjualan = $getHutang < 0 ? 0 : $getHutang;
                $penjualan->kembalian_penjualan = $getKembalian;
                $penjualan->save();

                PenjualanCicilan::destroy($id);
            }
        }

        // penjualan
        $penjualan = $request->input('penjualan');
        $getPenjualan = Penjualan::find($penjualan['penjualan_id']);
        $getPenjualan->hutang_penjualan = floatval($penjualan['hutang_penjualan']);
        $getPenjualan->kembalian_penjualan = floatval($penjualan['kembalian_penjualan']);
        $getPenjualan->tipe_penjualan = $penjualan['tipe_penjualan'];
        $getPenjualan->bayar_penjualan = floatval($getPenjualan->bayar_penjualan) + floatval($penjualan['bayar_penjualan']);
        $getPenjualan->tipe_penjualan = $penjualan['tipe_penjualan'];
        $getPenjualan->updated_at = date('Y-m-d H:i:s');
        $getPenjualan->save();

        // penjualan cicilan
        $penjualanCicilan = $request->input('penjualan_cicilan');
        PenjualanCicilan::insert($penjualanCicilan);

        $message = 'Berhasil tambah data';
        if ($payloadIsEdit['isEdit'] == true) {
            $message = 'Berhasil edit transaksi';
        }

        return response()->json([
            'message' => $message,
            'result' => $getPenjualan->id,
        ], 201);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $penjualanCicilan = PenjualanCicilan::find($id);
        $penjualan_id = $penjualanCicilan->penjualan_id;
        $penjualan = new Penjualan();
        $row = $penjualan->invoicePenjualan($penjualan_id);
        $jsonRow = json_encode($row);
        return view('purchase::penjualanCicilan.detail', compact('row', 'jsonRow', 'penjualanCicilan'));
    }

    public function print()
    {
        $penjualan = new Penjualan();
        $penjualan_id = request()->query('penjualan_id');
        $penjualan = $penjualan->invoicePenjualan($penjualan_id);
        $myCabang = UtilsHelper::myCabang();
        return view('purchase::penjualanCicilan.print', compact('penjualan', 'myCabang'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('purchase::edit');
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
        $getData = PenjualanCicilan::find($id);
        $penjualan_id = $getData->penjualan_id;

        $dataBayar = $getData->bayar_pcicilan;
        $dataKembalian = $getData->kembalian_pcicilan;

        $penjualan = Penjualan::find($penjualan_id);
        $totalPenjualan = $penjualan->total_penjualan;

        $getBayar = floatval($penjualan->bayar_penjualan) - floatval($dataBayar);
        $getHutang = floatval($totalPenjualan) - floatval($getBayar);
        $getKembalian = floatval($penjualan->kembalian_penjualan) - floatval($dataKembalian);

        $penjualan->bayar_penjualan = $getBayar;
        $penjualan->hutang_penjualan = $getHutang < 0 ? 0 : $getHutang;
        $penjualan->kembalian_penjualan = $getKembalian;
        $penjualan->save();

        PenjualanCicilan::destroy($id);
        return response()->json('Berhasil menghapus transaksi', 200);
    }
}
