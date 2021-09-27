<?php

use Illuminate\Support\Facades\Route;

/*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register web routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | contains the "web" middleware group. Now create something great!
  |
 */

Route::namespace('App\Http\Controllers')->group(function () {

    Route::get('/', 'IndexController@index')->name('front.index.index');
    Route::get('/slider', 'IndexController@slider')->name('front.index.top_slider');

    Route::prefix('/blogs')->group(function() {
        Route::get('/', 'BlogsController@index')->name('front.blogs.index');
        Route::get('/single/{blog}/{seoSlug?}', 'BlogsController@single')->name('front.blogs.single');
        Route::get('/categories/{category}/{seoSlug?}', 'BlogsController@category')->name('front.blogs.category');
        Route::get('/authors/{author}/{seoSlug?}', 'BlogsController@author')->name('front.blogs.author');
        Route::get('/tags/{tag}/{seoSlug?}', 'BlogsController@tag')->name('front.blogs.tag');
        Route::get('/search', 'BlogsController@search')->name('front.blogs.search');

        Route::get('/comments', 'CommentsController@index')->name('front.blogs.partials.comments.index');

        Route::get('/comments/content', 'CommentsController@content')->name('front.blogs.partials.comments.content');
        Route::get('/comments/add', 'CommentsController@add')->name('front.blogs.partials.comments.add');
        Route::post('/comments/insert', 'CommentsController@insert')->name('front.blogs.partials.comments.insert');
    });

    Route::get('/contact', 'ContactController@index')->name('front.contact.index');
    Route::post('/contact/send-message', 'ContactController@sendMessage')->name('front.contact.send_message');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Auth::routes();

//Middleware primjenjen na sve rute u adminu
Route::middleware('auth')->prefix('/admin')->namespace('App\Http\Controllers\Admin')->group(function () {

    Route::get('/', 'IndexController@index')->name('admin.index.index');

    //Rute za TagsController
    Route::prefix('/tags')->group(function () {

        Route::get('/', 'TagsController@index')->name('admin.tags.index');
        Route::get('/add', 'TagsController@add')->name('admin.tags.add');
        Route::post('/insert', 'TagsController@insert')->name('admin.tags.insert');

        Route::get('/edit/{tag}', 'TagsController@edit')->name('admin.tags.edit');
        Route::post('/update/{tag}', 'TagsController@update')->name('admin.tags.update');

        Route::post('/delete', 'TagsController@delete')->name('admin.tags.delete');
    });

    //Rute za BlogPostCategoriesController
    Route::prefix('/blog-post-categories')->group(function () {

        Route::get('/', 'BlogPostCategoriesController@index')->name('admin.blog_post_categories.index');
        Route::get('/add', 'BlogPostCategoriesController@add')->name('admin.blog_post_categories.add');
        Route::post('/insert', 'BlogPostCategoriesController@insert')->name('admin.blog_post_categories.insert');

        Route::get('/edit/{blogPostCategory}', 'BlogPostCategoriesController@edit')->name('admin.blog_post_categories.edit');
        Route::post('/update/{blogPostCategory}', 'BlogPostCategoriesController@update')->name('admin.blog_post_categories.update');

        Route::post('/delete', 'BlogPostCategoriesController@delete')->name('admin.blog_post_categories.delete');

        Route::post('/change-priorities', 'BlogPostCategoriesController@changePriorities')->name('admin.blog_post_categories.change_priorities');
    });

    //Rute za BlogPostsController
    Route::prefix('/blog-posts')->group(function () {

        Route::get('/', 'BlogPostsController@index')->name('admin.blog_posts.index');
        Route::get('/add', 'BlogPostsController@add')->name('admin.blog_posts.add');
        Route::post('/insert', 'BlogPostsController@insert')->name('admin.blog_posts.insert');

        Route::get('/edit/{blogPost}', 'BlogPostsController@edit')->name('admin.blog_posts.edit');
        Route::post('/update/{blogPost}', 'BlogPostsController@update')->name('admin.blog_posts.update');

        Route::post('/delete', 'BlogPostsController@delete')->name('admin.blog_posts.delete');
        Route::post('/delete-photo/{blogPost}', 'BlogPostsController@deletePhoto')->name('admin.blog_posts.delete_photo');

        Route::post('/datatable', 'BlogPostsController@datatable')->name('admin.blog_posts.datatable');

        Route::post('/change-status', 'BlogPostsController@changeStatus')->name('admin.blog_posts.change_status');
        Route::post('/importance', 'BlogPostsController@importance')->name('admin.blog_posts.importance');
    });

    //Rute za UsersController
    Route::prefix('/users')->group(function () {

        Route::get('/', 'UsersController@index')->name('admin.users.index');
        Route::get('/add', 'UsersController@add')->name('admin.users.add');
        Route::post('/insert', 'UsersController@insert')->name('admin.users.insert');

        Route::get('/edit/{user}', 'UsersController@edit')->name('admin.users.edit');
        Route::post('/update/{user}', 'UsersController@update')->name('admin.users.update');

        Route::post('/delete', 'UsersController@delete')->name('admin.users.delete');

        Route::post('/change-status', 'UsersController@changeStatus')->name('admin.users.change_status');
        Route::post('/delete-photo/{user}', 'UsersController@deletePhoto')->name('admin.users.delete_photo');

        Route::post('/datatable', 'UsersController@datatable')->name('admin.users.datatable');
    });

    //Rute za ProfileController
    Route::prefix('/profile')->group(function () {


        Route::get('/edit', 'ProfileController@edit')->name('admin.profile.edit');
        Route::post('/update', 'ProfileController@update')->name('admin.profile.update');

        Route::post('/delete-photo', 'ProfileController@deletePhoto')->name('admin.profile.delete_photo');

        Route::get('/change-password', 'ProfileController@changePassword')->name('admin.profile.change_password');
        Route::post('/change-password', 'ProfileController@changePasswordConfirm')->name('admin.profile.change_password_confirm');
    });
    
    //Rute za SlidersController
    Route::prefix('/sliders')->group(function () {

        Route::get('/', 'SlidersController@index')->name('admin.sliders.index');
        Route::get('/add', 'SlidersController@add')->name('admin.sliders.add');
        Route::post('/insert', 'SlidersController@insert')->name('admin.sliders.insert');

        Route::get('/edit/{slider}', 'SlidersController@edit')->name('admin.sliders.edit');
        Route::post('/update/{slider}', 'SlidersController@update')->name('admin.sliders.update');

        Route::post('/delete', 'SlidersController@delete')->name('admin.sliders.delete');
        Route::post('/delete-photo/{slider}', 'SlidersController@deletePhoto')->name('admin.sliders.delete_photo');
        
        Route::post('/change-priorities', 'SlidersController@changePriorities')->name('admin.sliders.change_priorities');
        
        Route::post('/change-status', 'SlidersController@changeStatus')->name('admin.sliders.change_status');
    });
    
    //Rute za CommentsController
    Route::prefix('/comments')->group(function () {


        Route::get('/', 'CommentsController@index')->name('admin.comments.index');
        
        Route::post('/change-status', 'CommentsController@changeStatus')->name('admin.comments.change_status');
        
        Route::post('/datatable', 'CommentsController@datatable')->name('admin.comments.datatable');
    });
    
});
