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
}
