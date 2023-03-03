<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        define('DOMINAIN',['gmail.com', 'outlook.com', 'clicko.es', 'hotmail.com']);
        define('COUNT_DOMAIN', count(DOMINAIN)-1);

        for ($i=0; $i < 50; $i++) { 
            DB::table('users')->insert([
                'name' => Str::random(10),
                'email' => Str::random(10).'@'.DOMINAIN[random_int(0, COUNT_DOMAIN)],
                'password' => Hash::make('password'),
            ]);
        }
    }
}
