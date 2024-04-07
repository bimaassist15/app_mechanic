<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransferStock extends Model
{
    use HasFactory;
    protected $table = 'transfer_stock';
    protected $guarded = [];
    public $timestamps = true;


    public function scopeDataTable($query)
    {
        return $query->where('transfer_stock.cabang_id', session()->get('cabang_id'));
    }

    public function transferDetail()
    {
        return $this->hasMany(TransferDetail::class);
    }

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function cabang()
    {
        return $this->belongsTo(Cabang::class);
    }

    public function cabangPenerima()
    {
        return $this->belongsTo(Cabang::class, 'cabang_id_penerima', 'id');
    }

    public function cabangPemberi()
    {
        return $this->belongsTo(Cabang::class, 'cabang_id_awal', 'id');
    }

    public function usersPenerima()
    {
        return $this->belongsTo(User::class, 'users_id_diterima', 'id');
    }

    public function getTransferStock()
    {
        return TransferStock::dataTable()->with('transferDetail', 'transferDetail.barang', 'users', 'cabang', 'cabangPenerima', 'cabangPemberi', 'usersPenerima');
    }
}
