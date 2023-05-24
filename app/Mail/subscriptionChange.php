<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class subscriptionChange extends Mailable
{
  use Queueable, SerializesModels;

  public function __construct(private $value, private $cycle, private $uri)
  {
  }

  public function envelope(): Envelope
  {
    return new Envelope(
      subject: 'Inova Sistemas - Mudanças de valor e plano da sua assinatura',
    );
  }

  public function content(): Content
  {
    return new Content(
      view: 'mail.subscription.change.index',
      with: [
        'value' => $this->value,
        'cycle' => $this->cycle,
        'uri' => $this->uri
      ],
    );
  }

  public function attachments(): array
  {
    return [];
  }
}
