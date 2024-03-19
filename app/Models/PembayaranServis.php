<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembayaranServis extends Model
{
    use HasFactory;
    protected $table = 'pembayaran_servis';
    protected $guarded = [];
    public $timestamps = true;

    public function penerimaanServis()
    {
        return $this->belongsTo(PenerimaanServis::class);
    }
}
