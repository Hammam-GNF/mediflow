<?php

namespace App\Policies;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PatientPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole('admin');
    }

    public function view(User $user, Patient $patient): bool
    {
        return $user->hasRole('admin');
    }

    public function create(User $user): bool
    {
        return $user->hasRole('admin');
    }

    public function update(User $user, Patient $patient): bool
    {
        return $user->hasRole('admin');
    }

    public function delete(User $user, Patient $patient): bool
    {
        return $user->hasRole('admin');
    }

    public function restore(User $user, Patient $patient): bool
    {
        return $user->hasRole('admin');
    }

    public function forceDelete(User $user, Patient $patient): bool
    {
        return $user->hasRole('admin');
    }
}
