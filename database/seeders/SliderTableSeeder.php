<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SliderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('slider')->truncate();
        
        $faker = \Faker\Factory::create();
        
        for ($i = 1; $i <= 5; $i ++) {
            \DB::table('slider')->insert([
                'priority' => $i,
                'name' => $faker->city,
                'url' => $faker->url,
                'description' => $faker->realText(),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
