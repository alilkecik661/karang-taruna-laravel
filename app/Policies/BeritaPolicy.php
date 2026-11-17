<?php

namespace App\Policies;

use App\Models\Berita;
use App\Models\User;

class BeritaPolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['superadmin', 'pengurus'], true);
    }

    public function view(User $user, Berita $berita): bool
    {
        return $this->viewAny($user);
    }

    public function create(User $user): bool
    {
        return in_array($user->role, ['superadmin', 'pengurus'], true);
    }

    public function update(User $user, Berita $berita): bool
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        return $berita->created_by === $user->id;
    }

    public function delete(User $user, Berita $berita): bool
    {
        return $this->update($user, $berita);
    }
}
