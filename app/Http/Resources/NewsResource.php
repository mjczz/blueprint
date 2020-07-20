<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NewsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $img_url = env('APP_URL');

        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => preg_replace('/(<img.+?src=")(.*?)/','$1'.$img_url.'$2', $this->content),
            'publish_status' => $this->publish_status,
            'news_top' => $this->news_top,
            'news_recommend' => $this->news_recommend,
            'news_type' => $this->news_type,
            'sort' => $this->sort,
            'published_at' => $this->published_at,
        ];
    }
}
