<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NewUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=>$this->id,
            "first_name"=>$this->first_name,
            "last_name"=> $this->last_name,
            "email"=> $this->email,
            "username"=>$this->username,
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
}
