<?php

namespace App\Providers;

use App\Models\Doctor;
use App\Models\MedicalRecord;
use App\Models\Patient;
use App\Models\Polyclinic;
use App\Models\Queue;
use App\Models\Registration;
use App\Models\User;
use App\Policies\DoctorPolicy;
use App\Policies\MedicalRecordPolicy;
use App\Policies\PatientPolicy;
use App\Policies\PolyclinicPolicy;
use App\Policies\QueuePolicy;
use App\Policies\RegistrationPolicy;
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
        Gate::policy(Patient::class, PatientPolicy::class);
        Gate::policy(Registration::class, RegistrationPolicy::class);
        Gate::policy(Queue::class, QueuePolicy::class);
        Gate::policy(MedicalRecord::class, MedicalRecordPolicy::class);
    }
}
