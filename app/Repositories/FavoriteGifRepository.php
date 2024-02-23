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

    public function exists(string $gifId, int $userId): bool
    {
        $query =  $this->favoriteGif->where([
            'gif_id' => $gifId,
            'user_id' => $userId
        ]);

        return $query ? $query->exists() : false;
    }
}
