<?php

namespace App\Policies;

use App\Models\Pengaturan;
use App\Models\User;

class PengaturanPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isSuperAdmin();
    }

    public function update(User $user, ?Pengaturan $pengaturan = null): bool
    {
        return $user->isSuperAdmin();
    }
}
