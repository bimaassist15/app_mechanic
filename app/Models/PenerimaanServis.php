<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenerimaanServis extends Model
{
    use HasFactory;
    protected $table = 'penerimaan_servis';
    protected $guarded = [];
    public $timestamps = true;

    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class);
    }

    public function kategoriServis()
    {
        return $this->belongsTo(KategoriServis::class);
    }
}
