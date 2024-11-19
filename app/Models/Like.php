<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    protected $casts = [
        'is_liked' => 'boolean'
    ];

    protected $fillable = ['liker_id','blog_post_id','is_liked'];

    public function blogPost(){
        return $this->belongsTo(BlogPost::class);
    }

    public function liker(){
        return $this->belongsTo(User::class);
    }
}
