<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\subscriptionCancelled;
use App\Mail\subscriptionCreated;
use App\Mail\subscriptionPayment;
use App\Mail\subscriptionReminder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
  public function subscriptionCreated()
  {
    // uri gerenciador
    // mail
    Mail::to('contato@joaofelipegomes.com.br')->send(new subscriptionCreated());
  }

  public function subscriptionReminder()
  {
    // uri gerenciador
    // mail
    // se for boleto -> enviar link do boleto e código do boleto e uri gerenciador
    // se for cartão -> enviar apenas lembrete com uri gerenciador
    Mail::to('contato@joaofelipegomes.com.br')->send(new subscriptionReminder());
  }

  public function subscriptionPayment()
  {
    // uri gerenciador
    // mail
    // se aprovado -> não encaminhar link
    // se não aprovado -> encaminhar link
    Mail::to('contato@joaofelipegomes.com.br')->send(new subscriptionPayment());
  }

  public function subscriptionCancelled()
  {
    // mail
    Mail::to('contato@joaofelipegomes.com.br')->send(new subscriptionCancelled());
  }
}
