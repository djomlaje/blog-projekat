<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;
    
    protected $table = 'tags';
    
    protected $fillable = ['name'];


    public function blogPosts()
    {
        return $this->belongsToMany(
            Blog::class,
            'blog_post_tags',
            'tag_id',
            'blog_post_id'
        );
    }
    
    public function getFrontUrl()
    {
        return route('front.blogs.tag', [
            
            'tag' => $this->id,
            'seoSlug' => \Str::slug($this->name)
        ]);
    }
    
}
