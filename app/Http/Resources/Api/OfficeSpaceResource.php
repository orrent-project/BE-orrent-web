<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OfficeSpaceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'slug'=>$this->slug,
            'duration'=>$this->duration,
            'price'=>$this->price,
            'thumbnail'=>$this->thumbnail,
            'about'=>$this->about,
            'address'=>$this->address,
            'city'=>new CityResource($this->whenLoaded('city')), //karena belongsTo pada city, maka pakai new
            'photos'=>OfficeSpacePhotoResource::collection($this->whenLoaded('photos')), //karena hasMany pada photos, maka pakai collection
            'benefits'=>OfficeSpaceBenefitResource::collection($this->whenLoaded('benefits')), //karena hasMany pada benefits, maka pakai collection
        ];
    }
}
