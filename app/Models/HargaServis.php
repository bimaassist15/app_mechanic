<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HargaServis extends Model
{
    use HasFactory;
    protected $table = 'harga_servis';
    protected $guarded = [];
    public $timestamps = true;

    public function scopeDataTable($query)
    {
        return $query->where('cabang_id', session()->get('cabang_id'));
    }

    public function kategoriServis()
    {
        return $this->belongsTo(KategoriServis::class);
    }

    public function cabang()
    {
        return $this->belongsTo(Cabang::class);
    }

}
