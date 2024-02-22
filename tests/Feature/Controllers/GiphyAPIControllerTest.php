<?php

namespace Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Http\Controllers\GiphyAPIController;
use App\Http\Adapters\GiphyAPIAdapter;
use App\Http\Services\GiphyAPIService;
use Mockery;

class GiphyAPIControllerTest extends TestCase
{
    public function test_search_calling_should_call_the_search_method_of_the_adapter(): void
    {
        $q = 'test';
        $limit = 15;
        $offset = 10;

        $mock = Mockery::mock(GiphyAPIAdapter::class);
        $mock->shouldReceive('search')->once()->withArgs([$q, $limit, $offset]);

        $this->app->instance(GiphyAPIAdapter::class, $mock);

        $this->get("/api/gifs/search?q={$q}&limit={$limit}&offset={$offset}");
    }

    public function test_search_by_id_calling_should_call_the_search_by_id_method_of_the_adapter(): void
    {
        $id = 1;

        $mock = Mockery::mock(GiphyAPIAdapter::class);
        $mock->shouldReceive('searchById')->once()->withArgs([$id]);

        $this->app->instance(GiphyAPIAdapter::class, $mock);

        $this->get("/api/gifs/search/{$id}");
    }
}
