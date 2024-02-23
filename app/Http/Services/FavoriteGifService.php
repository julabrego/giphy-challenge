<?php

namespace App\Http\Services;

use App\Repositories\FavoriteGifRepository;
use App\Models\FavoriteGif;
use App\Http\Services\GiphyAPIService;

class FavoriteGifService
{
    protected $favoriteGifRepository;
    protected $giphyAPIService;

    public function __construct(FavoriteGifRepository $favoriteGifRepository, GiphyAPIService $giphyAPIService)
    {
        $this->favoriteGifRepository = $favoriteGifRepository;
        $this->giphyAPIService = $giphyAPIService;
    }

    public function create(string $gifId, string $alias, int $userId): FavoriteGif
    {
        if ($this->favoriteGifRepository->exists($gifId, $userId)) {
            throw new \Exception('The user has already saved the gif');
        }

        if ($this->giphyAPIService->searchById($gifId) === []) {
            throw new \Exception('Gif not found');
        }

        return $this->favoriteGifRepository->create($gifId, $alias, $userId);
    }
}
