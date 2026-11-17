<?php

namespace App\Mail;

use App\Models\PesanKontak;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NotifikasiPesanKontakBaru extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public PesanKontak $pesan) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pesan Kontak Baru: ' . ($this->pesan->subjek ?: 'Tanpa Subjek'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.notifikasi-kontak',
        );
    }
}
