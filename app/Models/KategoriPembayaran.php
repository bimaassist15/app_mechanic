<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriPembayaran extends Model
{
    use HasFactory;
    protected $table = 'kategori_pembayaran';
    protected $guarded = [];

    public function scopeDataTable($query)
    {
        return $query->where('cabang_id', session()->get('cabang_id'));
    }

    public function subPembayaran()
    {
        return $this->hasMany(SubPembayaran::class);
    }
}
