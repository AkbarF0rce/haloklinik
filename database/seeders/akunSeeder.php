<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class akunSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('akun')->insert([
            [
                'username' => 'admin',
                'password' => Hash::make(123456),
                'role' => 'admin'
            ],
            [
                'username' => 'dokter1',
                'password' => Hash::make(123456),
                'role' => 'dokter'
            ],
        ]);
    }
}
