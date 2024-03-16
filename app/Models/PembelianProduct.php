<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembelianProduct extends Model
{
    use HasFactory;
    protected $table = 'pembelian_product';
    protected $guarded = [];
    public $timestamps = true;

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    public function cabang()
    {
        return $this->belongsTo(Cabang::class);
    }

    public function pembelian()
    {
        return $this->belongsTo(Pembelian::class);
    }
}
