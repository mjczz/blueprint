<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DemoUserResource extends JsonResource
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
            'title' => $this->title,
            'user_name' => $this->user->name,
            'desc' => $this->desc,
            'publish_status' => $this->publish_status,
            'demo_top' => $this->demo_top,
            'demo_recommend' => $this->demo_recommend,
            'sort' => $this->sort,
            'demo_score' => $this->demo_score,
            'published_at' => $this->published_at,
            'created_at' => $this->created_at,
            'published_at' => $this->published_at,
        ];
    }
}
