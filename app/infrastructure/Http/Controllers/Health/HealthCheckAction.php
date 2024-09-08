<?php

namespace App\infrastructure\Http\Controllers\Health;

use App\infrastructure\Http\Controllers\Controller;
use App\infrastructure\Http\enums\HttpCodes;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HealthCheckAction extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function execute(Request $request): JsonResponse
    {
        Log::info("Health check -> $request->ip()", ['HealthCheckAction', $request->getMethod()]);
        return response()->json(['status' => 'Healthy', 'message' => 'API is up and running!'])->setStatusCode(HttpCodes::OK);
    }
}
