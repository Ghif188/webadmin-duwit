<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PocketCNSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pockets')->insert([
            'pocket_code' => strval(gmdate("YmdHis", time()) . gettimeofday()["usec"]),
            'name' => 'Saldo Perusahaan',
            'picture' => env('APP_URL') . '/icon-default/logo-company.jpg',
            'status' => 'active',
            'type' => 'company',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }
}
