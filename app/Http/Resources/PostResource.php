<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if($this->user->photographer->profileImage_id != null){
            return [
                "id"=>$this->id,
                "title"=>$this->title,
                "description"=>$this->description,
                "post_image"=>$this->image->path,
                "post_type"=>$this->post_type,
                "user"=>[
                    "first_name"=>$this->user->first_name,
                    "last_name"=>$this->user->last_name,
                    "id"=>$this->user->id,
                    "username"=>$this->user->username,
                    "portfolio"=>$this->user->photographer->speciality,
                    "profile"=>$this->user->photographer->profile_image->path
                ]
            ];
        }
        else if($this->user->photographer->profileImage_id == null){
            return [
                "id"=>$this->id,
                "title"=>$this->title,
                "description"=>$this->description,
                "post_image"=>$this->image->path,
                "post_type"=>$this->post_type,
                "user"=>[
                    "first_name"=>$this->user->first_name,
                    "last_name"=>$this->user->last_name,
                    "id"=>$this->user->id,
                    "username"=>$this->user->username,
                    "portfolio"=>$this->user->photographer->speciality,
                    "profile"=>null,
                ]
            ];
        }
    }
}
