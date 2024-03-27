<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'account_code' => strval(gmdate("YmdHis", time()) . gettimeofday()["usec"]),
            'fullname' => 'Manager CINURAWA',
            'phone' => '6285747414102',
            'pin' => '300326',
            'role' => 'admin_manager',
            'email' =>'cinurawa@gmail.com',
            'status' => 'active',
            'avatar' => env('APP_URL') . '/icon-default/logo-company.jpg',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }
}
