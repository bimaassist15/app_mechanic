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

    public function pembayaranServis()
    {
        return $this->hasMany(PembayaranServis::class);
    }

    public function scopeDataTable()
    {
        $data = PenerimaanServis::with('kendaraan', 'kendaraan.customer', 'kategoriServis', 'pembayaranServis')
            ->where('cabang_id', session()->get('cabang_id'));
        return $data;
    }

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function transaksiServis($penerimaan_servis_id)
    {
        $data = PenerimaanServis::with('kendaraan', 'kendaraan.customer', 'kategoriServis', 'pembayaranServis', 'users', 'pembayaranServis.kategoriPembayaran', 'pembayaranServis.subPembayaran', 'pembayaranServis.users', 'serviceHistory', 'orderServis', 'orderServis.usersMekanik', 'orderBarang', 'orderBarang.barang', 'customer', 'customer.saldoCustomer', 'usersIdGaransi')
            ->where('cabang_id', session()->get('cabang_id'))
            ->find($penerimaan_servis_id);
        return $data;
    }

    public function getReportServis()
    {
        $data = PenerimaanServis::with('kendaraan', 'kendaraan.customer', 'kategoriServis', 'pembayaranServis', 'users', 'pembayaranServis.kategoriPembayaran', 'pembayaranServis.subPembayaran', 'pembayaranServis.users', 'serviceHistory', 'orderServis', 'orderServis.usersMekanik', 'orderServis.hargaServis', 'orderServis.hargaServis.kategoriServis', 'orderBarang', 'orderBarang.barang', 'customer', 'customer.saldoCustomer', 'usersIdGaransi')
            ->where('penerimaan_servis.cabang_id', session()->get('cabang_id'));
        return $data;
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function orderServis()
    {
        return $this->hasMany(OrderServis::class);
    }

    public function orderBarang()
    {
        return $this->hasMany(OrderBarang::class);
    }

    public function serviceHistory()
    {
        return $this->hasMany(ServiceHistory::class);
    }

    public function usersIdGaransi()
    {
        return $this->belongsTo(User::class, 'users_id_garansi', 'id');
    }

    public function getDaysDifferenceAttribute()
    {
        return $this->updated_at->diffInDays($this->created_at);
    }
}
