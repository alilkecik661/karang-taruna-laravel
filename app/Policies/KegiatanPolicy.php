<?php

namespace App\Policies;

use App\Models\Kegiatan;
use App\Models\User;

class KegiatanPolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['superadmin', 'pengurus'], true);
    }

    public function view(User $user, Kegiatan $kegiatan): bool
    {
        return $this->viewAny($user);
    }

    public function create(User $user): bool
    {
        return in_array($user->role, ['superadmin', 'pengurus'], true);
    }

    public function update(User $user, Kegiatan $kegiatan): bool
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        if ($kegiatan->created_by !== $user->id) {
            return false;
        }

        if ($user->bidang_id !== null && $kegiatan->bidang_id !== null && $kegiatan->bidang_id !== $user->bidang_id) {
            return false;
        }

        return true;
    }

    public function delete(User $user, Kegiatan $kegiatan): bool
    {
        return $this->update($user, $kegiatan);
    }
}
