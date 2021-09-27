<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogPostCategory extends Model
{
    use HasFactory;
    
    protected $table = 'blog_post_categories';
    
    protected $fillable = ['name', 'description', 'priority'];


    public function blogPosts()
    {
        return $this->hasMany(
            Blog::class,
            'blog_post_category_id',
            'id'
        ); //vraca query builder
    }
    
    public function getFrontUrl()
    {
        return route('front.blogs.category', [
            
            'category' => $this->id,
            'seoSlug' => \Str::slug($this->name)
        ]);
    }
}
