<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Photographer;
use App\Models\Client;
use App\Models\Post;
class User extends Authenticatable
{
    use HasFactory, Notifiable , HasApiTokens;

    function photographer(){
        return $this->hasOne(Photographer::class,"user_id","id");
    }
    function client(){
        return $this->hasOne(Client::class,"user_id","id");
    }
    function post(){
        return $this->hasMany(Post::class,"user_id","id");
    }
    function follower(){
        return $this->hasMany(Follower::class,"follower_user_id","id");
    }
    function following(){
        return $this->hasMany(Follower::class,"following_user_id","id");
    }




    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        "user_type",
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
}
