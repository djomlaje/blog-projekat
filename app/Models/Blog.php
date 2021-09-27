<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class Blog extends Model
{
    use HasFactory;
    
//    const STATUS_ENABLED = 1;
//    const STATUS_DISABLED = 0;
    
    protected $table = 'blog_posts';
    
    protected $fillable = ['blog_post_category_id', 'name', 'description', 'important', 'blog_post_user_id', 'views', 'details'];
    
//    public function isEnabled()
//	{
//            return $this->status == self::STATUS_ENABLED;
//	}
//	
//    public function isDisabled()
//	{
//            return $this->status == self::STATUS_DISABLED;
//	}
        
        
    //RELATIONSHIPS
    public function blogPostCategory()
    {
        return $this->belongsTo(
            BlogPostCategory::class,
            'blog_post_category_id', //preneseni kljuc u tabeli deteta
            'id' //naziv kljuca u tabeli roditelja
        );
    }
    
    public function users()
    {
        return $this->belongsTo(
            User::class,
            'blog_post_user_id',
            'id'
        );
    }
    
    public function tags()
    {
        return $this->belongsToMany(
            Tag::class,
            'blog_post_tags',
            'blog_post_id',
            'tag_id'
        );
    }
    
    public function comments()
    {
        return $this->hasMany(
            Comment::class,
            'blog_post_id',
            'id'
        ); //vraca query builder
    }
    
    
    //new posts
    public function scopeNewPosts($queryBuilder)
    {
        $queryBuilder->where('index_page', 1)
                ->where('created_at', '>=', date('Y-m-d', strtotime('-1 month')))
                ->orderBy('created_at', 'desc');
    }
    
    /*
     * return vraca URL u zavisnosti koji ID je proslijedjen u tom trenutku
     */
    public function getFrontUrl()
    {
        if ($this->status == 0) {
            echo 404;
        } else {
            return route('front.blogs.single', [
            'blog' => $this->id,
            'seoSlug' => \Str::slug($this->name)
        ]);
        }
    }
    
    public function getNextPost()
    {
        $blogPost = Blog::where('status', '=', '1')
                ->where('id', '>', $this->id)
                ->first();
        if (!isset($blogPost->id)) {
            return 404;
        }
        return route('front.blogs.single', [
            'blog' => $blogPost->id,
        ]);
    }
    
    public function getNextPostName()
    {
        $blogPost = Blog::where('status', '=', '1')
                ->where('id', '>', $this->id)
                ->first();
        
        if (!isset($blogPost->id)) {
            return 'NO MORE BLOGS';
        }
        
        return $blogPost->name;
    }
    
    
    
    public function getPreviousPost()
    {
        $blogPost = Blog::where('status', '=', '1')
                ->where('id', '<', $this->id)
                ->orderBy('id','desc')->first();
        
        if (!isset($blogPost->id)) {
            return 404;
        }
        
        return route('front.blogs.single', [
            
            'blog' => $blogPost->id,
        ]); 
    }
    
    public function getPreviousPostName()
    {
        $blogPost = Blog::where('status', '=', '1')
                ->where('id', '<', $this->id)
                ->first();
        
        if (!isset($blogPost->id)) {
            return 'NO MORE BLOGS';
        }
        
        return $blogPost->name;
    }
    
    public function getCategoryUrl()
    {
        return route('front.blogs.category', [
            
            'category' => $this->blog_post_category_id,
        ]);
    }
    
    public function getAuthorUrl()
    {
        return route('front.blogs.author', [
            
            'author' => $this->blog_post_user_id,
            'seoSlug' => \Str::slug($this->users->name)
        ]);
    }
    
    public function getTagUrl()
    {
        return route('front.blogs.tag', [
            
            'tag' => $this->blog_post_tags->tag_id,
        ]);
    }


    public function getPhoto1Url()
    {
        if ($this->photo1) {
                return url('/storage/blog_posts/' . $this->photo1);
        }
		
        return url('/themes/front/img/blog-post-1.jpeg');
    }
    
    
    public function deletePhoto1()
    {
        if (!$this->photo1) {
            return $this;
        }
        
        $photoFilePath = public_path('/storage/blog_posts/' . $this->photo1);
        
        if (!is_file($photoFilePath)) {
            //informacija postoji u bazi ali ga nema na disku
            return $this;
        }
        
        unlink($photoFilePath);
        return $this;
    }
    
    public function getPhoto1ThumbUrl()
	{
		
        if ($this->photo2) {
                return url('/storage/blog_posts/thumbs/' . $this->photo2);
        }

        return url('/themes/front/img/small-thumbnail-1.jpg');
	}
        
    public function deletePhoto2()
    {
        if (!$this->photo2) {
            return $this;
        }
        
        $photoFilePath = public_path('/storage/blog_posts/thumbs/' . $this->photo2);
        
        if (!is_file($photoFilePath)) {
            //informacija postoji u bazi ali ga nema na disku
            return $this;
        }
        
        unlink($photoFilePath);
        return $this;
    }
    
    public function deletePhoto($photoFieldName)
    {
        switch($photoFieldName){
            case 'photo1':
                $this->deletePhoto1();
                break;
            case 'photo2':
                $this->deletePhoto2();
                break;
        }
        return $this;
    }
    
    public function getPhotoUrl($photoFieldName)
    {
        switch($photoFieldName){
            case 'photo1':
                return $this->getPhoto1Url();
            case 'photo2':
                return $this->getPhoto1ThumbUrl();
        }
        return url('/themes/front/img/small-thumbnail-1.jpg');
    }


    public function incrementReadCount() {
        $this->views++;
        return $this->save();
    }
}
