<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class BlogPostCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //isprazni tabelu
        \DB::table('blog_post_categories')->truncate();
        
        $faker = \Faker\Factory::create();
        
        for ($i = 1; $i <= 5; $i ++) {
            \DB::table('blog_post_categories')->insert([
                'priority' => $i,
                'name' => $faker->city,
                'description' => $faker->realText(),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
