<?php

namespace Modules\Service\Http\Controllers;

use App\Http\Helpers\UtilsHelper;
use App\Models\PenerimaanServis;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class PrintServisController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        $penerimaan_servis_id = $request->input('penerimaan_servis_id');
        $penerimaanServis = new PenerimaanServis();
        $row = $penerimaanServis->transaksiServis($penerimaan_servis_id);
        $myCabang = UtilsHelper::myCabang();
        return view('service::print.index', compact('row', 'myCabang'));
    }

    public function selesaiServis(Request $request)
    {
        $penerimaan_servis_id = $request->input('penerimaan_servis_id');
        $penerimaanServis = new PenerimaanServis();
        $row = $penerimaanServis->transaksiServis($penerimaan_servis_id);
        $myCabang = UtilsHelper::myCabang();
        return view('service::print.selesaiServis', compact('row', 'myCabang'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('service::create');
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
        return view('service::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('service::edit');
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
