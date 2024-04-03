<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderServis extends Model
{
    use HasFactory;
    protected $table = 'order_servis';
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

    public function hargaServis()
    {
        return $this->belongsTo(HargaServis::class);
    }

    public function penerimaanServis()
    {
        return $this->belongsTo(PenerimaanServis::class);
    }

    public function usersMekanik()
    {
        return $this->belongsTo(User::class, 'users_id_mekanik', 'id');
    }

    public function getOrderServis()
    {
        return OrderServis::dataTable()->with('users', 'hargaServis', 'hargaServis.kategoriServis', 'penerimaanServis', 'usersMekanik');
    }
}
