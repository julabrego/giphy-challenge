<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\UserInteraction;

class LogUserInteraction
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $processedRequestData = [
            'service_name' => $request->route()->getName(),
            'request_body' => $this->fillRequestBodyWithCorrespondingData($request),
            'query_params' => $request->query(),
            'source_ip' => $request->ip(),
        ];

        $request->attributes->set('processedRequestData', $processedRequestData);

        return $next($request);
    }

    public function terminate($request, $response)
    {
        $processedRequestData = $request->attributes->get('processedRequestData');

        $userInteraction = new UserInteraction();
        $userInteraction->user_id = $request->user()->id;
        $userInteraction->service_name = $processedRequestData['service_name'];
        $userInteraction->request_body = $processedRequestData['request_body'];
        $userInteraction->query_params = $processedRequestData['query_params'];
        $userInteraction->response_code = $response->status();
        $userInteraction->response_body = $response->content();
        $userInteraction->source_ip = $processedRequestData['source_ip'];

        $userInteraction->save();
    }

    private function fillRequestBodyWithCorrespondingData($request)
    {
        return $request->route()->hasParameter('id') ? ['id' => $request->route('id')] : $request->getContent();
    }
}
