<?php

namespace App\Policies;

use App\Models\PesanKontak;
use App\Models\User;

class PesanKontakPolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['superadmin', 'pengurus'], true);
    }

    public function view(User $user, PesanKontak $pesan): bool
    {
        return $this->viewAny($user);
    }

    public function update(User $user, PesanKontak $pesan): bool
    {
        return $user->isSuperAdmin() || ($user->isPengurus() && $user->bidang_id === null);
    }

    public function delete(User $user, PesanKontak $pesan): bool
    {
        return $user->isSuperAdmin();
    }
}
