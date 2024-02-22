<?php

namespace App\Http\Adapters;

use App\DTOs\GifDTO;
use App\Http\Services\GiphyAPIService;

class GiphyAPIAdapter extends GiphyAPIService
{
    protected $giphyAPIService;
    public function __construct(
        GiphyAPIService $giphyAPIService
    ) {
        $this->giphyAPIService = $giphyAPIService;
    }

    // TODO: implement search adaptation

    public function adapt(array $data): GifDTO
    {
        if (!isset($data['id'], $data['url'], $data['title'])) {
            throw new \InvalidArgumentException('The provided data is invalid.');
        }

        return new GifDTO([
            'id' => $data['id'],
            'url' => $data['url'],
            'title' => $data['title'],
        ]);
    }
}
