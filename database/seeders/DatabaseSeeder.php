<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Buku;
use App\Models\Role;
use App\Models\User;
use App\Models\Produk;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Role::create([
            'role'  => 'Penerbit'
        ]);
        Role::create([
            'role'  => 'Admin Cafe'
        ]);
        Role::create([
            'role'  => 'Bartender'
        ]);
        Role::create([
            'role'  => 'Pelanggan'
        ]);

        User::create([
            'name'      => 'Gramedia',
            'email'     => 'gramed@gmail.com',
            'password'  => bcrypt('DW101010!'),
            'role_id'   => 1
        ]);
        User::create([
            'name'      => 'Togamas',
            'email'     => 'toga@gmail.com',
            'password'  => bcrypt('DW101010!'),
            'role_id'   => 1
        ]);
        User::create([
            'name'      => 'Admin Cafe',
            'email'     => 'cafe@gmail.com',
            'password'  => bcrypt('DW101010!'),
            'role_id'   => 2
        ]);
        User::create([
            'name'      => 'Bartender',
            'email'     => 'bar@gmail.com',
            'password'  => bcrypt('DW101010!'),
            'role_id'   => 3
        ]);
        User::create([
            'name'      => 'Dwi Purnomo',
            'email'     => 'purnomodwi174@gmail.com',
            'password'  => bcrypt('DW101010!'),
            'role_id'   => 4
        ]);

        Buku::create([
            'nm_buku'       => 'Judul Buku 1',
            'penerbit'      => 'Gramedia',
            'thn_terbit'    => 2020,
            'deskripsi'     => 'Ini adalah deskripsi buku 1',
            'status'        => 'tersedia',
            'user_id'       => 1
        ]);
        Buku::create([
            'nm_buku'       => 'Judul Buku 2',
            'penerbit'      => 'Toga Mas',
            'thn_terbit'    => 2022,
            'deskripsi'     => 'Ini adalah deskripsi buku 2',
            'status'        => 'tersedia',
            'user_id'       => 2
        ]);

        Produk::create([
            'nm_produk' => 'Kopi',
            'harga'     => 20000,
            'deskripsi' => 'Ini adalah deskripsi dari kopi'
        ]);
        Produk::create([
            'nm_produk' => 'Kentang Goreng',
            'harga'     => 10000,
            'deskripsi' => 'Ini adalah deskripsi dari Kentang Goreng'
        ]);
    }
}
