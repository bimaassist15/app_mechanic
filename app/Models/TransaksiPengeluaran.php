<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiPengeluaran extends Model
{
    use HasFactory;
    protected $table = 'transaksi_pengeluaran';
    protected $guarded = [];
    public $timestamps = true;

    public function scopeDataTable($query)
    {
        return $query->where('transaksi_pengeluaran.cabang_id', session()->get('cabang_id'));
    }

    public function kategoriPengeluaran()
    {
        return $this->belongsTo(KategoriPengeluaran::class);
    }

    public function getPengeluaran()
    {
        return TransaksiPengeluaran::dataTable()->with('kategoriPengeluaran');
    }
}
