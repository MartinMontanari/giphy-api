<?php

namespace App\infrastructure\repositories;

use App\domain\Models\User;
use Illuminate\Log\Logger;
use Illuminate\Support\Facades\Log;

class UserRepository
{

    public function save(User $user): void
    {
        try{
            Log::info('Attempting to save a new user...');
            $user->save();
        } catch(Exception $exception){
            Log::error('Attempting to save a new user...', $exception?->getMessage());
            throw $exception;
        }
    }
}
