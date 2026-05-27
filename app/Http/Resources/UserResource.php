<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if($this->user_type=="photographer"){
        if($this->photographer->profileImage_id == null && $this->photographer->bigprofileImage_id == null){
            
                return [
                "id"=>$this->id,
                "first_name"=>$this->first_name,
                "last_name"=> $this->last_name,
                "email"=> $this->email,
                "username"=>$this->username,
                "user_type"=>$this->user_type,
                "photographer" =>[
                    "location" =>$this->photographer->location,
                    "instagram" =>$this->photographer->instagram,
                    "bio" =>$this->photographer->bio,
                    "speciality" =>$this->photographer->speciality,
                    "phone"=>$this->photographer->phone,
                    'profile_image'=>null,
                    "big_profile_image"=>null
                 ]
               ];
              
            }
            else if($this->photographer->profileImage_id !=null && $this->photographer->bigprofileImage_id != null){
                return [
                    "id"=>$this->id,
                    "first_name"=>$this->first_name,
                    "last_name"=> $this->last_name,
                    "email"=> $this->email,
                    "username"=>$this->username,
                    "user_type"=>$this->user_type,
                    "photographer" =>[
                        "location" =>$this->photographer->location,
                        "instagram" =>$this->photographer->instagram,
                        "bio" =>$this->photographer->bio,
                        "speciality" =>$this->photographer->speciality,
                        "phone"=>$this->photographer->phone,
                        'profile_image'=>$this->photographer->profile_image->path,
                        "big_profile_image"=>$this->photographer->bigprofile_image->path,
                    ]
                ];
            }
            else if($this->photographer->profileImage_id == null && $this->photographer->bigprofileImage_id != null){
                return [
                    "id"=>$this->id,
                    "first_name"=>$this->first_name,
                    "last_name"=> $this->last_name,
                    "email"=> $this->email,
                    "username"=>$this->username,
                    "user_type"=>$this->user_type,
                    "photographer" =>[
                        "location" =>$this->photographer->location,
                        "instagram" =>$this->photographer->instagram,
                        "bio" =>$this->photographer->bio,
                        "speciality" =>$this->photographer->speciality,
                        "phone"=>$this->photographer->phone,
                        'profile_image'=>null,
                        "big_profile_image"=>$this->photographer->bigprofile_image->path,
                
                        ]
                ];
            }
            else if($this->photographer->profileImage_id != null  && $this->photographer->bigprofileImage_id == null){
               return [
                    "id"=>$this->id,
                    "first_name"=>$this->first_name,
                    "last_name"=> $this->last_name,
                    "email"=> $this->email,
                    "username"=>$this->username,
                    "user_type"=>$this->user_type,
                    "photographer" =>[
                        "location" =>$this->photographer->location,
                        "instagram" =>$this->photographer->instagram,
                        "bio" =>$this->photographer->bio,
                        "speciality" =>$this->photographer->speciality,
                        "phone"=>$this->photographer->phone,
                        'profile_image'=>$this->photographer->profile_image->path,
                        "big_profile_image"=>null
                        ]
               ];
            }
         }
        else if($this->user_type=="client"){
              return [
                "id"=>$this->id,
                "first_name"=>$this->first_name,
                "last_name"=> $this->last_name,
                "email"=> $this->email,
                "username"=>$this->username,
                "user_type"=>$this->user_type,
                "client" =>[
                    "location" =>$this->client->location,
                    "phone"=>$this->client->phone,
                 ]
               ];
        }
    }
}
