<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = ['commentor_id','comment'];

    public function getCreatedAtAttribute($value)
    {
        return date("d F Y H:i", strtotime($value));
    }

    public function BlogPost(){
        return $this->belongsTo(BlogPost::class);
    }

    public function commentor(){
        return $this->belongsTo(User::class);
    }
}
