<?php

namespace App\Models;

use App\Traits\ImagesTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    use HasFactory;
    use ImagesTrait;

    protected  $fillable = ['title','description','author_id','category_id','tags','post_image','slug'];
    protected $casts = [
        'created_at'  => 'date:m-d-Y'
    ];


    public function getPostImageAttribute($value): string
    {

        return $this->getImageUrl($value);
    }
    public function author()
    {
        return $this->belongsTo(User::class);
    }

    public  function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function likes(){
        return $this->hasMany(Like::class);
    }


}
