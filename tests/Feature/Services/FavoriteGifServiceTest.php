<?php

namespace Tests\Feature\Services;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Http\Services\FavoriteGifService;
use App\Repositories\FavoriteGifRepository;
use App\Http\Services\GiphyAPIService;
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

        $mockedFavoriteGifRepository = Mockery::mock(FavoriteGifRepository::class);

        $mockedFavoriteGifRepository->shouldReceive('exists')->andReturn(false);
        $mockedFavoriteGifRepository->shouldReceive('create')->once();

        $giphyServiceMock = Mockery::mock(GiphyAPIService::class);

        $this->favoriteGifRepository = $this->app->instance(FavoriteGifRepository::class, $mockedFavoriteGifRepository);
        $this->favoriteGifService = new FavoriteGifService($this->favoriteGifRepository, $giphyServiceMock);

        $this->favoriteGifService->create($parameters['gif_id'], $parameters['alias'], $parameters['user_id']);
    }

    public function test_save_favorite_gif_should_reject_when_the_user_has_already_saved_the_gif(): void
    {
        $parameters = [
            'gif_id' => '1234',
            'alias' => 'test',
            'user_id' => '1'
        ];

        $mockedFavoriteGifRepository = Mockery::mock(FavoriteGifRepository::class);

        $mockedFavoriteGifRepository->shouldReceive('exists')->andReturn(true);

        $giphyServiceMock = Mockery::mock(GiphyAPIService::class);

        $this->favoriteGifRepository = $this->app->instance(FavoriteGifRepository::class, $mockedFavoriteGifRepository);
        $this->favoriteGifService = new FavoriteGifService($this->favoriteGifRepository, $giphyServiceMock);

        $this->expectException(\Exception::class);
        $this->favoriteGifService->create($parameters['gif_id'], $parameters['alias'], $parameters['user_id']);
    }

    public function test_save_favorite_gif_should_throw_when_the_user_tries_to_save_a_gif_with_an_invalid_id(): void
    {
        $parameters = [
            'gif_id' => 'invalid',
            'alias' => 'test',
            'user_id' => '1'
        ];

        $mockedFavoriteGifRepository = Mockery::mock(FavoriteGifRepository::class);
        $mockedFavoriteGifRepository->shouldReceive('exists')->andReturn(false);

        $giphyServiceMock = Mockery::mock(GiphyAPIService::class);
        $giphyServiceMock->shouldReceive('searchById')
            ->with($parameters['gif_id'])
            ->once()
            ->andReturn(null);

        $this->app->instance(GiphyAPIService::class, $giphyServiceMock);
        $this->app->instance(FavoriteGifRepository::class, $mockedFavoriteGifRepository);

        $this->favoriteGifService = new FavoriteGifService($this->favoriteGifRepository, $giphyServiceMock);

        $this->expectException(\Exception::class);
        $this->favoriteGifService->create($parameters['gif_id'], $parameters['alias'], $parameters['user_id']);
    }
}
