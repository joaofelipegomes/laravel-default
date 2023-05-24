<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Queue\SerializesModels;

class subscriptionCreated extends Mailable
{
  use Queueable, SerializesModels;

  public function __construct(private $uri)
  {
  }

  public function envelope(): Envelope
  {
    return new Envelope(
      subject: 'Inova Sistemas - Confirmação de assinatura',
    );
  }

  public function content(): Content
  {
    return new Content(
      view: 'mail.subscription.created.index',
      with: ['uri' => $this->uri],
    );
  }

  public function attachments(): array
  {
    return [];
  }
}
