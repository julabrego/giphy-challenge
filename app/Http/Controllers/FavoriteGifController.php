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

    public function save(Request $request): FavoriteGif | \Illuminate\Http\JsonResponse
    {
        try {
            return $this->favoriteGifService->create($request->input('gif_id'), $request->input('alias'), Auth::user()->id);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }
    }
}
