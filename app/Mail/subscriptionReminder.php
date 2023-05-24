<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class subscriptionReminder extends Mailable
{
  use Queueable, SerializesModels;

  public function __construct(private $data, private $type)
  {
  }

  public function envelope(): Envelope
  {
    return new Envelope(
      subject: 'Inova Sistemas - Lembrete de pagamento de sua assinatura',
    );
  }

  public function content(): Content
  {
    if ($this->type === 'boleto') {
      return new Content(
        view: 'mail.subscription.reminder.boleto.index',
        with: [
          'duedate' => $this->data->duedate,
          'amount' => $this->data->amount,
          'mail' => $this->data->mail,
          'boleto_url' => $this->data->boleto_url,
          'boleto_barcode' => $this->data->boleto_barcode,
        ],
      );
    } elseif ($this->type === 'credit_card') {
      return new Content(
        view: 'mail.subscription.reminder.card.index',
        with: [
          'duedate' => $this->data->duedate,
          'amount' => $this->data->amount,
          'mail' => $this->data->mail,
        ],
      );
    }
  }

  public function attachments(): array
  {
    return [];
  }
}
