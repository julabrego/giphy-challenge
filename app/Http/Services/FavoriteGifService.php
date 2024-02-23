<?php

namespace App\Http\Services;

use App\Repositories\FavoriteGifRepository;
use App\Models\FavoriteGif;

class FavoriteGifService
{
    protected $favoriteGifRepository;

    public function __construct(FavoriteGifRepository $favoriteGifRepository)
    {
        $this->favoriteGifRepository = $favoriteGifRepository;
    }

    public function create(string $gifId, string $alias, int $userId): FavoriteGif
    {
        if ($this->favoriteGifRepository->exists($gifId, $userId)) {
            throw new \Exception('The user has already saved the gif');
        }

        return $this->favoriteGifRepository->create($gifId, $alias, $userId);
    }
}
