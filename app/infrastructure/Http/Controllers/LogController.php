<?php

namespace App\infrastructure\Http\Controllers;

use Illuminate\Support\Facades\File;

class LogController extends Controller
{
    public function showLogs()
    {
        $logFile = storage_path('logs/laravel.log');

        if (!File::exists($logFile)) {
            return response()->json(['message' => 'Log file not found.'], 404);
        }

        $logs = File::get($logFile);

        $logLines = explode("\n", $logs);

        $logLines = array_reverse($logLines);

        return response()->json(['logs' => $logLines], 200);
    }
}
