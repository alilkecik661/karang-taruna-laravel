<?php

namespace App\Policies;

use App\Models\Banner;
use App\Models\User;

class BannerPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isSuperAdmin();
    }

    public function create(User $user): bool
    {
        return $user->isSuperAdmin();
    }

    public function update(User $user, Banner $banner): bool
    {
        return $user->isSuperAdmin();
    }

    public function delete(User $user, Banner $banner): bool
    {
        return $user->isSuperAdmin();
    }
}
