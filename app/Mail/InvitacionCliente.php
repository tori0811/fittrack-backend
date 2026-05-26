<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InvitacionCliente extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $urlInvitacion,
        public string $nombreEntrenador
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '¡Te han invitado a FitTracker!',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.invitacion',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}