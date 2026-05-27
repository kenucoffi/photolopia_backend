<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GetPostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
           "title"=>$this->title,
           "description"=>$this->description,
           "post_type"=>$this->post_type,
           "post_image"=>$this->image->path,
           "id"=>$this->id,

        ];
    }
}
