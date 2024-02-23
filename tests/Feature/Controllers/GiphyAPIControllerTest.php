<?php

namespace Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Http\Controllers\GiphyAPIController;
use App\Http\Adapters\GiphyAPIAdapter;
use App\Http\Services\GiphyAPIService;
use App\Models\User;
use Mockery;

class GiphyAPIControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function test_search_calling_should_call_the_search_method_of_the_adapter(): void
    {
        $q = 'test';
        $limit = 15;
        $offset = 10;

        $user = User::factory()->create();

        $mockedGiphyAPIAdapter = Mockery::mock(GiphyAPIAdapter::class);
        $mockedGiphyAPIAdapter->shouldReceive('search')->once()->with($q, $limit, $offset);

        $this->app->instance(GiphyAPIAdapter::class, $mockedGiphyAPIAdapter);

        $this->actingAs($user, 'api')->get("/api/gifs/search?q={$q}&limit={$limit}&offset={$offset}");
    }

    public function test_search_by_id_calling_should_call_the_search_by_id_method_of_the_adapter(): void
    {
        $id = 1;
        $user = User::factory()->create();

        $mockedGiphyAPIAdapter = Mockery::mock(GiphyAPIAdapter::class);
        $mockedGiphyAPIAdapter->shouldReceive('searchById')->once()->withArgs([$id]);

        $this->app->instance(GiphyAPIAdapter::class, $mockedGiphyAPIAdapter);

        $this->actingAs($user, 'api')->get("/api/gifs/search/{$id}");
    }
}
