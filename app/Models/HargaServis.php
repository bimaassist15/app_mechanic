<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HargaServis extends Model
{
    use HasFactory;
    protected $table = 'harga_servis';
    protected $guarded = [];

    public function kategoriServis()
    {
        return $this->belongsTo(KategoriServis::class);
    }
}
