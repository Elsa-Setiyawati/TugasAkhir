<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use Hash;
use App\Model\User;
class RolesTableSeeder extends Seeder
{
    public function run()
    {
        // App\Role::create([
            DB::table('roles')->insert([
            'name' => 'Admin Gudang',
            // 'hak_akses' => 'Admin Gudang'
            ]);
        // App\Role::create([
            DB::table('roles')->insert([
            'name' => 'Admin Penjualan',
            // 'hak_akses' => 'Admin Penjualan'
            ]);
        // App\Role::create([
            DB::table('roles')->insert([
            'name' => 'Pemilik', 
            // 'hak_akses' => 'Pemilik'
            ]);
    }
}