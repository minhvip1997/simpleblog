<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    use HasFactory;
    protected $table = "posts";
    protected $guarded = [];  

    public function comments()
    {
        return $this->hasMany('App\Models\Comment','on_post','id');    
    }

    public function author()
    {
        return $this->belongsTo('App\Models\User','author_id','id');
    }
}
