<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreKontakRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama' => ['required', 'string', 'min:3', 'max:150'],
            'email' => ['required', 'email', 'max:150'],
            'subjek' => ['nullable', 'string', 'max:200'],
            'isi' => ['required', 'string', 'min:10', 'max:3000'],
            'website' => ['nullable', 'string', 'max:255'], // Honeypot
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required' => 'Nama Anda wajib diisi.',
            'nama.min' => 'Isi nama Anda minimal 3 karakter.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'isi.required' => 'Pesan wajib diisi.',
            'isi.min' => 'Tulis pesan minimal 10 karakter.',
        ];
    }
}
