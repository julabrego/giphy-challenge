<?php

namespace App\DTOs;

class GifDTO
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
}
