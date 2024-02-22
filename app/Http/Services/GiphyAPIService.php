<?php

namespace App\Http\Services;

use App\Http\Adapters\GiphyApiAdapterInterface;
use Illuminate\Support\Facades\Http;

class GiphyAPIService implements GiphyApiAdapterInterface
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

    public function searchById(int $id)
    {
        return response('Not implemented');
    }

    public function save(int $id, string $alias, int $userId)
    {
        return response('Not implemented');
    }
}
