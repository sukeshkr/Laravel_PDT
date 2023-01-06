<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
            'name'     =>  'admin',
            'email'    =>  'admin@gmail.com',
            'mobile'   =>  rand(77777777,999999999),
            'password' =>  Hash::make('admin'),

        ]);
    }
}
