<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;
    protected $table = 'profile';
    protected $guarded = [];
    public $timestamps = true;

    public function scopeDataTable($query)
    {
        return $query->where('profile.cabang_id', session()->get('cabang_id'));
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }

    public function cabang()
    {
        return $this->belongsTo(Cabang::class);
    }

    public function getJeniskelaminProfileAttribute($value)
    {
        return $value == 'L' ? 'Laki-laki' : 'Perempuan';
    }
}
