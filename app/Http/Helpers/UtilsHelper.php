<?php

namespace App\Http\Helpers;

use App\Models\Barang;
use App\Models\Cabang;
use App\Models\HargaServis;
use App\Models\KategoriPembayaran;
use App\Models\Pembelian;
use App\Models\PenerimaanServis;
use App\Models\Penjualan;
use App\Models\SubPembayaran;
use App\Models\TransferStock;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\DB;
use File;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;

class UtilsHelper
{
    public static function myProfile($users_id = null)
    {
        if ($users_id == null) {
            $users_id = Auth::id();
        }
        $getUser = User::with('profile')->find($users_id);
        return $getUser;
    }

    public static function uploadFile($file, $lokasi, $id = null, $table = null, $nameAttribute = null)
    {
        if ($file != null) {
            // delete file
            UtilsHelper::deleteFile($id, $table, $lokasi, $nameAttribute);

            // nama file
            $fileExp =  explode('.', $file->getClientOriginalName());
            $name = $fileExp[0];
            $ext = $fileExp[1];
            $name = time() . '-' . str_replace(' ', '-', $name) . '.' . $ext;

            // isi dengan nama folder tempat kemana file diupload
            $tujuan_upload =  public_path() . '/upload/' . $lokasi . '/';

            // upload file
            $file->move($tujuan_upload, $name);
        } else {
            if ($id == null) {
                $name = 'default.png';
            } else {
                $data = DB::table($table)->where('id', $id)->first();
                $setData = (array) $data;
                $name = $setData[$nameAttribute];
            }
        }

        return $name;
    }

    public static function deleteFile($id = null, $table = null, $lokasi = null, $name = null)
    {
        if ($id != null) {
            $data = DB::table($table)->where('id', '=', $id)->first();
            $setData = (array) $data;
            $gambar = public_path() . '/upload/' . $lokasi . '/' . $setData[$name];
            if (file_exists($gambar)) {
                if ($setData[$name] != 'default.png') {
                    File::delete($gambar);
                }
            }
        }
    }

    public static function handleSidebar($treeData)
    {
        $pushData = [];
        function hiddenTree($data, $parentId = null)
        {
            $pushData = [];
            foreach ($data as $index => $item) {
                if ($item['children'] !== null && ($parentId === null || in_array($item['id'], $parentId))) {
                    $childIds = $item['children'];
                    $pushData[] = $childIds;
                    hiddenTree($data, $childIds);
                }
            }
            return $pushData;
        }
        $pushData = hiddenTree($treeData, null);
        $flattenedArray = [];
        foreach ($pushData as $subArray) {
            $flattenedArray = array_merge($flattenedArray, $subArray);
        }
        $hiddenData = [];
        foreach ($flattenedArray as $key => $value) {
            $hiddenData[$value] = $value;
        }

        return $hiddenData;
    }

    public static function tanggalBulanTahunKonversi($tanggal)
    {
        $tanggalWaktu = Carbon::createFromFormat('Y-m-d H:i:s', $tanggal);
        $tanggalIndonesia = $tanggalWaktu->isoFormat('D MMMM Y HH:mm', 'Do MMMM Y HH:mm');
        return $tanggalIndonesia;
    }

    public static function limitTextGlobal($text, $limit = 100)
    {
        if (strlen($text) > $limit) {
            $text = substr($text, 0, $limit);
            $text .= '...';
        }
        return $text;
    }

    public static function myCabang()
    {
        $cabang_id = session()->get('cabang_id');
        return Cabang::find($cabang_id);
    }


    public static function insertPermissions()
    {
        $countPermissions = Permission::all()->count();
        if ($countPermissions > 0) {
            DB::table('permissions')->delete();
        }

        $routes = \Route::getRoutes();
        $routesName = [];
        foreach ($routes as $route) {
            if (!str_contains($route->getName(), 'unisharp')) {
                if (!str_contains($route->getName(), 'sanctum')) {
                    if (!str_contains($route->getName(), 'ignition')) {
                        if ($route->getName() != null) {
                            $routesName[] = [
                                'name' => $route->getName(),
                                'guard_name' => 'web'
                            ];
                        }
                    }
                }
            }
        }
        Permission::insert($routesName);
    }

