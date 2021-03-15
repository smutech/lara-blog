<?php

namespace App\Http\Resources;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'username' => $this->username,
            $this->mergeWhen($request->email, [
                'email' => $this->email,
            ]),
            'profile_image' => $this->profile_image == null ? '/assets/images/user placeholder.png' : Storage::url($this->profile_image),
        ];
    }
}
