<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PatnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('patners')->insert([
            'patner_code' => strval(gmdate("YmdHis", time())),
            'name' => 'Patner Testing',
            'phone' => '6285747414103',
            'picture' => env('APP_URL') . '/icon-default/logo-company.jpg',
            'address' => 'Jalan nangka 1 no 12',
            'city' => 'JAKARTA TIMUR',
            'province' => 'DKI JAKARTA',
            'email' => 'malihatmalamm@gmail.com',
            'status' => 'active',
            'type' => 'institution',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }
}