    public static function getUrlPermission()
    {
        $routes = \Route::getRoutes();
        $routeUri = [];
        foreach ($routes as $route) {
            if (!str_contains($route->getName(), 'unisharp')) {
                if (!str_contains($route->getName(), 'sanctum')) {
                    if (!str_contains($route->getName(), 'ignition')) {
                        if ($route->getName() != null) {
                            $routeUri[$route->uri()] = $route->getName();
                        }
                    }
                }
            }
        }
        return $routeUri;
    }

    public static function formatDate($tanggal_transaction)
    {
        $dateNow = $tanggal_transaction;
        $tanggal = Carbon::parse($dateNow);
        $formattedDate = $tanggal->format('j F Y');
        return $formattedDate;
    }
    public static function formatDateV2($tanggal_transaction)
    {
        $date = DateTime::createFromFormat('d/m/Y', $tanggal_transaction);
        $tanggal = $date->format('Y-m-d');
        return UtilsHelper::formatDate($tanggal);
    }

    public static function formatDateLaporan($tanggal_transaction)
    {
        $dateNow = $tanggal_transaction;
        $tanggal = Carbon::parse($dateNow);
        $formattedDate = $tanggal->format('d/m/Y');
        return $formattedDate;
    }

    public static function formatHumansDate($tanggal_transaction)
    {
        $dateNow = $tanggal_transaction;
        $tanggal = Carbon::createFromFormat('Y-m-d', $dateNow);
        $formattedDate = $tanggal->diffForHumans();
        return $formattedDate;
    }

    public static function integerMonth($month)
    {
        switch ($month) {
            case 1:
                return 'Januari';
                break;
            case 2:
                return 'Februari';
                break;
            case 3:
                return 'Maret';
                break;
            case 4:
                return 'April';
                break;
            case 5:
                return 'Mei';
                break;
            case 6:
                return 'Juni';
                break;
            case 7:
                return 'Juli';
                break;
            case 8:
                return 'Agustus';
                break;
            case 9:
                return 'September';
                break;
            case 10:
                return 'Oktober';
                break;
            case 11:
                return 'November';
                break;
            case 12:
                return 'Desember';
                break;
            default:
                return 'Januari';
                break;
        }
    }

    public static function monthData()
    {
        return ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    }

    public static function stringMonth($month)
    {
        switch ($month) {
            case 'Januari':
                return 1;
                break;
            case 'Februari':
                return 2;
                break;
            case 'Maret':
                return 3;
                break;
            case 'April':
                return 4;
                break;
            case 'Mei':
                return 5;
                break;
            case 'Juni':
                return 6;
                break;
            case 'Juli':
                return 7;
                break;
            case 'Agustus':
                return 8;
                break;
            case 'September':
                return 9;
                break;
            case 'Oktober':
                return 10;
                break;
            case 'November':
                return 11;
                break;
            case 'Desember':
                return 12;
                break;
            default:
                return 1;
                break;
        }
    }
    public static function formatUang($nominal)
    {
        return number_format($nominal, 0, '.', ',');
    }

