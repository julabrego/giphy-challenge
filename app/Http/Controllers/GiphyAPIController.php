<?php

namespace App\Http\Controllers;

use App\Http\Adapters\GiphyAPIAdapter;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class GiphyAPIController extends Controller
{
    private $giphyAPIAdapter;

    public function __construct(GiphyAPIAdapter $giphyAPIAdapter)
    {
        $this->giphyAPIAdapter = $giphyAPIAdapter;
    }

    public function search(Request $request)
    {
        try {
            return $this->giphyAPIAdapter->search($request->q, $request->limit, $request->offset);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }
    }

    public function searchById(string $id)
    {
        try {
            return $this->giphyAPIAdapter->searchById($id);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }
    }
}
