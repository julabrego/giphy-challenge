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
        return $this->giphyAPIAdapter->search($request->q, $request->limit, $request->offset);
    }

    public function searchById(string $id)
    {
        return $this->giphyAPIAdapter->searchById($id);
    }
}
