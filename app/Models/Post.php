<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //
    function user(){
        return $this->belongsTo(User::class,"user_id","id");
    }
    function image(){
        return $this->hasOne(Image::class,"id","post_image_id");
    }
    protected $fillable  = ["title","description","post_type"];
}
