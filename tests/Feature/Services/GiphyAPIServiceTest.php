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

        $exampleParameters = [
            [
                'q' => 'example query 1',
                'limit' => 15,
                'offset' => 0,
            ],
            [
                'q' => 'example query 2',
                'limit' => 10,
                'offset' => 10,
            ],
            [
                'q' => 'example query 3',
            ],
        ];


        $this->giphyAPIService = new GiphyAPIService($apiKey);

        $expectedResponse = [
            'data' => ['fake_response' => true]
        ];

        foreach ($exampleParameters as $parameters) {
            $queryString = http_build_query($parameters);

            $target = "https://api.giphy.com/v1/gifs/search?api_key={$apiKey}&" . $queryString;

            var_dump($target);

            Http::fake([
                $target => Http::response($expectedResponse, 200)
            ]);

            $searchParams = ['q' => $parameters['q']];
            if (isset($parameters['limit'])) $searchParams['limit'] = $parameters['limit'];

            if (isset($parameters['offset']))  $searchParams['offset'] = $parameters['offset'];

            $response = $this->giphyAPIService->search(...$searchParams);

            $this->assertEquals($response, $expectedResponse);
        }
    }
}
