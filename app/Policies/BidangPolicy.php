<?php

namespace App\Policies;

use App\Models\Bidang;
use App\Models\User;

class BidangPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isSuperAdmin();
    }

    public function create(User $user): bool
    {
        return $user->isSuperAdmin();
    }

    public function update(User $user, Bidang $bidang): bool
    {
        return $user->isSuperAdmin();
    }

    public function delete(User $user, Bidang $bidang): bool
    {
        return $user->isSuperAdmin();
    }
}