    public static function paymentStatisPenerimaanServis($id)
    {
        $penerimaanServis = new PenerimaanServis();
        $getPenerimaanServis = $penerimaanServis->transaksiServis($id);

        $hutang = 0;
        $kembalian = 0;
        $bayar = 0;
        $tipeTransaksi = '';
        $statusTransaksi = false;
        $cicilan = 0;


        if (count($getPenerimaanServis->pembayaranServis) > 0) {
            $getPembayaranServis = $getPenerimaanServis->pembayaranServis;
            $getPembayaranServis = $getPembayaranServis[0];

            $getBayarCicilan = $getPenerimaanServis->pembayaranServis->pluck('bayar_pservis')->toArray();
            $totalBayar = array_sum($getBayarCicilan);

            $hutang = $getPembayaranServis->deposit_pservis + $getPembayaranServis->hutang_pservis;
            $kembalian = $getPenerimaanServis->kembalian_pservis;
            $bayar = $totalBayar;
            if ($getPembayaranServis->kembalian_pservis > 0) {
                $bayar = $totalBayar - $getPembayaranServis->kembalian_pservis;
            }
            $tipeTransaksi = 'hutang';

            // check again
            if ($getPenerimaanServis->totalbiaya_pservis > 0) {
                $hutang = $getPenerimaanServis->totalbiaya_pservis;
            }
        } else {
            $hutang = $getPenerimaanServis->hutang_pservis;
            $kembalian = $getPenerimaanServis->kembalian_pservis;
            $bayar = $getPenerimaanServis->total_dppservis;
            $tipeTransaksi = $getPenerimaanServis->tipe_pservis;
        }

        $calc = $bayar - $hutang;
        if ($calc < 0) {
            $statusTransaksi = false;
            $cicilan = abs($calc);
        } else {
            $statusTransaksi = true;
            $cicilan = 0;
        }

        return [
            'hutang' => $hutang,
            'kembalian' => $kembalian,
            'bayar' => $bayar,
            'tipe_transaksi' => $tipeTransaksi,
            'status_transaksi' => $statusTransaksi,
            'cicilan' => $cicilan,
            'id' => $id,
        ];
    }

    public static function paymentStatisPenjualan($id)
    {
        $penjualan = new Penjualan();
        $getPenjualan = $penjualan->invoicePenjualan($id);

        $hutang = 0;
        $kembalian = 0;
        $bayar = 0;
        $tipeTransaksi = '';
        $statusTransaksi = false;
        $cicilan = 0;

        if (count($getPenjualan->penjualanCicilan) > 0) {
            $getPenjualanCicilan = $getPenjualan->penjualanCicilan;
            $getPenjualanCicilan = $getPenjualanCicilan[0];

            $getBayarCicilan = $getPenjualan->penjualanCicilan->pluck('bayar_pcicilan')->toArray();
            $totalBayar = array_sum($getBayarCicilan);

            $hutang = $getPenjualanCicilan->bayar_pcicilan + $getPenjualanCicilan->hutang_pcicilan;
            $kembalian = $getPenjualan->kembalian_penjualan;
            $bayar = $totalBayar;
            $tipeTransaksi = 'hutang';
        } else {
            $hutang = $getPenjualan->hutang_penjualan;
            $kembalian = $getPenjualan->kembalian_penjualan;
            $bayar = $getPenjualan->bayar_penjualan;
            $tipeTransaksi = $getPenjualan->tipe_penjualan;
        }

        $calc = $bayar - $hutang;
        if ($calc < 0) {
            $statusTransaksi = false;
            $cicilan = abs($calc);
        } else {
            $statusTransaksi = true;
            $cicilan = 0;
        }

        return [
            'hutang' => $hutang,
            'kembalian' => $kembalian,
            'bayar' => $bayar,
            'tipe_transaksi' => $tipeTransaksi,
            'status_transaksi' => $statusTransaksi,
            'cicilan' => $cicilan,
            'id' => $id,
        ];
    }

