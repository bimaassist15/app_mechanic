<?php

namespace App\Http\Controllers;

use App\Http\Requests\FormChangeCabangRequest;
use App\Models\Barang;
use App\Models\Cabang;
use App\Models\TransferDetail;
use App\Models\TransferStock;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ChangeCabangController extends Controller
{
    public function index(Request $request)
    {
        $cabang = Cabang::where('id', '<>', session()->get('cabang_id'))->get();
        $array_cabang = [];
        foreach ($cabang as $key => $item) {
            $array_cabang[] = [
                'id' => $item->id,
                'label' => '<strong>Nama Cabang: ' . $item->nama_cabang . '</strong> <br />
                <span>Alamat: ' . $item->nowa_cabang . '</span> <br />'
            ];
        }
        $action = url('changeCabang?_method=put');
        return view('changeCabang.index', compact('array_cabang', 'action'));
    }

    public function update(FormChangeCabangRequest $request)
    {
        session()->put('cabang_id', $request->input('cabang_id'));
        return response()->json('Berhasil ganti cabang');
    }
}
