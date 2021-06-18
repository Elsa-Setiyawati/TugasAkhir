<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
class UsersTableSeeder extends Seeder
{
    public function run()
    {
    // App\Model\User::create([
        DB::table('users')->insert([
            'name' => 'Admin Gudang',
            'email' => 'admingudang@gmail.com',
            'password' => Hash::make('admingudang'),
            'hak_akses' => 'Admin Gudang',
            'role_id' => 1
     ]);
     
    //  App\Model\User::create([
        DB::table('users')->insert([
            'name' => 'Admin Penjualan',
            'email' => 'adminjual@gmail.com',
            'password' => Hash::make('adminjual'),
            'hak_akses' => 'Admin Penjualan',
            'role_id' => 2
     ]);
     
    //  App\Model\User::create([
        DB::table('users')->insert([
            'name' => 'Pemilik',
            'email' => 'pemilik@gmail.com',
            'password' => Hash::make('pemilik'),
            'hak_akses' => 'Pemilik',
            'role_id' => 3
     ]);     
    }
}