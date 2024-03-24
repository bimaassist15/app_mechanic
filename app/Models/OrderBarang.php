<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderBarang extends Model
{
    use HasFactory;
    protected $table = 'order_barang';
    protected $guarded = [];
    public $timestamps = true;

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function barang()
    {
        return $this->belongsTo(barang::class);
    }

    public function penerimaanServis()
    {
        return $this->belongsTo(penerimaanServis::class);
    }

    public function getOrderBarang()
    {
        return OrderBarang::with('users', 'barang', 'penerimaanServis');
    }
}
