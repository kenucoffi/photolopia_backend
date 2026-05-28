<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\Client;
use App\Models\Photographer;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\EditPhotographerResource;
use App\Http\Resources\NewUserResource;
use App\Http\Resources\SuggestResource;
use App\Http\Resources\UserDataResource;
use App\Http\Resources\BasicInfoResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserResource2;
use App\Http\Resources\UserResource3;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{
    function store(UserRequest $request){
        $user = new User();
        $user->username = $request->username;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->user_type = $request->user_type;
        $user->save();
        if ($user->user_type == "photographer"){
            $photographer = new Photographer();
            $photographer->user_id = $user->id;
            $photographer->save();
        }
        else if($user->user_type == "client"){
            $client = new Client();
            $client->user_id = $user->id;
            $client->save();
        }
        return response()->json(["message"=>"created successfuly"],201);
    }
    function login(Request $request){
         $userLog = Auth::attempt($request->only("email","password"));
         if($userLog ){
            $user = Auth::user();
            $token = $user->createToken("auth_token")->plainTextToken;

            return response()->json([
                "success"=>True,
                "data"=>[
                   "token" =>$token,
                   "user" => $user,
                   ],
                "message"=>"successfuly logedin"
            ],200);
         }
         else {
           return response()->json(["message"=>"your password or email is not correct"],404);
         }

    }
    function logout(Request $request){
        if ($request->user()->currentAccessToken() instanceof \Laravel\Sanctum\PersonalAccessToken) {
            $request->user()->currentAccessToken()->delete();
        }
        else {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }
        return response()->json(['message' => 'Logged out']);

    }
    function userdata(){
        $user = Auth::user();
        return new UserDataResource($user);
    }
    function userprofile(){

          $user = Auth::user();
          if($user){
            return new UserResource($user);
            
          }
          else{
            return response()->json(["message"=>"unauthorized"],401);
          }
    }
    function editphotographer(string $id){
        $photographer = Photographer::where("user_id","=",$id)->firstOrFail();
        if ($photographer){
            return new EditPhotographerResource($photographer);
        }
        else{
            return response()->json(["message"=>"not authonticated"],401);
        }
    }

    function username_email(Request $request){
        $user = Auth::user();
        $id = $user->id;
        $photographer_user = User::find($id)->first();
        $photographer_user->username = $request->username;
        $photographer_user->email = $request->email;
        $photographer_user->save();
        return response(["message"=>"successfuly update"],200);
    }
    function first_last_name(Request $request){
        $user = Auth::user();
        $id = $user->id;
        $photographer_user = User::find($id)->first();
        $photographer_user->first_name = $request->first_name;
        $photographer_user->last_name = $request->last_name;
        $photographer_user->save();
        return response(["message"=>"successfuly update"],200);
    }
    function speciality(Request $request){
          $user = Auth::user();
        $id = $user->id;
        $photographer_user = User::find($id)->first();
        $photographer_user->photographer()->update(["speciality"=>$request->speciality]);
        $photographer_user->save();
        return response(["message"=>"successfuly update"],200);
    }
    function bio(Request $request){
        $user = Auth::user();
        $id = $user->id;
        $user->photographer()->update(["bio"=>$request->bio]);
        return response(["message"=>"successfuly update"],200);
    }
    function phone_instagram_location(Request $request){
          $user = Auth::user();
        $id = $user->id;
        $photographer_user = User::find($id)->first();
        $photographer_user->photographer()->update(["phone"=>$request->phone,"instagram"=>$request->instagram,"location"=>$request->location]);
        return response(["message"=>"successfuly update"],200);
    }
    function profile_image(Request $request){
        $user = Auth::user();
        $id = $user->id;
        if($request->hasFile("profile_image")){
            if($user->photographer->profileImage_id){
                File::delete(public_path($user->photographer->profile_image->path));
                $store_file = $request->file("profile_image")->store("/","public");
                $file_path ="uploads/".$store_file;
                $user->photographer->profile_image()->update(["path"=>$file_path]);
                return response(["message"=>"profile is successfuly update"],200);
            }
            $store_file = $request->file("profile_image")->store("/","public");
            $file_path ="uploads/".$store_file;
            $photo =$user->photographer->profile_image()->create(["path"=>$file_path]);
            $user->photographer()->update(["profileImage_id"=>$photo->id]);
            return response(["message"=>"successfuly created"],200);
        }
        return response(["error"=>'file is not image']);
    }
    function big_profile_image(Request $request){
        $user = Auth::user();
        $id = $user->id;

        if($request->hasFile("big_profile_image"))
        {
            if($user->photographer->bigprofileImage_id){
                File::delete(public_path($user->photographer->bigprofile_image->path));
                $store_file = $request->file("big_profile_image")->store("/","public");
                $file_path ="uploads/".$store_file;
                $user->photographer->bigprofile_image()->update(["path"=>$file_path]);
                return response()->json(['message'=>'successfuly updated'],200);
            }
            $store_file = $request->file("big_profile_image")->store("/","public");
            $file_path ="uploads/".$store_file;
            $photo=$user->photographer->bigprofile_image()->create(["path"=>$file_path]);
            $user->photographer()->update(["bigprofileImage_id"=>$photo->id]);
            return response()->json(['message'=>'successfuly created'],200);
        }
        return response()->json(['message'=>'not a file']);
    }
    function user_info(Request $request){
        $user = Auth::user();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->username= $request->username;
        $user->email = $request->email;
        $user->photographer()->update(["speciality"=>$request->speciality,"location"=>$request->location,"phone"=> $request->phone,"instagram"=>$request->instagram]);
        $user->save();
        return response(["message"=>"successfuly updated"]);

    }
    function basic_info(){
        $user = Auth::user();
        if($user){
           return new BasicInfoResource($user);
        }
        
    }
    function bio_info(){
        $user = Auth::user();
        $bio = $user->photographer->bio;
        return response()->json(["bio"=>$bio],200);
    }
    function user_basic_info(string $id){
        $user = User::where("id","=",$id)->first();
        if($user){
            return new BasicInfoResource($user);
        }
        else{
            return response()->json(["message"=>"user not found"],200);
        }
        
    }
    function suggest_follow(){
        $user = Auth::user();
        $id = $user->id;
        
        if($user){
            $suggest = User::where("id" ,"!=",$id)->where("user_type","=","photographer")->get();
            return SuggestResource::collection($suggest);
        }
    }
    function client_info_edit(Request $request){
         $user = Auth::user();
         if($user){
              $user->first_name = $request->first_name;
              $user->last_name = $request->last_name;
              $user->email = $request->email;
              $user->username = $request->username;
              $user->client()->update(["location"=>$request->location,"phone"=>$request->phone]);
              $user->save();
              return response()->json(["message"=>"successfuly updated"]);
         }
    }


}
