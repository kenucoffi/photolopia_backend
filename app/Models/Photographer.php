<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class Photographer extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = Str::uuid();
        });
    }
    //
    protected $fillable = ["bio","speciality","instagram","phone","location","user_id","profileImage_id","bigprofileImage_id"];
    public function profile_image(){
        return $this->hasOne(Image::class,"id","profileImage_id");
    }
    public function bigprofile_image(){
        return $this->hasOne(Image::class,"id","bigprofileImage_id");
    }
    public function user(){
        return $this->belongsTo(User::class,"user_id","id");
    }
}
