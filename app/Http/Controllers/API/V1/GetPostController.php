<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\GetPostResource;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Faker\Core\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GetPostController extends Controller
{
    //
    public function show()
    {
        //
        $user = Auth::user();
        if($user){
            $id = $user->id;
            $post = Post::where("user_id","=",$id)->get();
            return GetPostResource::collection($post);
        }
        else{
            return response(["message"=>"unauthorized"],401);
        }

    }
    public function public_show(string $id){
        $post = Post::where("user_id","=",$id)->orderByDesc("id")->get();
        return GetPostResource::collection($post);
    }
     public function index()
    {
        //
        $post = new Post();
        $post = $post->orderBy("id","desc")->get();
        return PostResource::collection($post);
    }

}
