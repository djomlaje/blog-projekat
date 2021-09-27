<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class BlogPostTagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //isprazniti tabelu
        \DB::table('blog_post_tags')->truncate();
        
        $tagIds = \DB::table('tags')->get()->pluck('id');
        
        $blogPostIds = \DB::table('blog_posts')->get()->pluck('id');
        
        foreach ($blogPostIds as $blogPostId) {
            
            $randomTagIds = $tagIds->random(3);
            
            foreach ($randomTagIds as $tagId) {
                
                \DB::table('blog_post_tags')->insert([
                    'blog_post_id' => $blogPostId,
                    'tag_id' => $tagId,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
            }
        }
    }
}
