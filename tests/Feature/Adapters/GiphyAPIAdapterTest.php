<?php

namespace Tests\Feature\Adapters;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Http\Adapters\GiphyAPIAdapter;
use App\Http\Services\GiphyAPIService;
use App\DTOs\GifDTO;
use Illuminate\Support\Facades\Http;

class GiphyAPIAdapterTest extends TestCase
{
    private $giphyAPIAdapter;
    private $giphyAPIService;
    private $testableAdapter;

    public function setUp(): void
    {
        parent::setUp();
        $this->giphyAPIService = new GiphyAPIService('testKey123');
        $this->giphyAPIAdapter = new GiphyAPIAdapter($this->giphyAPIService);
        $this->testableAdapter = new TestableGiphyAPIAdapter($this->giphyAPIService);
    }

    public function test_adapter_should_adapt_giphy_api_response_structure_to_gif_dto(): void
    {
        $aSingleGif = $this->getExampleAPIResponse()['data'][0];

        $expectedResponse = new GifDTO([
            'id' => $aSingleGif['id'],
            'url' => $aSingleGif['url'],
            'title' => $aSingleGif['title'],
        ]);

        $response = $this->testableAdapter->callAdapt($aSingleGif);

        $this->assertEquals($response, $expectedResponse);
    }

    public function test_adapter_should_throw_exception_when_giphy_api_response_is_invalid(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->testableAdapter->callAdapt([]);
    }

    public function test_adapter_should_adapt_the_response_of_the_search_method(): void
    {
        $this->mockHTTPGiphySearchRequest();

        $response = $this->giphyAPIAdapter->search('example query');

        $this->assertContainsOnlyInstancesOf(GifDTO::class, $response);
    }

    private function getExampleAPIResponse()
    {
        $fileContents = file_get_contents(base_path() . '/tests/Feature/MockAPIResponses/GiphyAPIResponse.json');
        $exampleResponse = json_decode($fileContents, true);
        return $exampleResponse;
    }

    private function mockHTTPGiphySearchRequest(): void
    {
        $target = "https://api.giphy.com/*";

        Http::fake([
            $target => Http::response($this->getExampleAPIResponse(), 200)
        ]);
    }
}

class TestableGiphyAPIAdapter extends GiphyAPIAdapter
{
    public function callAdapt(array $data): GifDTO
    {
        return $this->adapt($data);
    }
}
