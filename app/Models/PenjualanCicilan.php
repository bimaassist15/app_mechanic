<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenjualanCicilan extends Model
{
    use HasFactory;
    protected $table = 'penjualan_cicilan';
    protected $guarded = [];
    public $timestamps = true;

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class);
    }

    public function cabang()
    {
        return $this->belongsTo(Cabang::class);
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

    public function getData($penjualan_id)
    {
        $data = PenjualanCicilan::with('kategoriPembayaran', 'subPembayaran', 'users', 'users.profile', 'cabang')
            ->where('cabang_id', session()->get('cabang_id'))
            ->find($penjualan_id);
        return $data;
    }

    public function dataTable($penjualan_id)
    {
        $data = PenjualanCicilan::with('kategoriPembayaran', 'subPembayaran', 'users', 'users.profile', 'cabang')
            ->where('cabang_id', session()->get('cabang_id'))
            ->where('penjualan_id', $penjualan_id);
        return $data;
    }
}
