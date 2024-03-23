<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
