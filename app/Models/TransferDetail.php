<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransferDetail extends Model
{
    use HasFactory;
    protected $table = 'transfer_detail';
    protected $guarded = [];
    public $timestamps = true;

    public function transferStock()
    {
        return $this->belongsTo(TransferStock::class);
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    public function cabang()
    {
        return $this->belongsTo(Cabang::class);
    }
}
