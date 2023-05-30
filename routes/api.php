<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\APIController;
use App\Http\Controllers\Admin\MailController;
use App\Services\KeyRequestService;

Route::get(
  '/check/{document}',
  [APIController::class, 'checkUser']
);

Route::post(
  '/user/login',
  [APIController::class, 'userLoggin']
);

Route::get(
  '/clients/entry',
  [APIController::class, 'clientsEntry']
);

Route::get(
  '/clients/values',
  [APIController::class, 'clientsSum']
);

Route::get(
  '/company/data',
  [APIController::class, 'companyData']
);

Route::post(
  '/store',
  [APIController::class, 'postStore']
);

Route::put(
  '/store',
  [APIController::class, 'putStore']
);

Route::post(
  '/activation/store',
  [APIController::class, 'postActivationStore']
);

Route::put(
  '/activation/store',
  [APIController::class, 'putActivationStore']
);

Route::post(
  '/activation/store/station',
  [APIController::class, 'postActivationStoreStation']
);

Route::delete(
  '/activation/store/{store}/station/{id}',
  [APIController::class, 'deleteActivationStoreStation']
);

Route::put(
  '/activation/store/station',
  [APIController::class, 'putActivationStoreStation']
);

Route::post(
  '/collaborator/vacation/',
  [APIController::class, 'postVacation']
);

Route::put(
  '/collaborator/vacation/',
  [APIController::class, 'putVacation']
);

Route::put(
  '/collaborator/punchedclock/{id}',
  [APIController::class, 'updatePunchedClock']
);

Route::delete(
  '/collaborator/vacation/{id}',
  [APIController::class, 'deleteVacation']
);

Route::post(
  '/activation/quick',
  [APIController::class, 'generateKeyQuick']
);

Route::post(
  '/postback/pagarme',
  [APIController::class, 'postbackPagarme']
);

// *************** SENDING EMAILS *************** //

Route::get(
  '/postback/reminder',
  [APIController::class, 'mailReminders']
);

// ******************* EMAILS ******************* //

Route::get(
  '/email/recusado',
  function () {
    return view('mail.subscription.payment.refused.index')
      ->with('uri', '1');
  }
);

/*Route::get(
  '/email/pago', function() {
    $new_current_period_end = dateFormatISO(dateFormat(addDaysToDate('2023-06-11T14:55:01.770Z', 7)));
    $db = new DatabaseQueries();
    $serial = $db->selectSerialNumberBySubscription('990135');

    $key = generateKey($serial[0]->serial, $new_current_period_end);

    return view('mail.subscription.payment.paid.index')
    ->with('key', $key);
  }
);*/

Route::get('/teste', function () {
  $KeyService = new KeyRequestService();
  return $KeyService->key('44786659825', 'Joao Felipe Gomes', '2023-05-30');
});

Route::get(
  '/email/lembrete/cartao',
  function () {
    return view('mail.subscription.reminder.card.index')
      ->with([
        'amount' => 1,
        'duedate' => '30/05/2023'
      ]);
  }
);

Route::get(
  '/email/lembrete/boleto',
  function () {
    return view('mail.subscription.reminder.boleto.index')
      ->with([
        'amount' => 1,
        'duedate' => '30/05/2023',
        'boleto_barcode' => '123 123 123',
        'boleto_url' => '1'
      ]);
  }
);

Route::get(
  '/email/criado',
  function () {
    return view('mail.subscription.created.index')
      ->with([
        'uri' => '1'
      ]);
  }
);

Route::get(
  '/email/troca',
  function () {
    return view('mail.subscription.change.index')
      ->with([
        'value' => 1,
        'cycle' => 1,
        'uri' => '1'
      ]);
  }
);

Route::get(
  '/email/cancelado',
  function () {
    return view('mail.subscription.cancelled.index')
      ->with([
        'uri' => '1'
      ]);
  }
);
