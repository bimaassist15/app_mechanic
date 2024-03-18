<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kendaraan extends Model
{
    use HasFactory;
    protected $table = 'kendaraan';
    protected $guarded = [];
    public $timestamps = true;

    public function scopeDataTable($query)
    {
        return $query->where('cabang_id', session()->get('cabang_id'));
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function cabang()
    {
        return $this->belongsTo(Cabang::class);
    }

    public function penerimaanServis()
    {
        return $this->hasMany(PenerimaanServis::class);
    }
}
