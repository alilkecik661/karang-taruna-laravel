<?php

namespace App\Policies;

use App\Models\Pengurus;
use App\Models\User;

class PengurusPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isSuperAdmin();
    }

    public function create(User $user): bool
    {
        return $user->isSuperAdmin();
    }

    public function update(User $user, Pengurus $pengurus): bool
    {
        return $user->isSuperAdmin();
    }

    public function delete(User $user, Pengurus $pengurus): bool
    {
        return $user->isSuperAdmin();
    }
}
