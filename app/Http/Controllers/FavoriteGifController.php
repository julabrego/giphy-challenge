<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\FavoriteGifService;
use Illuminate\Support\Facades\Auth;

class FavoriteGifController extends Controller
{
    protected $favoriteGifService;

    public function __construct(FavoriteGifService $favoriteGifService)
    {
        $this->favoriteGifService = $favoriteGifService;
    }

    public function save(Request $request)
    {
        $userId = Auth::user()->id;
        $response = $this->favoriteGifService->create($request->input('gif_id'), $request->input('alias'), $userId);
        return $response;
    }
}
