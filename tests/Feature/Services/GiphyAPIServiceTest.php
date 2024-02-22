<?php

namespace Tests\Feature\Services;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Http\Services\GiphyAPIService;
use Illuminate\Support\Facades\Http;

class GiphyAPIServiceTest extends TestCase
{
    private $giphyAPIService;

    public function test_request_should_send_a_request_to_the_giphy_api_passing_the_correct_parameters(): void
    {

        $apiKey = 'testKey123';
        $query = 'example query';
        $limit = 10;
        $offset = 0;

        $this->giphyAPIService = new GiphyAPIService($apiKey);

        $expectedResponse = [
            'data' => ['fake_response' => true]
        ];

        $target = urlencode("https://api.giphy.com/v1/gifs/search?q={$query}&api_key={$apiKey}&limit={$limit}&offset={$offset}");

        Http::fake([
            $target => Http::response($expectedResponse, 200)
        ]);

        $response = $this->giphyAPIService->search($query, $limit, $offset);

        $this->assertEquals($expectedResponse, $response);
    }
}
