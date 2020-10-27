<?php

namespace App\Providers;

use App\Models\Order;
use App\Models\Ticket;
use App\Policies\OrderPolicy;
use App\Policies\TicketPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
        Order::class => OrderPolicy::class,
        Ticket::class => TicketPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('admin', function ($user) {
            if ($user->profiles->where('description', 'Admin')->count() > 0)
                return true;

            return false;
        });

        Gate::define('financer', function ($user) {
            if ($user->profiles->where('description', 'Financer')->count() > 0)
                return true;

            return false;
        });

        Gate::define('authenticated', function ($user) {
            return true;
        });
    }
}
