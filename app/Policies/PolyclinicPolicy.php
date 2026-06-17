<?php

namespace App\Policies;

use App\Models\Polyclinic;
use App\Models\User;

class PolyclinicPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole('admin');
    }

    public function view(User $user, Polyclinic $polyclinic): bool
    {
        return $user->hasRole('admin');
    }

    public function create(User $user): bool
    {
        return $user->hasRole('admin');
    }

    public function update(User $user, Polyclinic $polyclinic): bool
    {
        return $user->hasRole('admin');
    }

    public function delete(User $user, Polyclinic $polyclinic): bool
    {
        return $user->hasRole('admin');
    }

    public function restore(User $user, Polyclinic $polyclinic): bool
    {
        return $user->hasRole('admin');
    }

    public function forceDelete(User $user, Polyclinic $polyclinic): bool
    {
        return $user->hasRole('admin');
    }
}