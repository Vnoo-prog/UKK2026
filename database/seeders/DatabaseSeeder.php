<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'admin',
            'username' => 'min',
            'password' => '123',
            'role' => 'admin',
            'kelas' => null,
        ]);

        User::create([
            'name' => 'sulfin',
            'username' => 'vno',
            'password' => '123',
            'role' => 'siswa',
            'kelas' => '12 RPL 2',
        ]);

        Category::create(['nama' => 'Fasilitas dan Sarana Prasarana']);
        Category::create(['nama' => 'Kurikulum dan Metode Pembelajaran']);
        Category::create(['nama' => 'Lingkungan dan Kebersihan']);
        Category::create(['nama' => 'Kesejahteraan dan Kesehatan Siswa']);
        Category::create(['nama' => 'Komunikasi dan Budaya Sekolah']);
    }
}
