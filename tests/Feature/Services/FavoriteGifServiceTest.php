<?php

namespace Tests\Feature\Services;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Http\Services\FavoriteGifService;
use App\Repositories\FavoriteGifRepository;
use Mockery;

class FavoriteGifServiceTest extends TestCase
{
    private $favoriteGifRepository;
    private $favoriteGifService;

    public function test_save_favorite_gif_should_call_the_create_method_of_the_repository(): void
    {
        $mock = Mockery::mock(FavoriteGifRepository::class);

        $mock->shouldReceive('create')->once();

        $this->favoriteGifRepository = $this->app->instance(FavoriteGifRepository::class, $mock);
        $this->favoriteGifService = new FavoriteGifService($this->favoriteGifRepository);

        $this->favoriteGifService->create(1, 'test', 1);
    }
}
