<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cabang extends Model
{
    use HasFactory;
    protected $table = 'cabang';
    protected $guarded = [];
    public $timestamps = true;

    public function barang()
    {
        return $this->hasMany(Barang::class);
    }

    public function customer()
    {
        return $this->hasMany(Customer::class);
    }

    public function hargaServis()
    {
        return $this->hasMany(HargaServis::class);
    }

    public function kategori()
    {
        return $this->hasMany(Kategori::class);
    }

    public function kategoriPembayaran()
    {
        return $this->hasMany(KategoriPembayaran::class);
    }

    public function kategoriServis()
    {
        return $this->hasMany(KategoriServis::class);
    }

    public function kendaraan()
    {
        return $this->hasMany(Kendaraan::class);
    }
    public function penjualan()
    {
        return $this->hasMany(Penjualan::class);
    }

    public function penjualanPembayaran()
    {
        return $this->hasMany(PenjualanPembayaran::class);
    }

    public function penjualanProduct()
    {
        return $this->hasMany(PenjualanProduct::class);
    }

    public function profile()
    {
        return $this->hasMany(Profile::class);
    }

    public function roles()
    {
        return $this->hasMany(Roles::class);
    }

    public function satuan()
    {
        return $this->hasMany(Satuan::class);
    }

    public function serialBarang()
    {
        return $this->hasMany(SerialBarang::class);
    }

    public function subPembayaran()
    {
        return $this->hasMany(SubPembayaran::class);
    }

    public function supplier()
    {
        return $this->hasMany(Supplier::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function penjualanCicilan()
    {
        return $this->hasMany(PenjualanCicilan::class);
    }

    public function pembelian()
    {
        return $this->hasMany(Pembelian::class);
    }

    public function pembelianCicilan()
    {
        return $this->hasMany(PembelianCicilan::class);
    }

    public function pembelianPembayaran()
    {
        return $this->hasMany(PembelianPembayaran::class);
    }

    public function pembelianProduct()
    {
        return $this->hasMany(PembelianProduct::class);
    }

    public function transferStock()
    {
        return $this->hasMany(TransferStock::class);
    }

    public function transferDetail()
    {
        return $this->hasMany(TransferDetail::class);
    }
}
