<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenjualanPembayaran extends Model
{
    use HasFactory;
    protected $table = 'penjualan_pembayaran';
    protected $guarded = [];
    public $timestamps = true;

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class);
    }

    public function kategoriPembayaran()
    {
        return $this->belongsTo(KategoriPembayaran::class);
    }

    public function subPembayaran()
    {
        return $this->belongsTo(SubPembayaran::class);
    }

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function cabang()
    {
        return $this->belongsTo(Cabang::class);
    }
}
