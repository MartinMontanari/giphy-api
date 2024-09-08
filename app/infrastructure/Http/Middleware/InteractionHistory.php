<?php

namespace App\infrastructure\Http\Middleware;

use App\infrastructure\services\InteractionHistoryService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\domain\Models\InteractionHistory;

readonly class InteractionHistoryMiddleware
{

    public function __construct(
        private InteractionHistoryService $interactionHistoryService,
    )
    {
    }

    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        $data = [
            'user_id' => $request->user() ? $request->user()->id : null,
            'service' => $request->path(),
            'request_body' => $request->all(),
            'response_code' => $response->getStatusCode(),
            'response_body' => $response->getContent(),
            'ip_address' => $request->ip(),
        ];

        Log::info('Service InteractionHistory ->', $data);

        $this->interactionHistoryService->registerHistoryData($data);

        return $response;
    }
}
