<?php

namespace App\Policies;

use App\Models\Album;
use App\Models\User;

class AlbumPolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['superadmin', 'pengurus'], true);
    }

    public function view(User $user, Album $album): bool
    {
        return $this->viewAny($user);
    }

    public function create(User $user): bool
    {
        return in_array($user->role, ['superadmin', 'pengurus'], true);
    }

    public function update(User $user, Album $album): bool
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        return $album->created_by === $user->id;
    }

    public function delete(User $user, Album $album): bool
    {
        return $this->update($user, $album);
    }
}
