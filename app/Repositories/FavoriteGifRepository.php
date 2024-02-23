<?php

namespace App\Repositories;

use App\Models\FavoriteGif;

class FavoriteGifRepository
{
    protected $favoriteGif;
    public function __construct(FavoriteGif $favoriteGif)
    {
        $this->favoriteGif = $favoriteGif;
    }

    public function create(string $gifId, string $alias, int $userId): FavoriteGif
    {
        return $this->favoriteGif->create([
            'gif_id' => $gifId,
            'alias' => $alias,
            'user_id' => $userId
        ]);
    }
}
