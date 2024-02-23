<?php

namespace Tests\Feature\Repositories;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Mockery;
use App\Models\FavoriteGif;
use App\Repositories\FavoriteGifRepository;

class FavoriteGifRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    private $favoriteGifRepository;
    private $favoriteGifModel;

    public function test_create_method_should_create_a_favorite_gif_in_the_database_and_return_its_instance(): void
    {
        $favoriteGifAttributes = [
            'id' => 1,
            'gif_id' => 2,
            'alias' => 'my favorite gif',
            'user_id' => 3,
        ];

        $expectedFavoriteGif = FavoriteGif::make($favoriteGifAttributes);

        $favoriteGifMock = Mockery::mock(FavoriteGif::class);
        $favoriteGifMock->shouldReceive('create')->with([
            'gif_id' => $favoriteGifAttributes['gif_id'],
            'alias' => $favoriteGifAttributes['alias'],
            'user_id' => $favoriteGifAttributes['user_id'],
        ])->andReturn($expectedFavoriteGif);

        $this->favoriteGifRepository = new FavoriteGifRepository($favoriteGifMock);

        $response = $this->favoriteGifRepository->create($favoriteGifAttributes['gif_id'], $favoriteGifAttributes['alias'], $favoriteGifAttributes['user_id']);

        $this->assertEquals($response, $expectedFavoriteGif);
    }

    public function test_exists_method_should_return_true_if_the_favorite_gif_exists_in_the_database(): void
    {
        $favoriteGifAttributes = [
            'id' => 1,
            'gif_id' => 2,
            'alias' => 'my favorite gif',
            'user_id' => 3,
        ];

        $favoriteGifMock = Mockery::mock(FavoriteGif::class);

        $favoriteGifMock->shouldReceive('where')->with([
            'gif_id' => $favoriteGifAttributes['gif_id'],
            'user_id' => $favoriteGifAttributes['user_id'],
        ])->andReturn($favoriteGifMock);

        $favoriteGifMock->shouldReceive('exists')->andReturn(true);

        $this->favoriteGifRepository = new FavoriteGifRepository($favoriteGifMock);

        $response = $this->favoriteGifRepository->exists($favoriteGifAttributes['gif_id'], $favoriteGifAttributes['user_id']);

        $this->assertTrue($response);
    }

    public function test_exists_method_should_return_false_if_the_favorite_gif_doesnt_exist_in_the_database(): void
    {
        $favoriteGifAttributes = [
            'id' => 1,
            'gif_id' => 2,
            'alias' => 'my favorite gif',
            'user_id' => 3,
        ];

        $favoriteGifMock = Mockery::mock(FavoriteGif::class);

        $favoriteGifMock->shouldReceive('where')->with([
            'gif_id' => $favoriteGifAttributes['gif_id'],
            'user_id' => $favoriteGifAttributes['user_id'],
        ])->andReturn(null);

        $favoriteGifMock->shouldReceive('exists')->andReturn(false);

        $this->favoriteGifRepository = new FavoriteGifRepository($favoriteGifMock);

        $response = $this->favoriteGifRepository->exists($favoriteGifAttributes['gif_id'], $favoriteGifAttributes['user_id']);

        $this->assertFalse($response);
    }
}
