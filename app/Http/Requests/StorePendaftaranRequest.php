<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePendaftaranRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama_lengkap' => ['required', 'string', 'min:3', 'max:150'],
            'jenis_kelamin' => ['required', 'in:Laki-laki,Perempuan'],
            'tanggal_lahir' => ['required', 'date', 'before:today'],
            'no_whatsapp' => ['required', 'string', 'regex:/^(08|\+?62)[0-9\s\-]{8,15}$/'],
            'alamat' => ['required', 'string', 'min:10', 'max:1000'],
            'email' => ['nullable', 'email', 'max:150'],
            'bidang_minat' => ['nullable', 'string', 'max:100'],
            'website' => ['nullable', 'string', 'max:255'], // Honeypot
        ];
    }

    public function messages(): array
    {
        return [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'nama_lengkap.min' => 'Isi nama lengkap minimal 3 karakter.',
            'jenis_kelamin.required' => 'Pilih jenis kelamin.',
            'jenis_kelamin.in' => 'Pilihan jenis kelamin tidak valid.',
            'tanggal_lahir.required' => 'Pilih tanggal lahir.',
            'tanggal_lahir.before' => 'Tanggal lahir harus sebelum hari ini.',
            'no_whatsapp.required' => 'Nomor WhatsApp wajib diisi.',
            'no_whatsapp.regex' => 'Nomor WhatsApp tidak valid (gunakan awalan 08 atau +62).',
            'alamat.required' => 'Alamat lengkap wajib diisi.',
            'alamat.min' => 'Isi alamat lengkap minimal 10 karakter.',
            'email.email' => 'Format email tidak valid.',
        ];
    }
}
