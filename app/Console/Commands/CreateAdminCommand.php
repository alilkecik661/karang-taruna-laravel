<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdminCommand extends Command
{
    protected $signature = 'admin:create
                            {--name=Administrator Karang Taruna : Nama lengkap akun admin}
                            {--email=admin@karangtaruna.or.id : Alamat email akun admin}
                            {--password=AdminKT2026! : Kata sandi akun admin}
                            {--role=superadmin : Peran akun (superadmin atau pengurus)}';

    protected $description = 'Buat atau perbarui akun admin Karang Taruna';

    public function handle(): int
    {
        $email = (string) $this->option('email');
        $name = (string) $this->option('name');
        $password = (string) $this->option('password');
        $role = in_array($this->option('role'), ['superadmin', 'pengurus'], true)
            ? (string) $this->option('role')
            : 'superadmin';

        $user = User::updateOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'password' => Hash::make($password),
                'role' => $role,
                'bidang_id' => null,
                'email_verified_at' => now(),
            ]
        );

        $this->info("Akun admin berhasil disiapkan:");
        $this->line("  Nama     : {$user->name}");
        $this->line("  Email    : {$user->email}");
        $this->line("  Password : {$password}");
        $this->line("  Role     : {$user->role}");

        return self::SUCCESS;
    }
}
