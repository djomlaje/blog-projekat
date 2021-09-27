<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class BlogPostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //isprazniti tabelu
        \DB::table('blog_posts')->truncate();
        
        $blogPostCategories = \DB::table('blog_post_categories')->get()->pluck('id');
        $blogPostUsers = \DB::table('users')->get()->pluck('id');
        
        $faker = \Faker\Factory::create();
        
        for ($i = 1; $i <= 30; $i++) {
            
            \DB::table('blog_posts')->insert([
                'name' => $faker->realTextBetween(20, 50),
                'description' => $faker->realText(255),
                'blog_post_category_id' => $blogPostCategories->random(),
                'blog_post_user_id' => $blogPostUsers->random(),
                'important' => rand(100, 999) % 2,
                'status' => rand(100, 999) % 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
