<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
       DB::table('users')->insert([
        'name' => 'master admin',
        'email' => 'masteradmin@mail.com',
        'password' => Hash::make('123123123'),
        'username' => 'masteradmin',
        'type' => 'masterAdmin',
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
    ]);

//        DB::table('users')->insert([
//         'name' => 'admin',
//         'email' => 'admin@mail.com',
//         'password' => Hash::make('123123123'),
//         'username' => 'admin',
//         'type' => 'admin',
//         'created_at' => Carbon::now(),
//         'updated_at' => Carbon::now()
//     ]);

//         DB::table('users')->insert([
//         'name' => 'manager',
//         'email' => 'manager@mail.com',
//         'password' => Hash::make('123123123'),
//         'username' => 'manager',
//         'type' => 'manager',
//         'created_at' => Carbon::now(),
//         'updated_at' => Carbon::now()
//    ]);

//         DB::table('users')->insert([
//         'name' => 'client',
//         'email' => 'client@mail.com',
//         'password' => Hash::make('123123123'),
//         'username' => 'client',
//         'type' => 'client',
//         'created_at' => Carbon::now(),
//         'updated_at' => Carbon::now()
//     ]);

    }
}
