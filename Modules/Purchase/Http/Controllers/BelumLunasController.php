<?php

namespace Modules\Purchase\Http\Controllers;

use App\Http\Helpers\UtilsHelper;
use App\Models\Penjualan;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DataTables;


class BelumLunasController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Penjualan::dataTable()->with('customer', 'users', 'users.profile')
                ->where('tipe_penjualan', 'hutang');
            return DataTables::eloquent($data)
                ->addColumn('transaksi_penjualan', function ($row) {
                    $output = UtilsHelper::tanggalBulanTahunKonversi($row->transaksi_penjualan);
                    return $output;
                })
                ->addColumn('total_penjualan', function ($row) {
                    $output = UtilsHelper::formatUang($row->total_penjualan);
                    return $output;
                })
                ->addColumn('customer', function ($row) {
                    $output = $row->customer->nama_customer ?? 'Umum';
                    return $output;
                })
                ->addColumn('action', function ($row) {
                    $buttonDetail = '
                    <a class="btn btn-info btn-detail btn-sm" 
                    data-typemodal="extraLargeModal"
                    data-urlcreate="' . url('purchase/belumLunas/' . $row->id . '/show') . '"
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
        return view('purchase::belumLunas.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('purchase::belumLunas.form');
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
        $penjualan = new Penjualan();
        $row = $penjualan->invoicePenjualan($id);
        return view('purchase::belumLunas.detail', compact('row'));
    }

    public function print()
    {
        return view('purchase::belumLunas.print');
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
        //
    }
}
