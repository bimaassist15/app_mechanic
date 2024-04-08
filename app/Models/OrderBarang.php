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

    public function scopeDataTable($query)
    {
        return $query->where('cabang_id', session()->get('cabang_id'));
    }

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    public function penerimaanServis()
    {
        return $this->belongsTo(PenerimaanServis::class);
    }

    public function getOrderBarang()
    {
        return OrderBarang::dataTable()->with('users', 'barang', 'penerimaanServis');
    }
}
