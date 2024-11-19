<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    use HasFactory;
    protected $fillable = [
        'author_id',
        'commentor_id',
        'is_subscribed'
    ];
    protected $casts = [
        'is_subscribed' => 'boolean'
    ];
}
