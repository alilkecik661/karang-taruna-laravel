<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bidang;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        abort_unless($request->user()->isSuperAdmin(), 403);
        $users = User::with('bidang')->orderBy('id')->get();

        return view('admin.pengguna.index', compact('users'));
    }

    public function create(Request $request): View
    {
        abort_unless($request->user()->isSuperAdmin(), 403);
        $bidangList = Bidang::orderBy('nama')->get();

        return view('admin.pengguna.create', compact('bidangList'));
    }

    public function store(Request $request): RedirectResponse
    {
        abort_unless($request->user()->isSuperAdmin(), 403);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:150', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'role' => ['required', 'in:superadmin,pengurus'],
            'bidang_id' => ['nullable', 'exists:bidang,id'],
        ]);

        $validated['password'] = Hash::make($validated['password']);
        if ($validated['role'] === 'superadmin') {
            $validated['bidang_id'] = null;
        }

        User::create($validated);

        return redirect()->route('admin.pengguna.index')->with('sukses', 'Akun pengguna berhasil dibuat.');
    }

    public function edit(Request $request, User $pengguna): View
    {
        abort_unless($request->user()->isSuperAdmin(), 403);
        $bidangList = Bidang::orderBy('nama')->get();

        return view('admin.pengguna.edit', ['user' => $pengguna, 'bidangList' => $bidangList]);
    }

    public function update(Request $request, User $pengguna): RedirectResponse
    {
        abort_unless($request->user()->isSuperAdmin(), 403);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:150', 'unique:users,email,' . $pengguna->id],
            'password' => ['nullable', 'string', 'min:8'],
            'role' => ['required', 'in:superadmin,pengurus'],
            'bidang_id' => ['nullable', 'exists:bidang,id'],
        ]);

        if (! empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        if ($validated['role'] === 'superadmin') {
            $validated['bidang_id'] = null;
        }

        $pengguna->update($validated);

        return redirect()->route('admin.pengguna.index')->with('sukses', 'Akun pengguna berhasil diperbarui.');
    }

    public function destroy(Request $request, User $pengguna): RedirectResponse
    {
        abort_unless($request->user()->isSuperAdmin(), 403);

        if ($pengguna->id === $request->user()->id) {
            return redirect()->back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $pengguna->delete();

        return redirect()->route('admin.pengguna.index')->with('sukses', 'Akun pengguna berhasil dihapus.');
    }
}
