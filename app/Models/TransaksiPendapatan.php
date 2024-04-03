<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiPendapatan extends Model
{
    use HasFactory;
    protected $table = 'transaksi_pendapatan';
    protected $guarded = [];
    public $timestamps = true;

    public function scopeDataTable($query)
    {
        return $query->where('transaksi_pendapatan.cabang_id', session()->get('cabang_id'));
    }

    public function kategoriPendapatan()
    {
        return $this->belongsTo(KategoriPendapatan::class);
    }

    public function getPendapatan()
    {
        return TransaksiPendapatan::dataTable()->with('kategoriPendapatan');
    }
}