    public static function paymentStatisPembelian($id)
    {
        $pembelian = new Pembelian();
        $getPembelian = $pembelian->invoicePembelian($id);

        $hutang = 0;
        $kembalian = 0;
        $bayar = 0;
        $tipeTransaksi = '';
        $statusTransaksi = false;
        $cicilan = 0;


        if (count($getPembelian->pembelianCicilan) > 0) {
            $getPembelianCicilan = $getPembelian->pembelianCicilan;
            $getPembelianCicilan = $getPembelianCicilan[0];

            $getBayarCicilan = $getPembelian->pembelianCicilan->pluck('bayar_pbcicilan')->toArray();
            $totalBayar = array_sum($getBayarCicilan);

            $hutang = $getPembelianCicilan->bayar_pbcicilan + $getPembelianCicilan->hutang_pbcicilan;
            $kembalian = $getPembelian->kembalian_pembelian;
            $bayar = $totalBayar;
            $tipeTransaksi = 'hutang';
        } else {
            $hutang = $getPembelian->hutang_pembelian;
            $kembalian = 0;
            $bayar = 0;
            $tipeTransaksi = $getPembelian->tipe_pembelian;
        }

        $calc = $bayar - $hutang;
        if ($calc < 0) {
            $statusTransaksi = false;
            $cicilan = abs($calc);
        } else {
            $statusTransaksi = true;
            $cicilan = ($calc);
        }

        return [
            'hutang' => $hutang,
            'kembalian' => $kembalian,
            'bayar' => $bayar,
            'tipe_transaksi' => $tipeTransaksi,
            'status_transaksi' => $statusTransaksi,
            'cicilan' => $cicilan,
        ];
    }

    public static function createdApp()
    {
        return 'Jasmine Motor';
    }

    public static function checkTanggalBerkala($data)
    {
        if ($data['status_pservis'] == 'proses servis' || $data['status_pservis'] == 'bisa diambil') {
            $nilaiberkala_pservis = $data['nilaiberkala_pservis'];
            $tipeberkala_pservis = $data['tipeberkala_pservis'];
            $tanggalSekarang = date('Y-m-d');
            $tanggal_service_berkala = date('Y-m-d');

            if ($tipeberkala_pservis == 'hari') {
                $tanggal_service_berkala = date('Y-m-d', strtotime($tanggalSekarang . ' +' . $nilaiberkala_pservis . ' days'));
            }

            if ($tipeberkala_pservis == 'bulan') {
                $tanggal_service_berkala = date('Y-m-d', strtotime($tanggalSekarang . ' +' . $nilaiberkala_pservis . ' months'));
            }
            if ($tipeberkala_pservis == 'tahun') {
                $tanggal_service_berkala = date('Y-m-d', strtotime($tanggalSekarang . ' +' . $nilaiberkala_pservis . ' years'));
            }

            return $tanggal_service_berkala;
        }
    }

    public static function checkTanggalGaransi($data)
    {
        $nilaigaransi_pservis = $data['nilaigaransi_pservis'];
        $tipegaransi_pservis = $data['tipegaransi_pservis'];
        $tanggalSekarang = date('Y-m-d');
        $tanggal_service_berkala = date('Y-m-d');

        if ($tipegaransi_pservis == 'hari') {
            $tanggal_service_berkala = date('Y-m-d', strtotime($tanggalSekarang . ' +' . $nilaigaransi_pservis . ' days'));
        }

        if ($tipegaransi_pservis == 'bulan') {
            $tanggal_service_berkala = date('Y-m-d', strtotime($tanggalSekarang . ' +' . $nilaigaransi_pservis . ' months'));
        }
        if ($tipegaransi_pservis == 'tahun') {
            $tanggal_service_berkala = date('Y-m-d', strtotime($tanggalSekarang . ' +' . $nilaigaransi_pservis . ' years'));
        }

        return $tanggal_service_berkala;
    }

    public static function generateKodeTStock()
    {
        $count = TransferStock::where('cabang_id', session()->get('cabang_id'))->max('id');
        $count = $count + 1;
        $kode_tstock = date("Ymd") . $count;
        return $kode_tstock;
    }

