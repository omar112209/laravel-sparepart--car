<?php

namespace Database\Seeders;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Kategori;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'nama' => 'Administrator',
            'email' => 'admin@gmail.com',
            'role' => '1',
            'status' => 1,
            'hp' => '0812345678901',
            'password' => bcrypt('P@55word'),
        ]);
        #untuk record berikut nya sesaikan dengan studi kasus masing-masing
        User::create([
            'nama' => 'Yufaldhi Rangga Buana',
            'email' => 'yufaldhi@gmail.com',
            'role' => '0',
            'status' => 1,
            'hp' => '081234567892',
            'password' => bcrypt('P@55word'),
        ]);

        #untuk record berikut nya sesaikan dengan studi kasus masing-masing
        User::create([
            'nama' => 'Fauzan Omar Batistuta',
            'email' => 'fauzan@gmail.com',
            'role' => '0',
            'status' => 1,
            'hp' => '081234567892',
            'password' => bcrypt('P@55word'),
        ]);

        #untuk record berikut nya sesaikan dengan studi kasus masing-masing
        User::create([
            'nama' => 'Aditya Bagas Prabowo',
            'email' => 'Adit@gmail.com',
            'role' => '0',
            'status' => 1,
            'hp' => '081234567892',
            'password' => bcrypt('P@55word'),
        ]);

        #untuk record berikut nya sesaikan dengan studi kasus masing-masing
        User::create([
            'nama' => 'Iqbal Bimo Saputro',
            'email' => 'bimo@gmail.com',
            'role' => '0',
            'status' => 1,
            'hp' => '081234567892',
            'password' => bcrypt('P@55word'),
        ]);

        #untuk record berikut nya sesaikan dengan studi kasus masing-masing
        User::create([
            'nama' => 'Nasya Ashila',
            'email' => 'nasya@gmail.com',
            'role' => '0',
            'status' => 1,
            'hp' => '081234567892',
            'password' => bcrypt('P@55word'),
        ]);

        #data kategori
        Kategori::create([
            'nama_kategori' => 'Mesin',
        ]);
        Kategori::create([
            'nama_kategori' => 'Suspensi',
        ]);
        Kategori::create([
            'nama_kategori' => 'Rem',
        ]);
        Kategori::create([
            'nama_kategori' => 'Kelistrikan',
        ]);
        Kategori::create([
            'nama_kategori' => 'Transmisi',
        ]);
    }
}
