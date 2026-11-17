<?php

namespace App\Mail;

use App\Models\PendaftaranAnggota;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class KonfirmasiPendaftaranAnggota extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public PendaftaranAnggota $pendaftaran) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Konfirmasi Pendaftaran Anggota Karang Taruna',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.konfirmasi-pendaftaran',
        );
    }
}
