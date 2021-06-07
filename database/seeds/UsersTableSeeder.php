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
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin'),
            'hak_akses' => 'Admin'
     ]);
     
    //  App\Model\User::create([
        DB::table('users')->insert([
            'name' => 'Kasir',
            'email' => 'kasir@gmail.com',
            'password' => Hash::make('kasir'),
            'hak_akses' => 'Kasir'
     ]);
     
    //  App\Model\User::create([
        DB::table('users')->insert([
            'name' => 'Manajer',
            'email' => 'manajer@gmail.com',
            'password' => Hash::make('manajer'),
            'hak_akses' => 'Manajer'
     ]);     
    }
}