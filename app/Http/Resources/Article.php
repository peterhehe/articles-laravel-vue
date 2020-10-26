<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Article extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data = [];
        $tags = [];
        foreach ($this->tags as $articleTag) {
            $tags[] = $articleTag->tag;
        }
        $data = [
            'data' =>[
                "id"            => $this->id,
                "type"          => 'article',
                "attributes"    => [
                    "title"             => $this->title,
                    "photo"             => $this->photo,
                    "content"           => $this->content,
                    "tags"              => $tags,
                    "created_at"        => $this->created_at->format('Y-m-d H:i:s'),
                    "updated_at"        => $this->updated_at->format('Y-m-d H:i:s'),
                    "published_at"      => optional($this->published_at)->format('Y-m-d H:i:s'),
                    'slugcase'         => str_replace(' ', '-', strtolower($this->title))
                ]
            ]
        ];

        return $data;
    }
}
