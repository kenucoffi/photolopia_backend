<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\GetPostResource;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $user = Auth::user();
        $post =new Post();
        if($user){
            $id = $user->id;            
            if($request->hasFile("image")){
                $image_name =$request->file("image")->store("/","public");
                $image_path = "uploads/".$image_name;
                $image_id =$post->image()->create(["path"=>$image_path]);
            }
            $post->post_image_id = $image_id->id;
            $post->title = $request->title;
            $post->description= $request->description;
            $post->post_type=$request->post_type;
            $post->user_id = $id;
            $post->save();
            return response(["message"=>"post successfuly created"],201);
        }
        else{
            return response(["message"=>"unauthorize "],401);
        }


    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $user = Auth::user();
        if($user){
            $post = Post::find($id)->first();

            $image = $post->image->path;
            File::delete(public_path($image));
            if($request->hasFile("image")){
                $file_name = $request->file("image")->store("/","public");
                $file_path = "uploads/".$file_name;
                $post->image()->create(["path"=>$file_path]);

            }
            $post->title = $request->title;
            $post->description = $request->description;
            $post->post_type = $request->post_type;
            $post->user_id = $id;
            $post->save();
            return response()->json(["message"=>"successfuly updated"],200);
        }
        else{
            return response(["message"=>"unauthorized"],401);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $user = Auth::user();
        if($user){
            $post = Post::find($id)->first();
            $image = $post->image->path;
            File::delete(public_path($image));
            $post->delete();
            return response(["success"=>"the post delete successfuly"],200);
        }
        else{
            return response(["message"=>"unauthorized"],401);
        }


    }
}
