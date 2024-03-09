<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriServis extends Model
{
    use HasFactory;
    protected $table = 'kategori_servis';
    protected $guarded = [];

    public function hargaServis()
    {
        return $this->hasMany(HargaServis::class);
    }
}
