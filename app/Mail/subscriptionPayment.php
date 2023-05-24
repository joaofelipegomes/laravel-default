<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class subscriptionPayment extends Mailable
{
  use Queueable, SerializesModels;

  public function __construct(private $uri, private $type, private $key)
  {
  }

  public function envelope(): Envelope
  {
    return new Envelope(
      subject: 'Inova Sistemas - Pagamento recusado de sua assinatura',
    );
  }

  public function content(): Content
  {
    if ('paid' === $this->type) {
      return new Content(
        view: 'mail.subscription.payment.paid.index',
        with: ['key' => $this->key],
      );
    }

    return new Content(
      view: 'mail.subscription.payment.refused.index',
      with: ['uri' => $this->uri],
    );
  }

  public function attachments(): array
  {
    return [];
  }
}
