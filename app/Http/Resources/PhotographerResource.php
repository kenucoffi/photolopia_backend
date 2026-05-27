<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PhotographerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if($this->profileImage_id != null && $this->bigprofileImage_id != null){
        return [
            
            "bio"=>$this->bio,
            "location"=>$this->location,
            "phone"=>$this->phone,
            "instagram"=>$this->instagram,
            "id" => $this->id,
            "user"=>[
                    "last_name"=>$this->user->last_name,
                    "first_name" => $this->user->first_name,
                    "email"=>$this->user->email,
                    "id"=>$this->user->id
                ],
                
            "profile_image"=>$this->profile_image->path,
            "big_profile_image"=>$this->bigprofile_image->path,
            "speciality"=>$this->speciality,
        ];
       }
       else if($this->profileImage_id == null && $this->bigprofileImage_id != null){
        return [
            
            "bio"=>$this->bio,
            "location"=>$this->location,
            "phone"=>$this->phone,
            "instagram"=>$this->instagram,
            "id" => $this->id,
            "user"=>[
                    "last_name"=>$this->user->last_name,
                    "first_name" => $this->user->first_name,
                    "email"=>$this->user->email,
                    "id"=>$this->user->id
                ],
                
            "profile_image"=>null,
            "big_profile_image"=>$this->bigprofile_image->path,
            "speciality"=>$this->speciality,
        ];
       }
       else if($this->profileImage_id != null && $this->bigprofileImage_id == null){
        return [
            
            "bio"=>$this->bio,
            "location"=>$this->location,
            "phone"=>$this->phone,
            "instagram"=>$this->instagram,
            "id" => $this->id,
            "user"=>[
                    "last_name"=>$this->user->last_name,
                    "first_name" => $this->user->first_name,
                    "email"=>$this->user->email,
                    "id"=>$this->user->id
                ],
                
            "profile_image"=>$this->profile_image->path,
            "big_profile_image"=>null,
            "speciality"=>$this->speciality,
        ];
       }
       else if($this->profileImage_id == null && $this->bigprofileImage_id == null){
        return [
            
            "bio"=>$this->bio,
            "location"=>$this->location,
            "phone"=>$this->phone,
            "instagram"=>$this->instagram,
            "id" => $this->id,
            "user"=>[
                    "last_name"=>$this->user->last_name,
                    "first_name" => $this->user->first_name,
                    "email"=>$this->user->email,
                    "id"=>$this->user->id
                ],
                
            "profile_image"=>null,
            "big_profile_image"=>null,
            "speciality"=>$this->speciality,
        ];
       }
    }
}
