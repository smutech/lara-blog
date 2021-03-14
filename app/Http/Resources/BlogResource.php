<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
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
            'slug' => $this->slug,
            'uri' => route('show-blog', $this->slug),
            'title' => $this->title,
            $this->mergeWhen($request->body, [
                'body' => $this->body,
            ]),
            'user' => new UserResource($this->user),
            'view_count' => $this->view_count,
            'created_at' => $this->created_at->diffForHumans(),
            'updated_at' => $this->updated_at->diffForHumans(),
        ];
    }
}
