<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaldoCustomer extends Model
{
    use HasFactory;
    protected $table = 'saldo_customer';
    protected $guarded = [];
    public $timestamps = true;

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
