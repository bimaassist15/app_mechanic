<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubPembayaran extends Model
{
    use HasFactory;
    protected $table = 'sub_pembayaran';
    protected $guarded = [];
    public $timestamps = true;

    public function scopeDataTable($query)
    {
        return $query->where('cabang_id', session()->get('cabang_id'));
    }

    public function kategoriPembayaran()
    {
        return $this->belongsTo(KategoriPembayaran::class);
    }

    public function penjualanPembayaran()
    {
        return $this->hasMany(PenjualanPembayaran::class);
    }

    public function cabang()
    {
        return $this->belongsTo(Cabang::class);
    }

    public function penjualanCicilan()
    {
        return $this->hasMany(PenjualanCicilan::class);
    }

    public function pembelianCicilan()
    {
        return $this->hasMany(PembelianCicilan::class);
    }

    public function pembelianPembayaran()
    {
        return $this->hasMany(PembelianPembayaran::class);
    }

    public function pembayaranServis()
    {
        return $this->hasMany(PembayaranServis::class);
    }
}
