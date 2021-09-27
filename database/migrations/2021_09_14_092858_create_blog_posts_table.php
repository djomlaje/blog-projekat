<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 255)->comment('Blog Post Title');
            $table->string('description')->nullable();
            $table->longText('details')->comment('Blog Post Body')->nullable();
            $table->bigInteger('blog_post_category_id');
            $table->bigInteger('blog_post_user_id');
            $table->tinyInteger('important')->default(1);
            $table->tinyInteger('status')->comment('1 - enabled, 0 - disabled')->default(0);
            $table->string('photo1')->comment('Regular photo')->nullable();
            $table->string('photo2')->comment('Thumb photo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blog_posts');
    }
}
