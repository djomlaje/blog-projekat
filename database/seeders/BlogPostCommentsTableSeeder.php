<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class BlogPostCommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //isprazni tabelu
        \DB::table('comments')->truncate();
        
        $blogPosts = \DB::table('blog_posts')->get()->pluck('id');
        
        $faker = \Faker\Factory::create();
        
        for ($i = 1; $i <= 100; $i ++) {
            \DB::table('comments')->insert([
                'name' => $faker->name,
                'email' => $faker->email,
                'description' => $faker->realText($maxNbChars = 200),
                'blog_post_id' => $blogPosts->random(),
                'status' => rand(100, 999) % 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
