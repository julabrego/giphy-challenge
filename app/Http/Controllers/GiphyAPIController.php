<?php

namespace App\Http\Controllers;

use App\Http\Adapters\GiphyAPIAdapter;
use Illuminate\Http\Request;

class GiphyAPIController extends Controller
{
    private $giphyAPIAdapter;

    public function __construct(GiphyAPIAdapter $giphyAPIAdapter)
    {
        $this->giphyAPIAdapter = $giphyAPIAdapter;
    }

    public function search(Request $request)
    {
        $response = $this->giphyAPIAdapter->search($request->q, $request->limit, $request->offset);

        return $response;
    }

    public function searchById(string $id)
    {
        $response = $this->giphyAPIAdapter->searchById($id);

        return $response;
    }
}