    public static function dataUpdateServis($id, $datastatis)
    {
        $penerimaanServis = new PenerimaanServis();
        $row = $penerimaanServis->transaksiServis($id);

        $hargaServis = new HargaServis();
        $getServis = $hargaServis->getServis()->get();

        foreach ($getServis as $key => $item) {
            $array_harga_servis[] = [
                'label' => '<strong>Nama Servis: ' . $item->nama_hargaservis . '</strong> <br />
                <span>Harga Servis: ' . UtilsHelper::formatUang($item->total_hargaservis) . '</span>',
                'id' => $item->id,
            ];
        }
        $usersId = Auth::id();
        $penerimaanServisId = $id;

        $barang = Barang::dataTable()
            ->with('satuan', 'kategori')
            ->where('status_barang', 'dijual & untuk servis')
            ->orWhere('status_barang', 'khusus servis')
            ->get();
        $array_barang = [];
        foreach ($barang as $key => $item) {
            $array_barang[] = [
                'id' => $item->id,
                'label' => '
            <strong>[' . $item->barcode_barang . '] ' . $item->nama_barang . '</strong> <br />
            <span>Stok: ' . $item->stok_barang . '</span>
            '
            ];
        }
        $tipeDiskon = ($datastatis['tipe_diskon']);
        $statusKendaraanServis = ($datastatis['status_kendaraan_servis']);
        $serviceBerkala = ($datastatis['servis_berkala']);
        $cabangId = session()->get('cabang_id');

        $array_status_kendaraan = [];
        foreach ($statusKendaraanServis as $key => $item) {
            $array_status_kendaraan[] = [
                'label' => $item,
                'id' => $key,
            ];
        }

        $array_service_berkala = [];
        foreach ($serviceBerkala as $key => $item) {
            $array_service_berkala[] = [
                'label' => $item,
                'id' => $key,
            ];
        }

        $pesanwa_berkala = $datastatis['pesanwa_berkala'];

        // data pengembalian
        $array_kategori_pembayaran = [];
        $kategoriPembayaran = KategoriPembayaran::dataTable()->where('status_kpembayaran', true)
            ->get();
        foreach ($kategoriPembayaran as $value => $item) {
            $array_kategori_pembayaran[] = [
                'id' => $item->id,
                'label' => $item->nama_kpembayaran
            ];
        }
        $kategoriPembayaran = json_encode($kategoriPembayaran);
        $array_kategori_pembayaran = json_encode($array_kategori_pembayaran);

        $array_sub_pembayaran = [];
        $subPembayaran = SubPembayaran::dataTable()->where('status_spembayaran', true)
            ->get();
        foreach ($subPembayaran as $value => $item) {
            $array_sub_pembayaran[] = [
                'id' => $item->id,
                'label' => $item->nama_spembayaran,
                'kategori_pembayaran_id' => $item->kategori_pembayaran_id
            ];
        }
        $subPembayaran = json_encode($subPembayaran);
        $array_sub_pembayaran = json_encode($array_sub_pembayaran);

        $dataUser = User::dataTable()
            ->join('roles', 'roles.id', '=', 'users.roles_id')
            ->with('profile')
            ->select('users.*', 'roles.id as roles_id', 'roles.name as roles_name', 'roles.guard_name as roles_guard')
            ->get();
        $dataUser = json_encode($dataUser);
        $defaultUser = Auth::id();
        $cabangId = session()->get('cabang_id');
        // end pengembalian


        $data = [
            'row' => $row,
            'array_harga_servis' => $array_harga_servis,
            'getServis' => $getServis,
            'usersId' => $usersId,
            'penerimaanServisId' => $penerimaanServisId,
            'barang' => $barang,
            'array_barang' => $array_barang,
            'tipeDiskon' => $tipeDiskon,
            'statusKendaraanServis' => $array_status_kendaraan,
            'serviceBerkala' => $array_service_berkala,
            'serviceGaransi' => $array_service_berkala,

            'jsonRow' => json_encode($row),
            'kategoriPembayaran' => $kategoriPembayaran,
            'array_kategori_pembayaran' => $array_kategori_pembayaran,
            'subPembayaran' => $subPembayaran,
            'array_sub_pembayaran' => $array_sub_pembayaran,
            'dataUser' => $dataUser,
            'defaultUser' => $defaultUser,
            'cabangId' => $cabangId,
            'is_deposit' => $row->isdp_pservis,
            'getPembayaranServis' => json_encode(UtilsHelper::paymentStatisPenerimaanServis($penerimaanServisId)),
            'pesanwa_berkala' => $pesanwa_berkala,
        ];
        return $data;
    }
}
