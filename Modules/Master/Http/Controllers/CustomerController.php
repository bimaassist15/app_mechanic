<?php

namespace Modules\Master\Http\Controllers;

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
        if($request->ajax()){
            $data = Customer::dataTable();
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
                '.$output.'
                </div>';
            })
                ->addColumn('action', function ($row) {
                    $buttonUpdate = '
                    <a class="btn btn-warning btn-edit btn-sm" 
                    data-typemodal="extraLargeModal"
                    data-urlcreate="' . route('customer.edit', $row->id) . '"
                    data-modalId="extraLargeModal"
                    >
                        <i class="fa-solid fa-pencil"></i>
                    </a>
                    ';
                    $buttonDelete = '
                    <button type="button" class="btn-delete btn btn-danger btn-sm" data-url="'.url('master/customer/'.$row->id).'?_method=delete">
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
        $action = route('customer.store');
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
    public function show($id)
    {
        return view('master::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $action = url('master/customer/'.$id.'?_method=put');
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
