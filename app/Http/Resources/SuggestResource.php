<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SuggestResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if($this->user_type == "photographer"){
            return [
            "id"=>$this->id,
            "speciality"=>$this->photographer->speciality,
            "name"=>$this->username
        ];
        }
        
        
    }
}
