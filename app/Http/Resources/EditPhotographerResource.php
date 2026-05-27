<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EditPhotographerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "bio"=>$this->bio,
            "speciality"=>$this->speciality,
            "phone"=>$this->phone,
            "instagram"=>$this->instagram,
            "location"=>$this->location,
            "big_profile_image"=>$this->bigprofile_image->path,
            "profile_image"=>$this->profile_image->path,
            "id"=>$this->id,
        ];
    }
}
