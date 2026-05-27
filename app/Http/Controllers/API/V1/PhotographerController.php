<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\PhotographerRequest;
use App\Http\Resources\GetPhotographerResource;
use App\Http\Resources\PhotographerResource;
use App\Models\Image;
use App\Models\Photographer;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class PhotographerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $photographer =  Photographer::all();
        return  GetPhotographerResource::collection($photographer);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $photographer =  Photographer::where("user_id" ,"=",$id)->first();
        return new PhotographerResource($photographer);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

            $photographer = Photographer::where("user_id","=",$id)->firstOrFail();
            if($request->hasFile("profile_image") ){
               if($photographer->profileImage_id != null){
                   File::delete(public_path($photographer->profile_image->path));
                   $photographer->profile_image()->delete();
               }

               $profileimage_name =$request->file("profile_image")->store("/","public");
               $profile = $photographer->profile_image()->create([
                "path"=>"uploads/".$profileimage_name
               ]);
               $photographer->profileImage_id = $profile->id;

            }
            if($request->hasFile("big_profile_image")){
                if($photographer->bigprofileImage_id != null){
                    File::delete(public_path($photographer->bigprofile_image->path));
                    $photographer->bigprofile_image()->delete();

                }
                $bigprofile_name = $request->file("big_profile_image")->store("/","public");
                $bigprofile = $photographer->bigprofile_image()->create([
                    "path"=>"uploads/".$bigprofile_name
                ]);
                $photographer->bigprofileImage_id = $bigprofile->id;

            }
            $photographer->bio = $request->bio;
            $photographer->speciality = $request->speciality;
            $photographer->phone = $request->phone;
            $photographer->instagram = $request->instagram;
            $photographer->location = $request->location;
            $photographer->save();

            return response()->json($photographer,201);
        
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
