<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Mockery;
use Tests\TestCase;
use App\Http\Services\FavoriteGifService;
use App\Models\User;
use App\Models\FavoriteGif;
use Illuminate\Support\Facades\Auth;

class FavoriteGifControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function test_call_to_save_favorite_gif_route_should_call_to_the_save_favorite_gif_service(): void
    {
        $parameters = [
            'gif_id' => 'abcd123',
            'alias' => 'my favorite gif',
        ];

        $user = User::factory()->create();
        $expectedFavoriteGif = new FavoriteGif([
            'user_id' => $user->id,
            ...$parameters
        ]);

        $mock = Mockery::mock(FavoriteGifService::class);
        $mock->shouldReceive('create')->once()->with($parameters['gif_id'], $parameters['alias'], $user->id)->andReturn($expectedFavoriteGif);
        $this->app->instance(FavoriteGifService::class, $mock);

        $response = $this->actingAs($user, 'api')->post('/api/gifs/save-favorite-gif', $parameters);

        $response->assertStatus(200);
        $response->assertJson($expectedFavoriteGif->toArray());
    }
}
