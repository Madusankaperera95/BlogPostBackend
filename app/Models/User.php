<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Traits\ImagesTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable,HasApiTokens,ImagesTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'picture'
    ];

    protected $casts = [
        'is_private' => 'boolean'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function getPictureAttribute($value){
        return $this->getImageUrl($value);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function blogPosts(){
        return $this->hasMany(BlogPost::class,'author_id');
    }

    public function likes(){
        return $this->hasMany(Like::class,'liker_id');
    }

    public function comments(){
        return $this->hasManyThrough(Comment::class,BlogPost::class,'author_id','blog_post_id','id','id');
    }
}
