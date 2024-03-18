<?php

namespace Modules\Service\Http\Controllers;

use App\Models\Kategori;
use App\Models\KategoriServis;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DataTables;
use Illuminate\Support\Facades\Config;

class PenerimaanServisController extends Controller
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
            $data = Kategori::dataTable();
            return DataTables::eloquent($data)
                ->addColumn('action', function ($row) {
                    $buttonUpdate = '
                    <a class="btn btn-warning btn-edit btn-sm" 
                    data-typemodal="mediumModal"
                    data-urlcreate="' . route('penerimaanServis.edit', $row->id) . '"
                    data-modalId="mediumModal"
                    >
                        <i class="fa-solid fa-pencil"></i>
                    </a>
                    ';
                    $buttonDelete = '
                    <button type="button" class="btn-delete btn btn-danger btn-sm" data-url="' . url('master/penerimaanServis/' . $row->id) . '?_method=delete">
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
        return view('service::penerimaanServis.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $action = route('penerimaanServis.store');
        $kategoriServis = KategoriServis::dataTable()->get();
        $tipeServis = $this->datastatis['tipe_servis'];
        return view('service::penerimaanServis.form', compact('kategoriServis', 'tipeServis'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
        $data = [
            'nama_penerimaanServis' => $request->input('nama_penerimaanServis'),
            'status_penerimaanServis' => $request->input('status_penerimaanServis') !== null ? true : false,
            'cabang_id' => session()->get('cabang_id'),
        ];
        Kategori::create($data);
        return response()->json('Berhasil tambah data', 201);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('service::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $action = url('master/penerimaanServis/' . $id . '?_method=put');
        $row = Kategori::find($id);
        $kategoriServis = KategoriServis::dataTable()->get();
        $tipeServis = $this->datastatis['tipe_servis'];
        return view('master::penerimaanServis.form', compact('action', 'row', 'kategoriServis', 'tipeServis'));
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
            'nama_penerimaanServis' => $request->input('nama_penerimaanServis'),
            'status_penerimaanServis' => $request->input('status_penerimaanServis') !== null ? true : false,
            'cabang_id' => session()->get('cabang_id'),
        ];
        Kategori::find($id)->update($data);
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
        Kategori::destroy($id);
        return response()->json('Berhasil hapus data', 200);
    }
}
