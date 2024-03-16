<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;
    protected $table = 'supplier';
    protected $guarded = [];
    public $timestamps = true;

    public function scopeDataTable($query)
    {
        return $query->where('cabang_id', session()->get('cabang_id'));
    }

    public function cabang()
    {
        return $this->belongsTo(Cabang::class);
    }

    public function pembelian()
    {
        return $this->hasMany(Pembelian::class);
    }

    public function pembelianProduct()
    {
        return $this->hasMany(PembelianProduct::class);
    }
}
