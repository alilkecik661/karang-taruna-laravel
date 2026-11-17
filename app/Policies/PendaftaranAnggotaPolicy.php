<?php

namespace App\Policies;

use App\Models\PendaftaranAnggota;
use App\Models\User;

class PendaftaranAnggotaPolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['superadmin', 'pengurus'], true);
    }

    public function view(User $user, PendaftaranAnggota $pendaftaran): bool
    {
        return $this->viewAny($user);
    }

    public function update(User $user, PendaftaranAnggota $pendaftaran): bool
    {
        // Superadmin dan pengurus inti (tanpa batasan bidang spesifik) dapat mengubah status
        return $user->isSuperAdmin() || ($user->isPengurus() && $user->bidang_id === null);
    }

    public function export(User $user): bool
    {
        return $user->isSuperAdmin() || ($user->isPengurus() && $user->bidang_id === null);
    }
}
