<?php

namespace Modules\TransferStock\Http\Controllers;

use App\Http\Helpers\UtilsHelper;
use App\Models\Barang;
use App\Models\Cabang;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class TransferStockController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        $cabang = Cabang::all();
        $array_cabang = [];
        foreach ($cabang as $key => $item) {
            $array_cabang[] = [
                'id' => $item->id,
                'label' => '<strong>Nama Cabang: ' . $item->nama_cabang . '</strong><br />
                <span>No. Wa: ' . $item->nowa_cabang . '</span>
                '
            ];
        }

        $kodeTStock = UtilsHelper::generateKodeTStock();
        $cabang_id = session()->get('cabang_id');
        $users_id = Auth::id();
        $barang = Barang::dataTable()->get();

        $data = [
            'array_cabang' => $array_cabang,
            'kodeTStock' => $kodeTStock,
            'cabang_id' => $cabang_id,
            'users_id' => $users_id,
            'barang' => $barang,
        ];

        if ($request->ajax()) {
            if ($request->input('refresh')) {
                return response()->json($data);
            }
        }


        return view('transferstock::index', $data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('transferstock::create');
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
        return view('transferstock::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('transferstock::edit');
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
