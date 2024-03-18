<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriServis extends Model
{
    use HasFactory;
    protected $table = 'kategori_servis';
    protected $guarded = [];
    public $timestamps = true;

    public function scopeDataTable($query)
    {
        return $query->where('cabang_id', session()->get('cabang_id'));
    }

    public function hargaServis()
    {
        return $this->hasMany(HargaServis::class);
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
