<?php

namespace App\DTOs;

use JsonSerializable;

class GifDTO implements JsonSerializable
{
    private $id;
    private $url;
    private $title;

    public function __construct(array $data)
    {
        $this->id = $data['id'];
        $this->url = $data['url'];
        $this->title = $data['title'];
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'url' => $this->url,
            'title' => $this->title,
        ];
    }
}
