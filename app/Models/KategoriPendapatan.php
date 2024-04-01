<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriPendapatan extends Model
{
    use HasFactory;
    protected $table = 'kategori_pendapatan';
    protected $guarded = [];
    public $timestamps = true;

    public function scopeDataTable($query)
    {
        return $query->where('cabang_id', session()->get('cabang_id'));
    }

    public function TransaksiPendapatan()
    {
        return $this->hasMany(TransaksiPendapatan::class);
    }
}
