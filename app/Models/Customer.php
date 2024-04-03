<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Customer extends Model
{
    use HasFactory;
    protected $table = 'customer';
    protected $guarded = [];
    public $timestamps = true;

    public function scopeDataTable($query)
    {
        return $query->where('cabang_id', session()->get('cabang_id'));
    }

    public function kendaraan()
    {
        return $this->hasMany(Kendaraan::class);
    }

    public function penjualanProduct()
    {
        return $this->hasMany(PenjualanProduct::class);
    }

    public function cabang()
    {
        return $this->belongsTo(Cabang::class);
    }

    public function penjualan()
    {
        return $this->hasMany(Penjualan::class);
    }

    public function saldoCustomer()
    {
        return $this->hasOne(SaldoCustomer::class);
    }

    public function dataCustomer()
    {
        return Customer::with(
            'kendaraan',
            'kendaraan.customer',
            'penjualan',
            'penerimaanServis',
            'penjualan.users',
            'penjualan.users.profile',
            'penjualan.penjualanProduct',
            'penjualan.penjualanProduct.barang',
            'penjualan.penjualanPembayaran',
            'penjualan.penjualanPembayaran.kategoriPembayaran',
            'penjualan.penjualanPembayaran.subPembayaran',
            'penjualan.penjualanPembayaran.users',
            'penjualan.penjualanPembayaran.users.profile',
            'penjualan.penjualanCicilan',
            'penjualan.penjualanCicilan.kategoriPembayaran',
            'penjualan.penjualanCicilan.subPembayaran',
            'penjualan.penjualanCicilan.users',
            'penjualan.penjualanCicilan.users.profile',
        )
            ->withCount(['penjualan', 'penerimaanServis'])
            ->where('cabang_id', session()->get('cabang_id'));
    }

    public function penerimaanServis()
    {
        return $this->hasMany(PenerimaanServis::class);
    }

    public function getReportCustomer($dari_tanggal, $sampai_tanggal)
    {
        return Customer::dataTable()
            ->withCount([
                'penjualan as total_pembelian' => function ($query) use ($dari_tanggal, $sampai_tanggal) {
                    $query->select(DB::raw("SUM(bayar_penjualan) - SUM(kembalian_penjualan)"));
                    if ($dari_tanggal != null) {
                        $query = $query->whereDate('created_at', '>=', $dari_tanggal);
                    }
                    if ($sampai_tanggal != null) {
                        $query = $query->whereDate('updated_at', '<=', $sampai_tanggal);
                    }
                },
                'penjualan as jumlah_pembelian' => function ($query) use ($dari_tanggal, $sampai_tanggal) {
                    $query->select(DB::raw("COUNT(*)"));
                    if ($dari_tanggal != null) {
                        $query = $query->whereDate('created_at', '>=', $dari_tanggal);
                    }
                    if ($sampai_tanggal != null) {
                        $query = $query->whereDate('updated_at', '<=', $sampai_tanggal);
                    }
                },
                'penjualan as hutang_pembelian' => function ($query) use ($dari_tanggal, $sampai_tanggal) {
                    $query->select(DB::raw("SUM(hutang_penjualan)"));
                    if ($dari_tanggal != null) {
                        $query = $query->whereDate('created_at', '>=', $dari_tanggal);
                    }
                    if ($sampai_tanggal != null) {
                        $query = $query->whereDate('updated_at', '<=', $sampai_tanggal);
                    }
                },

                'penerimaanServis as total_servis' => function ($query) use ($dari_tanggal, $sampai_tanggal) {
                    $query->select(DB::raw("SUM(bayar_pservis) - SUM(kembalian_pservis)"));
                    if ($dari_tanggal != null) {
                        $query = $query->whereDate('created_at', '>=', $dari_tanggal);
                    }
                    if ($sampai_tanggal != null) {
                        $query = $query->whereDate('updated_at', '<=', $sampai_tanggal);
                    }
                },
                'penerimaanServis as jumlah_servis' => function ($query) use ($dari_tanggal, $sampai_tanggal) {
                    $query->select(DB::raw("COUNT(*)"));
                    if ($dari_tanggal != null) {
                        $query = $query->whereDate('created_at', '>=', $dari_tanggal);
                    }
                    if ($sampai_tanggal != null) {
                        $query = $query->whereDate('updated_at', '<=', $sampai_tanggal);
                    }
                },
                'penerimaanServis as hutang_servis' => function ($query) use ($dari_tanggal, $sampai_tanggal) {
                    $query->select(DB::raw("SUM(hutang_pservis)"));
                    if ($dari_tanggal != null) {
                        $query = $query->whereDate('created_at', '>=', $dari_tanggal);
                    }
                    if ($sampai_tanggal != null) {
                        $query = $query->whereDate('updated_at', '<=', $sampai_tanggal);
                    }
                },

            ])
            ->with('saldoCustomer')
            ->where('status_customer', true);
    }
}
