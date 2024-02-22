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

    public function test_search_request_should_send_a_request_to_the_giphy_api_passing_the_correct_parameters(): void
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

        $expectedResponse = [
            'data' => ['fake_response' => true]
        ];

        $this->giphyAPIService = new GiphyAPIService($apiKey);

        foreach ($exampleParameters as $parameters) {
            $this->mockHTTPGiphySearchRequest($parameters, $apiKey, $expectedResponse);

            $response = $this->giphyAPIService->search(...$this->generateSeachParams($parameters));

            $this->assertEquals($response, $expectedResponse);
        }
    }

    public function test_search_by_idrequest_should_send_a_request_to_the_giphy_api_passing_the_correct_parameters(): void
    {
        $apiKey = 'testKey123';

        $id = 1;

        $expectedResponse = [
            'data' => ['fake_response' => true]
        ];

        $this->giphyAPIService = new GiphyAPIService($apiKey);

        $this->mockHTTPGiphySearchByIdRequest($id, $apiKey, $expectedResponse);

        $response = $this->giphyAPIService->searchById($id);

        $this->assertEquals($response, $expectedResponse);
    }

    private function mockHTTPGiphySearchRequest($input, $apiKey, $expectedResponse): void
    {
        $queryString = http_build_query($input);

        $target = "https://api.giphy.com/v1/gifs/search?api_key={$apiKey}&" . $queryString;

        Http::fake([
            $target => Http::response($expectedResponse, 200)
        ]);
    }

    private function mockHTTPGiphySearchByIdRequest($input, $apiKey, $expectedResponse): void
    {
        $target = "https://api.giphy.com/v1/gifs/{$input}?api_key={$apiKey}";

        Http::fake([
            $target => Http::response($expectedResponse, 200)
        ]);
    }

    private function generateSeachParams($parameters)
    {
        $searchParams = ['q' => $parameters['q']];
        if (isset($parameters['limit'])) $searchParams['limit'] = $parameters['limit'];
        if (isset($parameters['offset']))  $searchParams['offset'] = $parameters['offset'];

        return $searchParams;
    }
}
