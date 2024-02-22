<?php

namespace Tests\Feature\Adapters;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Http\Adapters\GiphyAPIAdapter;
use App\Http\Services\GiphyAPIService;
use App\DTOs\GifDTO;

class GiphyAPIAdapterTest extends TestCase
{
    private $giphyAPIAdapter;

    public function setUp(): void
    {
        parent::setUp();
        $this->giphyAPIAdapter = new GiphyAPIAdapter(new GiphyAPIService('testKey123'));
    }

    public function test_adapter_should_adapt_giphy_api_response_structure_to_gif_dto(): void
    {
        $aSingleGif = $this->getExampleAPIResponse()['data'][0];

        $expectedResponse = new GifDTO([
            'id' => $aSingleGif['id'],
            'url' => $aSingleGif['url'],
            'title' => $aSingleGif['title'],
        ]);

        $response = $this->giphyAPIAdapter->adapt($aSingleGif);

        $this->assertEquals($response, $expectedResponse);
    }

    public function test_adapter_should_throw_exception_when_giphy_api_response_is_invalid(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->giphyAPIAdapter->adapt([]);
    }

    private function getExampleAPIResponse()
    {
        $fileContents = file_get_contents(base_path() . '/tests/Feature/MockAPIResponses/GiphyAPIResponse.json');
        $exampleResponse = json_decode($fileContents, true);
        return $exampleResponse;
    }
}
