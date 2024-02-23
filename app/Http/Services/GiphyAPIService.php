<?php

namespace App\Http\Services;

use App\Http\Adapters\GiphyAPIAdapterInterface;
use Illuminate\Support\Facades\Http;

class GiphyAPIService implements GiphyAPIAdapterInterface
{
    private $baseUrl;
    private $apiKey;

    public function __construct(string $apiKey)
    {
        $this->baseUrl = 'https://api.giphy.com/v1/gifs/';
        $this->apiKey = $apiKey;
    }

    public function search(string $q, ?int $limit = null, ?int $offset = null)
    {
        $queryParams = http_build_query(['q' => $q, 'limit' => $limit, 'offset' => $offset]);
        $queryString = "search?api_key={$this->apiKey}&{$queryParams}";

        $target = $this->baseUrl . $queryString;
        $response = Http::get($target);

        return $response->json();
    }

    public function searchById(string $id)
    {
        $target = $this->baseUrl . "{$id}?api_key={$this->apiKey}";
        $response = Http::get($target);

        return $response->json();
    }
}
