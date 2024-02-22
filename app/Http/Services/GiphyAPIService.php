<?php

namespace App\Http\Services;

use App\Interfaces\GiphyApiRequestsInterface;
use Illuminate\Support\Facades\Http;

class GiphyAPIService
{
    private $baseUrl;
    private $apiKey;

    public function __construct(string $apiKey)
    {
        $this->baseUrl = 'https://api.giphy.com/v1/gifs/';
        $this->apiKey = $apiKey;
    }

    public function search(string $query, int $limit = 10, int $offset = 0)
    {
        $queryString = "search?q={$query}&api_key={$this->apiKey}&limit={$limit}&offset={$offset}";

        $target = $this->baseUrl . $queryString;
        $response = Http::get(urlencode($target));

        return $response->json();
    }

    public function searchById(int $id)
    {
        return response('Not implemented');
    }

    public function save(int $id, string $alias, int $userId)
    {
        return response('Not implemented');
    }
}
