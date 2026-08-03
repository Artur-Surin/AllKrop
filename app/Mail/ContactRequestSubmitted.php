<?php

declare(strict_types=1);

namespace App\Mail;

use App\Models\ContactRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactRequestSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public ContactRequest $contactRequest) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Нове звернення з сайту: '.$this->contactRequest->subject_label,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.contact-request',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
