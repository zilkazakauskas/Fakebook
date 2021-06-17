<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'image',
        'content',
    ];

    public function likesCount()
    {
        return $this->hasMany(Like::class)->count();
    }

    public function commentsCount()
    {
        return $this->hasMany(Comment::class)->count();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
