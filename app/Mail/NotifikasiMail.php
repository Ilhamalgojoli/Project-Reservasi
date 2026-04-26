<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NotifikasiMail extends Mailable
{
    use Queueable, SerializesModels;

    public $peminjaman;
    public $type;

    public function __construct($peminjaman, $type)
    {
        $this->peminjaman = $peminjaman;
        $this->type = $type;
    }

    public function envelope(): Envelope
    {
        $subject = 'Notifikasi Peminjaman - ' . ucfirst($this->type);
        return new Envelope(
            subject: $subject,
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.notifikasi',
            with: [
                'peminjaman' => $this->peminjaman,
                'type' => $this->type,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
