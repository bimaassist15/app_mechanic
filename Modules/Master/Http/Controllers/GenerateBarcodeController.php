<?php

namespace Modules\Master\Http\Controllers;

use App\Models\Barang;
use App\Models\SerialBarang;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class GenerateBarcodeController extends Controller
{
    public function index(Request $request)
    {
        $barang_id = $request->query('barang_id');
        $barang = Barang::find($request->query('barang_id'));
        $serialBarang = SerialBarang::dataTable()->where('barang_id', $barang_id)->get();
 
        return view('master::generateBarang.index', compact('barang', 'serialBarang'));
    }

    public function print(Request $request)
    {
        $barang_id = $request->query('barang_id');
        $barang = Barang::find($request->query('barang_id'));
        $serialBarang = SerialBarang::dataTable()->where('barang_id', $barang_id)->get();
 
        return view('master::generateBarang.print', compact('barang', 'serialBarang'));
    }
}
