<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\GetPhotographerResource;
use App\Http\Resources\GetPostResource;
use App\Models\Photographer;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class SearchAndFilterController extends Controller
{
    function search(Request $request){
        $photographer = Photographer::when($request->search ,function($query) use ($request){
        $query->where("speciality" ,"LIKE","%$request->search%")
        ->orWhere("location","LIKE","%$request->search%")
        ->orWhere("phone","LIKE","%$request->search%")
        ->orWhere("instagram","LIKE","%$request->search%");

        })->orWhereHas("user",function($query) use ($request){
        $query->where("first_name","LIKE","%$request->search%")
            ->orWhere("last_name","LIKE","%$request->search%")
            ->orWhere("email","LIKE","$request->search%");
            })->get();


        return GetPhotographerResource::collection($photographer);

    }
    function post_search(Request $request,string $id){
        $post = Post::where("user_id","=",$id)->where("title","LIKE","%{$request->title}%")->get();
        return GetPostResource::collection($post);

    }
    

}
