<?php

namespace App\Mail;

use App\Models\PendaftaranAnggota;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NotifikasiPendaftaranBaru extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public PendaftaranAnggota $pendaftaran) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pendaftaran Anggota Baru: ' . $this->pendaftaran->nama_lengkap,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.notifikasi-pendaftaran',
        );
    }
}
