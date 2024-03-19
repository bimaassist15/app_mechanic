<?php

namespace Database\Seeders;

use App\Models\Cabang;
use App\Models\Profile;
use App\Models\Roles;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $cabang = Cabang::create([
            'bengkel_cabang' => 'Bengkel Cabang pusat',
            'nama_cabang' => 'Cabang pusat',
            'nowa_cabang' => '082277506232',
            'kota_cabang' => 'Jakarta',
            'email_cabang' => 'cabangpusat@gmail.com',
            'alamat_cabang' => 'Jakarta pusat',
            'status_cabang' => true,
            'notelpon_cabang' => '6210898313',
            'tipeprint_cabang' => 'thermal',
            'printservis_cabang' => 'thermal',
            'lebarprint_cabang' => 80,
            'lebarprintservis_cabang' => 85,
            'domain_cabang' => 'cabangpusatdomain@gmail.com',
            'teksnotamasuk_cabang' => 'Hello selamat datang di cabang pusat',
            'teksnotaambil_cabang' => 'Silahkan berbelanja kembali',
        ]);
        $roles = Roles::create([
            'name' => 'Free Admin',
            'guard_name' => 'web',
            'cabang_id' => $cabang->id,
        ]);

        $user = User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'username' => 'admin',
            'password' => Hash::make('password'),
            'cabang_id' => $cabang->id,
            'roles_id' => $roles->id,
        ]);
        $user->assignRole('Free Admin');

        $profile = Profile::create([
            'nama_profile' => 'admin',
            'nohp_profile' => '082277506232',
            'alamat_profile' => "Jakarta pusat",
            'jeniskelamin_profile' => "L",
            'users_id' => $user->id,
            'cabang_id' => $cabang->id,
        ]);
    }
}
