<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    use HasFactory;
    protected $guarded = [];  
    protected $table = "comments";

    public function author()
    {
        return $this->belongsTo('App\Models\User','from_user','id');
    }

    public function post()
    {
        return $this->belongsTo('App\Models\Posts','on_post','id');
    }
}
