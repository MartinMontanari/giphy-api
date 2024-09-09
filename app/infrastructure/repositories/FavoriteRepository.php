<?php

namespace App\infrastructure\repositories;

use App\domain\Models\Favorite;
use Illuminate\Support\Facades\Log;

readonly class FavoriteRepository
{
    /**
     * @param Favorite $favorite
     * @return void
     */
    public function save(Favorite $favorite): void
    {
        Log::info('Saving the new favorite into database...');
        $favorite->save();
    }

}
