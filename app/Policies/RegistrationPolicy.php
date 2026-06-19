<?php

namespace App\Policies;

use App\Models\Registration;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class RegistrationPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole('admin');
    }

    public function view(User $user, Registration $registration): bool
    {
        return $user->hasRole('admin');
    }

    public function create(User $user): bool
    {
        return $user->hasRole('admin');
    }

    public function update(User $user, Registration $registration): bool
    {
        return $user->hasRole('admin');
    }

    public function delete(User $user, Registration $registration): bool
    {
        return $user->hasRole('admin');
    }

    public function restore(User $user, Registration $registration): bool
    {
        return $user->hasRole('admin');
    }

    public function forceDelete(User $user, Registration $registration): bool
    {
        return $user->hasRole('admin');
    }
}
