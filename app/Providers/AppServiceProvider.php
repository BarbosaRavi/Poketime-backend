<?php

namespace App\Providers;

use App\Models\Time;
use App\Models\Pokemon;
use App\Policies\TimePolicy;
// use App\Policies\PokemonPolicy; // Se você criar uma policy para Pokémon
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Time::class => TimePolicy::class,
        // Pokemon::class => PokemonPolicy::class, // Se necessário
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

    }
}