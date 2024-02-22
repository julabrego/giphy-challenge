<?php

namespace App\Http\Adapters;

use App\DTOs\GifDTO;
use App\Http\Services\GiphyAPIService;
use App\Http\Adapters\GiphyAPIAdapterInterface;

class GiphyAPIAdapter implements GiphyAPIAdapterInterface
{
    protected $giphyAPIService;
    public function __construct(
        GiphyAPIService $giphyAPIService
    ) {
        $this->giphyAPIService = $giphyAPIService;
    }

    public function search(string $q, ?int $limit = null, ?int $offset = null)
    {
        return $this->adaptSearchResponse($this->giphyAPIService->search($q, $limit, $offset));
    }

    public function searchById(string $id)
    {
        try {
            $result = $this->giphyAPIService->searchById($id);

            if (empty($result['data'])) {
                throw new \Illuminate\Database\Eloquent\ModelNotFoundException('GIF not found.', 404);
            }

            return $this->adapt($result['data']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }
    }

    protected function adaptSearchResponse(array $apiResponse): array
    {
        $adaptee = [];

        foreach ($apiResponse['data'] as $gif) {
            $adaptee[] = $this->adapt($gif);
        }

        return $adaptee;
    }

    protected function adapt(array $data): GifDTO
    {
        if (!isset($data['id'], $data['url'], $data['title'])) {
            throw new \InvalidArgumentException('The provided data is invalid.', 400);
        }

        return new GifDTO([
            'id' => $data['id'],
            'url' => $data['url'],
            'title' => $data['title'],
        ]);
    }
}
