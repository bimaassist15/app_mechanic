<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaldoDetail extends Model
{
    use HasFactory;
    protected $table = 'saldo_detail';
    protected $guarded = [];
    public $timestamps = true;
}
