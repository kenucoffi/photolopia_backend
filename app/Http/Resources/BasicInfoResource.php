<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BasicInfoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if($this->user_type=="photographer"){
           return [
            "first_name" =>$this->first_name,
            "last_name"=>$this->last_name,
            "username"=>$this->username,
            "email"=>$this->email,
            "speciality"=>$this->photographer->speciality,
            "location"=>$this->photographer->location,
            "phone"=>$this->photographer->phone,
            "instagram"=>$this->photographer->instagram
           ];
        }
        else if($this->user_type=="client"){
          return [
            "first_name" =>$this->first_name,
            "last_name"=>$this->last_name,
            "username"=>$this->username,
            "email"=>$this->email,
            "location"=>$this->client->location,
            "phone"=>$this->client->phone,
            
           ];
        }
    }
}
