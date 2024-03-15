<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenjualanProduct extends Model
{
    use HasFactory;
    protected $table = 'penjualan_product';
    protected $guarded = [];
    public $timestamps = true;

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    public function cabang()
    {
        return $this->belongsTo(Cabang::class);
    }
}
