<?php

namespace Modules\Master\Http\Controllers;

use App\Models\Customer;
use App\Models\Kendaraan;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Master\Http\Requests\FormKendaraanRequest;
use DataTables;

class KendaraanController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Kendaraan::dataTable()->with('customer');
            return DataTables::eloquent($data)
                ->addColumn('action', function ($row) {
                    $buttonUpdate = '
                    <a class="btn btn-warning btn-edit btn-sm" 
                    data-typemodal="extraLargeModal"
                    data-urlcreate="' . url(' master/kendaraan/' . $row->id . '/edit') . '"
                    data-modalId="extraLargeModal"
                    >
                        <i class="fa-solid fa-pencil"></i>
                    </a>
                    ';
                    $buttonDelete = '
                    <button type="button" class="btn-delete btn btn-danger btn-sm" data-url="' . url('master/kendaraan/' . $row->id) . '?_method=delete">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                    ';

                    $button = '
                <div class="text-center">
                    ' . $buttonUpdate . '
                    ' . $buttonDelete . '
                </div>
                ';
                    return $button;
                })
                ->rawColumns(['action'])
                ->toJson();
        }
        return view('master::kendaraan.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $action = url('master/kendaraan');
        $customer = Customer::dataTable()->get();
        $array_customer = [];
        foreach ($customer as $key => $value) {
            $array_customer[] = [
                'id' => $value->id,
                'label' => $value->nama_customer . ' ' . '(' . $value->nowa_customer . ')'
            ];
        }
        return view('master::kendaraan.form', compact('action', 'array_customer'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(FormKendaraanRequest $request)
    {
        //
        $data = [
            'customer_id' => $request->input('customer_id'),
            'nopol_kendaraan' => $request->input('nopol_kendaraan'),
            'merek_kendaraan' => $request->input('merek_kendaraan'),
            'tipe_kendaraan' => $request->input('tipe_kendaraan'),
            'jenis_kendaraan' => $request->input('jenis_kendaraan'),
            'tahunbuat_kendaraan' => $request->input('tahunbuat_kendaraan'),
            'tahunrakit_kendaraan' => $request->input('tahunrakit_kendaraan'),
            'silinder_kendaraan' => $request->input('silinder_kendaraan'),
            'warna_kendaraan' => $request->input('warna_kendaraan'),
            'norangka_kendaraan' => $request->input('norangka_kendaraan'),
            'nomesin_kendaraan' => $request->input('nomesin_kendaraan'),
            'keterangan_kendaraan' => $request->input('keterangan_kendaraan'),
            'cabang_id' => session()->get('cabang_id'),
        ];
        Kendaraan::create($data);
        return response()->json('Berhasil tambah data', 201);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $action = url('master/kendaraan/' . $id . '?_method=put');
        $row = Kendaraan::with('customer')->find($id);
        $customer = Customer::dataTable()->get();
        $array_customer = [];
        foreach ($customer as $key => $value) {
            $array_customer[] = [
                'id' => $value->id,
                'label' => $value->nama_customer . ' ' . '(' . $value->nowa_customer . ')'
            ];
        }
        return view('master::kendaraan.detail', compact('action', 'row', 'array_customer'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $action = url('master/kendaraan/' . $id . '?_method=put');
        $row = Kendaraan::find($id);
        $customer = Customer::dataTable()->get();
        $array_customer = [];
        foreach ($customer as $key => $value) {
            $array_customer[] = [
                'id' => $value->id,
                'label' => $value->nama_customer . ' ' . '(' . $value->nowa_customer . ')'
            ];
        }
        return view('master::kendaraan.form', compact('action', 'row', 'array_customer'));
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
        $data = [
            'customer_id' => $request->input('customer_id'),
            'nopol_kendaraan' => $request->input('nopol_kendaraan'),
            'merek_kendaraan' => $request->input('merek_kendaraan'),
            'tipe_kendaraan' => $request->input('tipe_kendaraan'),
            'jenis_kendaraan' => $request->input('jenis_kendaraan'),
            'tahunbuat_kendaraan' => $request->input('tahunbuat_kendaraan'),
            'tahunrakit_kendaraan' => $request->input('tahunrakit_kendaraan'),
            'silinder_kendaraan' => $request->input('silinder_kendaraan'),
            'warna_kendaraan' => $request->input('warna_kendaraan'),
            'norangka_kendaraan' => $request->input('norangka_kendaraan'),
            'nomesin_kendaraan' => $request->input('nomesin_kendaraan'),
            'keterangan_kendaraan' => $request->input('keterangan_kendaraan'),
            'cabang_id' => session()->get('cabang_id'),
        ];
        Kendaraan::find($id)->update($data);
        return response()->json('Berhasil update data', 200);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
        Kendaraan::destroy($id);
        return response()->json('Berhasil hapus data', 200);
    }
}
