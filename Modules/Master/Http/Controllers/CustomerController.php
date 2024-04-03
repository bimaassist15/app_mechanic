<?php

namespace Modules\Master\Http\Controllers;

use App\Http\Helpers\UtilsHelper;
use App\Models\Customer;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Master\Http\Requests\FormCustomerRequest;
use DataTables;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Customer::dataTable()
                ->with('kendaraan', 'penjualan', 'penerimaanServis')
                ->withCount(['penjualan', 'penerimaanServis']);

            return DataTables::eloquent($data)
                ->addColumn('pembelian_customer', function ($row) {
                    $output = '';
                })
                ->addColumn('servis_customer', function ($row) {
                    $output = '';
                })
                ->addColumn('status_customer', function ($row) {
                    $output = $row->status_customer ? '<i class="fa-solid fa-check"></i>' : '<i class="fa-solid fa-circle-xmark"></i>';
                    return '<div class="text-center">
                ' . $output . '
                </div>';
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
                            <a data-typemodal="extraLargeModal" href="' . url('master/customer/'.$row->id) . '"
                                class="dropdown-item d-flex align-items-center btn-detail">
                                <i class="fa-solid fa-eye"></i> &nbsp; Detail Customer
                            </a>
                        </li>
                        <li>
                            <a data-typemodal="extraLargeModal" href="' . url('master/customer/'.$row->id.'/edit') . '"
                                class="dropdown-item d-flex align-items-center btn-edit">
                                <i class="fa-solid fa-pencil"></i> &nbsp; Edit Data</a>
                        </li>
                        <li>
                            <a data-typemodal="extraLargeModal" href="' . url('master/customer/' . $row->id . '?_method=delete') . '"
                                class="dropdown-item d-flex align-items-center btn-delete">
                                <i class="fa-solid fa-trash"></i> &nbsp; Delete Data</a>
                        </li>
                    </ul>';

                    $button = '
                <div class="text-center">
                    ' . $buttonAksi . '
                </div>
                ';
                    return $button;
                })
                ->rawColumns(['action', 'status_customer'])
                ->toJson();
        }
        return view('master::customer.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $action = url('master/customer');
        return view('master::customer.form', compact('action'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(FormCustomerRequest $request)
    {
        //
        $data = [
            'nama_customer' => $request->input('nama_customer'),
            'nowa_customer' => $request->input('nowa_customer'),
            'email_customer' => $request->input('email_customer'),
            'alamat_customer' => $request->input('alamat_customer'),
            'status_customer' => $request->input('status_customer') !== null ? true : false,
            'cabang_id' => session()->get('cabang_id'),
        ];
        Customer::create($data);
        return response()->json('Berhasil tambah data', 201);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(Request $request, $id)
    {
        $getCustomer = new Customer();
        $row = $getCustomer->dataCustomer()->where('id', $id)->first();
        $dataPayment = [];
        foreach ($row->penjualan as $key => $value) {
            $dataPayment[] = UtilsHelper::paymentStatisPenjualan($value->id);
        }
        $dataPayment = json_encode($dataPayment);
        $pengembalian_servis = $request->input('pengembalian_servis') != null ? $request->input('pengembalian_servis') : false;
        return view('master::customer.detail', compact('row', 'dataPayment', 'pengembalian_servis'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $action = url('master/customer/' . $id . '?_method=put');
        $row = Customer::find($id);
        return view('master::customer.form', compact('action', 'row'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(FormCustomerRequest $request, $id)
    {
        //
        $data = [
            'nama_customer' => $request->input('nama_customer'),
            'nowa_customer' => $request->input('nowa_customer'),
            'email_customer' => $request->input('email_customer'),
            'alamat_customer' => $request->input('alamat_customer'),
            'status_customer' => $request->input('status_customer') !== null ? true : false,
            'cabang_id' => session()->get('cabang_id'),
        ];
        Customer::find($id)->update($data);
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
        Customer::destroy($id);
        return response()->json('Berhasil hapus data', 200);
    }
}
