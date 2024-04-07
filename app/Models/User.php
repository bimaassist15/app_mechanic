<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
        'cabang_id',
        'roles_id',
        'status_users',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public $timestamps = true;

    public function scopeDataTable($query)
    {
        return $query->where('users.cabang_id', session()->get('cabang_id'));
    }

    public function profile()
    {
        return $this->hasOne(Profile::class, 'users_id', 'id');
    }

    public function penjualanPembayaran()
    {
        return $this->hasMany(PenjualanPembayaran::class);
    }

    public function cabang()
    {
        return $this->belongsTo(Cabang::class);
    }

    public function penjualan()
    {
        return $this->hasMany(Penjualan::class);
    }

    public function penjualanCicilan()
    {
        return $this->hasMany(PenjualanCicilan::class);
    }

    public function pembelian()
    {
        return $this->hasMany(Pembelian::class);
    }

    public function pembelianCicilan()
    {
        return $this->hasMany(PembelianCicilan::class);
    }

    public function pembelianPembayaran()
    {
        return $this->hasMany(PembelianPembayaran::class);
    }

    public function penerimaanServis()
    {
        return $this->hasMany(PenerimaanServis::class);
    }

    public function pembayaranServis()
    {
        return $this->hasMany(PembayaranServis::class);
    }

    public function orderServis()
    {
        return $this->hasMany(OrderServis::class);
    }

    public function getUsersMekanik()
    {
        return User::dataTable()->with('profile')
            ->whereHas('roles', function ($query) {
                $query->where('name', 'like', '%mekanik%');
            })->get();
    }

    public function orderBarang()
    {
        return $this->hasMany(OrderBarang::class);
    }

    public function getUsersKasir()
    {
        return User::dataTable()->with('profile');
    }

    public function transferStock()
    {
        return $this->hasMany(TransferStock::class);
    }
}
