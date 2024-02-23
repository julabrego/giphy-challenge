<?php

namespace App\Http\Services;

use App\Repositories\FavoriteGifRepository;

class FavoriteGifService
{
    protected $favoriteGifRepository;

    public function __construct(FavoriteGifRepository $favoriteGifRepository)
    {
        $this->favoriteGifRepository = $favoriteGifRepository;
    }

    public function create(string $gifId, string $alias, int $userId)
    {
        return $this->favoriteGifRepository->create($gifId, $alias, $userId);
    }
}
