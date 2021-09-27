<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable {

    use HasApiTokens,
        HasFactory,
        Notifiable;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function blogPosts() {
        return $this->hasMany(
                        Blog::class,
                        'blog_post_user_id',
                        'id'
        ); //vraca query builder
    }

    public function getPhotoUrl() {
        if ($this->photo) {
            return url('/storage/users/' . $this->photo);
        }

        return url('/themes/admin/dist/img/avatar3.png');
    }

    public function deletePhoto() {
        if (!$this->photo) {
            return $this;
        }

        $photoPath = public_path('/storage/users/' . $this->photo);

        if (is_file($photoPath)) {
            unlink($photoPath);
        }

        return $this;
    }

}
