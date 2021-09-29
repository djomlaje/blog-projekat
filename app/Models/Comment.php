<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    
    protected $table = 'comments';
    
    protected $fillable = ['name', 'email', 'description', 'blog_post_id'];
    
    
    //RELATIONSHIPS
    public function blogPost()
    {
        return $this->belongsTo(
            Blog::class,
            'blog_post_id', //preneseni kljuc u tabeli deteta
            'id' //naziv kljuca u tabeli roditelja
        );
    }
    
    public function getBlogPostName()
    {
        $blogPost = Blog::where('id', '=', $this->blog_post_id)
                ->pluck('name');
        return $blogPost;  
    }
    
    public function getPostUrl()
    {
        return route('front.blogs.single', [
            
            'blog' => $this->blog_post_id,
        ]);
    }
    
    
    
    
    
}
