<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MovieResource extends JsonResource
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
            'desc' => $this->desc,
            'publish_status' => $this->publish_status,
            'movie_top' => $this->movie_top,
            'movie_recommend' => $this->movie_recommend,
            'movie_hot' => $this->movie_hot,
            'sort' => $this->sort,
            'published_at' => $this->published_at,
            'view_num' => $this->view_num,
            'score' => $this->score,
        ];
    }
}
