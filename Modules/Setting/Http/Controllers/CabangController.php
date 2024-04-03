<?php

namespace Modules\Setting\Http\Controllers;

use App\Models\Cabang;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DataTables;
use Illuminate\Support\Facades\Config;
use Modules\Setting\Http\Requests\CreateCabangRequest;

class CabangController extends Controller
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
            $data = Cabang::query();
            return DataTables::eloquent($data)
                ->addColumn('status_cabang', function ($row) {
                    $output = $row->status_cabang ? '<i class="fa-solid fa-check"></i>' : '<i class="fa-solid fa-circle-xmark"></i>';
                    return '<div class="text-center">
                ' . $output . '
                </div>';
                })
                ->addColumn('action', function ($row) {
                    $buttonUpdate = '
                    <a class="btn btn-warning btn-edit btn-sm" 
                    data-typemodal="extraLargeModal"
                    data-urlcreate="' . url('setting/cabang/' . $row->id . '/edit') . '"
                    data-modalId="extraLargeModal"
                    >
                        <i class="fa-solid fa-pencil"></i>
                    </a>
                    ';
                    $buttonDelete = '
                    <button type="button" class="btn-delete btn btn-danger btn-sm" data-url="' . url('setting/cabang/' . $row->id) . '?_method=delete">
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
                ->rawColumns(['action', 'status_cabang'])
                ->toJson();
        }
        return view('setting::cabang.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $action = url('setting/cabang');
        $array_tipe_print = [];
        $tipe_print = $this->datastatis['tipe_print'];
        foreach ($tipe_print as $value => $item) {
            $array_tipe_print[] = [
                'id' => $value,
                'label' => $item,
            ];
        }
        return view('setting::cabang.form', compact('action', 'array_tipe_print'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(CreateCabangRequest $request)
    {
        //
        $data = [
            'bengkel_cabang' => $request->input('bengkel_cabang'),
            'nama_cabang' => $request->input('nama_cabang'),
            'nowa_cabang' => $request->input('nowa_cabang'),
            'kota_cabang' => $request->input('kota_cabang'),
            'email_cabang' => $request->input('email_cabang'),
            'alamat_cabang' => $request->input('alamat_cabang'),
            'status_cabang' => $request->input('status_cabang') !== null ? true : false,
            'notelpon_cabang' => $request->input('notelpon_cabang'),
            'tipeprint_cabang' => $request->input('tipeprint_cabang'),
            'printservis_cabang' => $request->input('printservis_cabang'),
            'lebarprint_cabang' => $request->input('lebarprint_cabang'),
            'lebarprintservis_cabang' => $request->input('lebarprintservis_cabang'),
            'domain_cabang' => $request->input('domain_cabang'),
            'teksnotamasuk_cabang' => $request->input('teksnotamasuk_cabang'),
            'teksnotaambil_cabang' => $request->input('teksnotaambil_cabang'),

        ];
        Cabang::create($data);
        return response()->json('Berhasil tambah data', 201);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('setting::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $action = url('setting/cabang/' . $id . '?_method=put');
        $row = Cabang::find($id);
        $array_tipe_print = [];
        $tipe_print = $this->datastatis['tipe_print'];
        foreach ($tipe_print as $value => $item) {
            $array_tipe_print[] = [
                'id' => $value,
                'label' => $item,
            ];
        }
        return view('setting::cabang.form', compact('action', 'row', 'array_tipe_print'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(CreateCabangRequest $request, $id)
    {
        //
        $data = [
            'bengkel_cabang' => $request->input('bengkel_cabang'),
            'nama_cabang' => $request->input('nama_cabang'),
            'nowa_cabang' => $request->input('nowa_cabang'),
            'kota_cabang' => $request->input('kota_cabang'),
            'email_cabang' => $request->input('email_cabang'),
            'alamat_cabang' => $request->input('alamat_cabang'),
            'status_cabang' => $request->input('status_cabang') !== null ? true : false,
            'notelpon_cabang' => $request->input('notelpon_cabang'),
            'tipeprint_cabang' => $request->input('tipeprint_cabang'),
            'printservis_cabang' => $request->input('printservis_cabang'),
            'lebarprint_cabang' => $request->input('lebarprint_cabang'),
            'lebarprintservis_cabang' => $request->input('lebarprintservis_cabang'),
            'domain_cabang' => $request->input('domain_cabang'),
            'teksnotamasuk_cabang' => $request->input('teksnotamasuk_cabang'),
            'teksnotaambil_cabang' => $request->input('teksnotaambil_cabang'),

        ];
        Cabang::find($id)->update($data);
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
        Cabang::destroy($id);
        return response()->json('Berhasil hapus data', 200);
    }
}
