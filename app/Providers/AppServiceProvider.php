<?php

namespace App\Providers;

use App\Models\Doctor;
use App\Models\Polyclinic;
use App\Models\User;
use App\Policies\DoctorPolicy;
use App\Policies\PolyclinicPolicy;
use App\Policies\UserPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
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
        Gate::policy(User::class, UserPolicy::class);
        Gate::policy(Polyclinic::class, PolyclinicPolicy::class);
        Gate::policy(Doctor::class, DoctorPolicy::class);
    }
}
