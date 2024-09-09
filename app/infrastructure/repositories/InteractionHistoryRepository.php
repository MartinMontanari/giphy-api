<?php

namespace App\infrastructure\repositories;

use App\domain\Models\InteractionHistory;
use Illuminate\Support\Facades\Log;

readonly class InteractionHistoryRepository
{
    /**
     * @param InteractionHistory $interactionHistory
     * @return void
     */
    public function save(InteractionHistory $interactionHistory): void
    {
        Log::info('Saving the interaction into database and registering history...');
        $interactionHistory->save();
    }
}
