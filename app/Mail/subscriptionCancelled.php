<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class subscriptionCancelled extends Mailable
{
  use Queueable, SerializesModels;

  public function __construct()
  {
  }

  public function envelope(): Envelope
  {
    return new Envelope(
      subject: 'Inova Sistemas - Cancelamento da sua assinatura',
    );
  }

  public function content(): Content
  {
    return new Content(
      view: 'mail.subscription.cancelled.index',
    );
  }

  public function attachments(): array
  {
    return [];
  }
}
