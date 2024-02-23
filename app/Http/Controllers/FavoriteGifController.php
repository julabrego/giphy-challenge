<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\FavoriteGifService;
use Illuminate\Support\Facades\Auth;
use App\Models\FavoriteGif;

class FavoriteGifController extends Controller
{
    protected $favoriteGifService;

    public function __construct(FavoriteGifService $favoriteGifService)
    {
        $this->favoriteGifService = $favoriteGifService;
    }

    public function save(Request $request): FavoriteGif
    {
        return $this->favoriteGifService->create($request->input('gif_id'), $request->input('alias'), Auth::user()->id);
    }
}
