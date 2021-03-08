<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
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
        User::create([
            'name'=>'john doe',
            'email'=>'johndoeuser@gmail.com',
            'phone'=>'10000000',
            'email_verified_at' => now(),
            'password' => Hash::make('123'), // password
            'remember_token' => Str::random(10),
            ]);
    }
}
