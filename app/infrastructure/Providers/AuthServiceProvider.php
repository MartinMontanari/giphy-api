<?php

namespace App\infrastructure\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Passport::tokensExpireIn(now()->addMinutes(30));

        Passport::tokensCan([
            'view-account' => 'View your account',
            'edit-account' => 'Edit your account',
        ]);

        Passport::loadKeysFrom(storage_path());

    }
}
