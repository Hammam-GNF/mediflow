<?php

namespace App\Policies;

use App\Models\Invoice;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class InvoicePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole('admin');
    }

    public function view(User $user, Invoice $invoice): bool
    {
        return $user->hasRole('admin');
    }

    public function create(User $user): bool
    {
        return $user->hasRole('admin');
    }

    public function update(User $user, Invoice $invoice): bool
    {
        return $user->hasRole('admin');
    }

    public function delete(User $user, Invoice $invoice): bool
    {
        return $user->hasRole('admin');
    }

    public function restore(User $user, Invoice $invoice): bool
    {
        return $user->hasRole('admin');
    }

    public function forceDelete(User $user, Invoice $invoice): bool
    {
        return $user->hasRole('admin');
    }
}