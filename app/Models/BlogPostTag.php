<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogPostTag extends Model
{
    use HasFactory;
    
    protected $table = 'blog_post_tags';
    
    public function getFrontUrl()
    {
        return route('front.blogs.category', [
            
            'category' => $this->id,
            'seoSlug' => \Str::slug($this->name)
        ]);
    }
}
