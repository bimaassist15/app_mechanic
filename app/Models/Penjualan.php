<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;
    protected $table = 'penjualan';
    protected $guarded = [];
    public $timestamps = true;

    public function scopeDataTable($query)
    {
        return $query->where('penjualan.cabang_id', session()->get('cabang_id'));
    }

    public function penjualanProduct()
    {
        return $this->hasMany(PenjualanProduct::class);
    }
    public function penjualanPembayaran()
    {
        return $this->hasMany(PenjualanPembayaran::class);
    }

    public function cabang()
    {
        return $this->belongsTo(Cabang::class);
    }

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function penjualanCicilan()
    {
        return $this->hasMany(PenjualanCicilan::class);
    }

    public function invoicePenjualan($penjualan_id)
    {
        $data = Penjualan::with('customer', 'users', 'users.profile', 'penjualanProduct', 'penjualanProduct.barang', 'penjualanPembayaran', 'penjualanPembayaran.kategoriPembayaran', 'penjualanPembayaran.subPembayaran', 'penjualanPembayaran.users', 'penjualanPembayaran.users.profile',  'penjualanCicilan', 'penjualanCicilan.kategoriPembayaran', 'penjualanCicilan.subPembayaran', 'penjualanCicilan.users', 'penjualanCicilan.users.profile')->find($penjualan_id);
        return $data;
    }

    public function invoiceLunas()
    {
        $data = Penjualan::with('customer', 'users', 'users.profile', 'penjualanProduct', 'penjualanProduct.barang', 'penjualanPembayaran', 'penjualanPembayaran.kategoriPembayaran', 'penjualanPembayaran.subPembayaran', 'penjualanPembayaran.users', 'penjualanPembayaran.users.profile',  'penjualanCicilan', 'penjualanCicilan.kategoriPembayaran', 'penjualanCicilan.subPembayaran', 'penjualanCicilan.users', 'penjualanCicilan.users.profile')
            ->where('tipe_penjualan', 'cash')
            ->where('cabang_id', session()->get('cabang_id'))
            ->whereHas('penjualanCicilan');
        return $data;
    }

    public function getReportPenjualan()
    {
        $data = Penjualan::dataTable()->with('customer', 'users', 'users.profile', 'penjualanProduct', 'penjualanProduct.barang', 'penjualanPembayaran', 'penjualanPembayaran.kategoriPembayaran', 'penjualanPembayaran.subPembayaran', 'penjualanPembayaran.users', 'penjualanPembayaran.users.profile',  'penjualanCicilan', 'penjualanCicilan.kategoriPembayaran', 'penjualanCicilan.subPembayaran', 'penjualanCicilan.users', 'penjualanCicilan.users.profile');
        return $data;
    }
}
