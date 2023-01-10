<?php

namespace Database\Seeders;

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
        return User::create([
            'nama' => 'Moh. Walid Arkham Sani',
            'email' => env('ADMIN_EMAIL'),
            'nip' => '200008062022011001',
            'jabatan' => 'Pengelola Data Transaksi',
            'password' => Hash::make(env('ADMIN_PASSWORD')),
            'role' => 'Admin'
        ]);
    }
}
