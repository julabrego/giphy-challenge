<?php

namespace Tests\Feature\Middlewares;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Http\Middleware\LogUserInteraction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LogUserInteractionTest extends TestCase
{
    use DatabaseTransactions;

    public function test_log_user_interaction_terminate_method_should_record_the_requests_in_database(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $requestData = [
            'user' => $user,
            'service_name' => 'service_name',
            'request_body' => ['message' => 'request_body'],
            'query_params' => 'query_params',
            'source_ip' => '127.0.0.1',
        ];

        $request = new Request($requestData);

        $responseData = [
            'response_code' => 200,
            'response_body' => ['message' => 'success'],
        ];

        $response = new Response($responseData['response_body'], $responseData['response_code']);

        $request->attributes->set('processedRequestData', $request);

        $logUserInteraction = new LogUserInteraction();

        $request->setUserResolver(function () use ($user) {
            return $user;
        });
        $logUserInteraction->terminate($request, $response);

        $this->assertDatabaseHas('user_interactions', [
            'response_body' => json_encode($responseData['response_body'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
        ]);
    }
}
