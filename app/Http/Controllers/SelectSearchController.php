<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Customer;
use App\Models\HargaServis;
use App\Models\KategoriPembayaran;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;


class SelectSearchController extends Controller
{
    public function kasir(Request $request)
    {
        $search = $request->input('search');
        $page = $request->input('page');
        $getUsers = new User();
        $dataUsers = $getUsers->getUsersKasir()
            ->whereHas('roles', function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->orWhere('name', 'like', '%' . $search . '%')
            ->paginate(10, ['*'], 'page', $page);

        $output = [];
        $output[] = [
            'id' => '-',
            'text' => 'Pilih Semua',
        ];
        foreach ($dataUsers as $key => $item) {
            $output[] = [
                'id' => $item->id,
                'text' => '<strong>Nama: ' . $item->name . '</strong><br />
                <span>Role: ' . $item->roles[0]->name . '</span>',
            ];
        }

        // count filtered
        $countFiltered = $getUsers->getUsersKasir()
            ->whereHas('roles', function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->orWhere('name', 'like', '%' . $search . '%')
            ->count();

        return response()->json([
            'results' => $output,
            'count_filtered' => $countFiltered,
        ]);
    }

    public function customer(Request $request)
    {
        $search = $request->input('search');
        $page = $request->input('page');
        $getCustomer = Customer::dataTable()
            ->where('status_customer', true)
            ->where('nama_customer', 'like', '%' . $search . '%')
            ->orWhere('nowa_customer', 'like', '%' . $search . '%')
            ->paginate(10, ['*'], 'page', $page);

        $output = [];
        $output[] = [
            'id' => '-',
            'text' => 'Pilih Semua',
        ];
        foreach ($getCustomer as $key => $item) {
            $output[] = [
                'id' => $item->id,
                'text' => '<strong>Nama: ' . $item->nama_customer . '</strong><br />
                <span>No. Whatsapp: ' . $item->nowa_customer . '</span>',
            ];
        }

        // count filtered
        $countFiltered = Customer::dataTable()
            ->where('status_customer', true)
            ->where('nama_customer', 'like', '%' . $search . '%')
            ->orWhere('nowa_customer', 'like', '%' . $search . '%')
            ->count();

        return response()->json([
            'results' => $output,
            'count_filtered' => $countFiltered,
        ]);
    }

    public function barang(Request $request)
    {
        $search = $request->input('search');
        $page = $request->input('page');
        $status_barang = explode(',', $request->input('status_barang'));
        $new_status_barang = [];
        foreach ($status_barang as $key => $item) {
            $new_status_barang[] = trim($item);
        }


        $getBarang = Barang::dataTable()
            ->whereIn('status_barang', $new_status_barang)
            ->where(function ($query) use ($search) {
                $query->where('barcode_barang', 'like', '%' . $search . '%')
                    ->orWhere('nama_barang', 'like', '%' . $search . '%');
            })
            ->paginate(10, ['*'], 'page', $page);

        $output = [];
        foreach ($getBarang as $key => $item) {
            $output[] = [
                'id' => $item->id,
                'text' => '<strong>[' . $item->barcode_barang . '] ' . $item->nama_barang . '</strong><br />
                <span>Stok Barang: ' . $item->stok_barang . '</span>',
            ];
        }

        // count filtered
        $countFiltered = Barang::dataTable()
            ->whereIn('status_barang', $new_status_barang)
            ->where(function ($query) use ($search) {
                $query->where('barcode_barang', 'like', '%' . $search . '%')
                    ->orWhere('nama_barang', 'like', '%' . $search . '%');
            })
            ->count();

        return response()->json([
            'results' => $output,
            'count_filtered' => $countFiltered,
        ]);
    }

    public function kategoriPembayaran(Request $request)
    {
        $search = $request->input('search');
        $page = $request->input('page');

        $getKategoriPembayaran = KategoriPembayaran::dataTable()
            ->where('status_kpembayaran', true)
            ->where('nama_kpembayaran', 'like', '%' . $search . '%')
            ->paginate(10, ['*'], 'page', $page);

        $output = [];
        foreach ($getKategoriPembayaran as $key => $item) {
            $output[] = [
                'id' => $item->id,
                'text' => $item->nama_kpembayaran,
            ];
        }

        // count filtered
        $countFiltered = kategoriPembayaran::dataTable()
            ->where('status_kpembayaran', true)
            ->where('nama_kpembayaran', 'like', '%' . $search . '%')
            ->count();

        return response()->json([
            'results' => $output,
            'count_filtered' => $countFiltered,
        ]);
    }

    public function supplier(Request $request)
    {
        $search = $request->input('search');
        $page = $request->input('page');

        $getSupplier = Supplier::dataTable()
            ->where('status_supplier', true)
            ->where('nama_supplier', 'like', '%' . $search . '%')
            ->orWhere('nowa_supplier', 'like', '%' . $search . '%')
            ->paginate(10, ['*'], 'page', $page);

        $output = [];
        foreach ($getSupplier as $key => $item) {
            $output[] = [
                'id' => $item->id,
                'text' => '
                    <strong>Nama Supplier: ' . $item->nama_supplier . '</strong><br />
                    <span>No. Whats\'app: ' . $item->nowa_supplier . '</span>
                ',
            ];
        }

        // count filtered
        $countFiltered = Supplier::dataTable()
            ->where('status_supplier', true)
            ->where('nama_supplier', 'like', '%' . $search . '%')
            ->orWhere('nowa_supplier', 'like', '%' . $search . '%')
            ->count();

        return response()->json([
            'results' => $output,
            'count_filtered' => $countFiltered,
        ]);
    }

    public function hargaServis(Request $request)
    {
        $search = $request->input('search');
        $page = $request->input('page');

        $getHargaServis = HargaServis::dataTable()
            ->where('status_hargaservis', true)
            ->where('nama_hargaservis', 'like', '%' . $search . '%')
            ->paginate(10, ['*'], 'page', $page);

        $output = [];
        foreach ($getHargaServis as $key => $item) {
            $output[] = [
                'id' => $item->id,
                'text' => '
                    <strong>Nama Servis: ' . $item->nama_hargaservis . '</strong><br />
                    <span>Harga Servis: ' . $item->total_hargaservis . '</span>
                ',
            ];
        }

        // count filtered
        $countFiltered = HargaServis::dataTable()
            ->where('status_hargaservis', true)
            ->where('nama_hargaservis', 'like', '%' . $search . '%')
            ->count();

        return response()->json([
            'results' => $output,
            'count_filtered' => $countFiltered,
        ]);
    }
}
