<?php

namespace Modules\Report\Http\Controllers;

use App\Http\Helpers\UtilsHelper;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DataTables;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $dari_tanggal = $request->input('dari_tanggal');
            $sampai_tanggal = $request->input('sampai_tanggal');
            $customer_id = $request->input('customer_id');

            if ($customer_id == '-') {
                $customer_id = null;
            }

            $getCustomer = new Customer();
            $dataCustomer = $getCustomer->getReportCustomer($dari_tanggal, $sampai_tanggal);
            if ($customer_id != null) {
                $dataCustomer = $dataCustomer->where('id', $customer_id);
            }

            return DataTables::eloquent($dataCustomer)
                ->addColumn('total_pembelian', function ($row) {
                    return $row->total_pembelian != null ? UtilsHelper::formatUang($row->total_pembelian) : 0;
                })
                ->addColumn('hutang_pembelian', function ($row) {
                    return $row->hutang_pembelian != null ? UtilsHelper::formatUang($row->hutang_pembelian) : 0;
                })
                ->addColumn('total_servis', function ($row) {
                    return $row->total_servis != null ? UtilsHelper::formatUang($row->total_servis) : 0;
                })
                ->addColumn('hutang_servis', function ($row) {
                    return $row->hutang_servis != null ? UtilsHelper::formatUang($row->hutang_servis) : 0;
                })
                ->toJson();
        }

        $dari_tanggal = date('d/m/Y');
        $sampai_tanggal = date('d/m/Y');
        $data = [
            'dari_tanggal' => $dari_tanggal,
            'sampai_tanggal' => $sampai_tanggal,
        ];
        return view('report::customer.index', $data);
    }
}
