<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('users')->truncate();
        
        \DB::table('users')->insert([
            'status' => 1,
            'admin' => 1,
            'name' => 'Mladen Dragic',
            'email' => 'mladen.dragic1993@gmail.com',
            'password' => \Hash::make('cubesphp'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        
        \DB::table('users')->insert([
            'status' => 1,
            'admin' => 1,
            'name' => 'Pera Peric',
            'email' => 'pera.peric@cubes.rs',
            'password' => \Hash::make('cubesphp'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        
        \DB::table('users')->insert([
            'status' => 1,
            'admin' => 1,
            'name' => 'Marko Markovic',
            'email' => 'marko.markovic@cubes.rs',
            'password' => \Hash::make('cubesphp'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        
        \DB::table('users')->insert([
            'status' => 1,
            'admin' => 1,
            'name' => 'Petar Petrovic',
            'email' => 'petar.petrovic@cubes.rs',
            'password' => \Hash::make('cubesphp'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        
        \DB::table('users')->insert([
            'status' => 1,
            'admin' => 1,
            'name' => 'Nikola Nikolic',
            'email' => 'nikola.nikolic@cubes.rs',
            'password' => \Hash::make('cubesphp'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
