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
            'name' => 'Admin Gudang'
            ]);
        // App\Role::create([
            DB::table('roles')->insert([
            'name' => 'Admin Penjualan'
            ]);
        // App\Role::create([
            DB::table('roles')->insert([
            'name' => 'Pemilik'
            ]);
    }
}