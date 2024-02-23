<?php

namespace Tests\Feature\Services;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Http\Services\FavoriteGifService;
use App\Repositories\FavoriteGifRepository;
use Mockery;

class FavoriteGifServiceTest extends TestCase
{
    use DatabaseTransactions;

    private $favoriteGifRepository;
    private $favoriteGifService;

    public function test_save_favorite_gif_should_call_the_create_method_of_the_repository(): void
    {
        $parameters = [
            'gif_id' => '123',
            'alias' => 'test',
            'user_id' => '1'
        ];

        $mock = Mockery::mock(FavoriteGifRepository::class);

        $mock->shouldReceive('exists')->andReturn(false);
        $mock->shouldReceive('create')->once();

        $this->favoriteGifRepository = $this->app->instance(FavoriteGifRepository::class, $mock);
        $this->favoriteGifService = new FavoriteGifService($this->favoriteGifRepository);

        $this->favoriteGifService->create($parameters['gif_id'], $parameters['alias'], $parameters['user_id']);
    }

    public function test_save_favorite_gif_should_reject_when_the_user_has_already_saved_the_gif(): void
    {
        $parameters = [
            'gif_id' => '1234',
            'alias' => 'test',
            'user_id' => '1'
        ];

        $mock = Mockery::mock(FavoriteGifRepository::class);

        $mock->shouldReceive('exists')->andReturn(true);

        $this->favoriteGifRepository = $this->app->instance(FavoriteGifRepository::class, $mock);
        $this->favoriteGifService = new FavoriteGifService($this->favoriteGifRepository);

        $this->expectException(\Exception::class);
        $this->favoriteGifService->create($parameters['gif_id'], $parameters['alias'], $parameters['user_id']);
    }
}
