<?php

namespace Modules\Transaction\Http\Controllers;

use App\Http\Helpers\UtilsHelper;
use App\Models\Pembelian;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DataTables;

class LunasController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $pembelian = new Pembelian();
            $data = $pembelian->invoiceLunas();

            return DataTables::eloquent($data)
                ->addColumn('transaksi_pembelian', function ($row) {
                    $output = UtilsHelper::tanggalBulanTahunKonversi($row->transaksi_pembelian);
                    return $output;
                })
                ->addColumn('total_pembelian', function ($row) {
                    $output = UtilsHelper::formatUang($row->total_pembelian);
                    return $output;
                })
                ->addColumn('supplier', function ($row) {
                    $output = $row->supplier->nama_supplier ?? 'Umum';
                    return $output;
                })
                ->addColumn('action', function ($row) {
                    $buttonDetail = '
                <a class="btn btn-info btn-detail btn-sm" 
                data-typemodal="extraLargeModal"
                data-urlcreate="' . url('transaction/lunas/' . $row->id . '/show') . '"
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
        return view('transaction::lunas.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('transaction::pembelian.form');
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
    public function show($id)
    {
        $Pembelian_id = $id;
        $Pembelian = new Pembelian();
        $row = $Pembelian->invoicePembelian($Pembelian_id);
        $jsonRow = json_encode($row);
        return view('transaction::lunas.detail',  compact('row', 'jsonRow'));
    }

    public function print()
    {
        return view('transaction::pembelian.print');
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
        //
    }
}
