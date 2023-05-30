<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\subscriptionCancelled;
use App\Mail\subscriptionChange;
use App\Mail\subscriptionCreated;
use App\Mail\subscriptionPayment;
use App\Mail\subscriptionReminder;
use App\Services\KeyRequestService;
use App\Services\PagarMeRequestService;
use Carbon\Carbon;
use DatabaseQueries;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class APIController extends Controller
{
  public function companyData()
  {
    $resultsArrayDates = [];
    $resultsArrayMoneyIn = [];
    $resultsArrayMoneyOut = [];

    $db = new DatabaseQueries();
    $companyData = $db->selectCompanyData();

    foreach ($companyData as $row) {
      $resultsArrayDates[] = extrairMesPorExtenso($row->period);
      $resultsArrayMoneyIn[] = floatval($row->money_in);
      $resultsArrayMoneyOut[] = floatval($row->money_out);
    }

    $message[] = [
      'code' => ($companyData) ? 200 : 403,
      'money_in' => ($companyData) ? $resultsArrayMoneyIn : null,
      'money_out' => ($companyData) ? $resultsArrayMoneyOut : null,
      'labels' => ($companyData) ? $resultsArrayDates : null,
    ];

    return response($message, $message[0]['code'])
      ->header('Content-Type', 'application/json');
  }

  public function clientsSum()
  {
    $current_date = Carbon::now();
    $current_date_validation = Carbon::createFromFormat('Y-m-d H:i:s', $current_date)->format('Y-m-d');
    $db = new DatabaseQueries();
    $newArray = [];
    $resultsArray = [];
    $resultsArrayDates = [];

    $clientsSum = $db->sumDelayedPayments();

    foreach ($clientsSum as $row) {
      $resultsArray[] = floatval($row->value);
      $resultsArrayDates[] = dateFormat($row->date);
    }

    $day = '';
    $value = '0';

    foreach ($clientsSum as $row) {
      if ($current_date_validation === $row->date) {
        $day = dateFormat($current_date_validation);
        $value = floatval($row->value);
      }
    }

    $message[] = [
      'code' => ($resultsArray) ? 200 : 403,
      'value' => ($resultsArray) ? $value : null,
      'day' => ($resultsArray) ? $day : null,
      'results' => ($resultsArray) ? $resultsArray : null,
      'labels' => ($resultsArray) ? $resultsArrayDates : null,
    ];

    return response($message, $message[0]['code'])
      ->header('Content-Type', 'application/json');
  }

  public function clientsEntry()
  {
    $db = new DatabaseQueries();
    $resultsArray = [];
    $total = 0;

    $clientsEntry = $db->countClientsEntry();

    foreach ($clientsEntry as $row) {
      $count = $row->sum + $row->count;
      $resultsArray[] = $count;
      $total = $count;
    }

    $message[] = [
      'code' => ($resultsArray) ? 200 : 403,
      'results' => ($resultsArray) ? $resultsArray : null,
      'total' => $total
    ];

    return response($message, $message[0]['code'])
      ->header('Content-Type', 'application/json');
  }

  public function checkUser($document)
  {
    $db = new DatabaseQueries();
    $pagarMeService = new PagarMeRequestService();
    $manage_url = '';

    $result = $db->getSubscriptionByDocument($document);
    $response_pagarme = $pagarMeService->getSubscription($result[0]->subscription_id);

    if (!isset($response_pagarme['errors'])) {
      if ($response_pagarme['manage_url']) {
        $manage_url = $response_pagarme['manage_url'];
      }
    }

    $message[] = [
      'code' => ($manage_url) ? 200 : 403,
      'manage_url' => ($manage_url) ? $manage_url : null,
    ];

    return response($message, $message[0]['code'])
      ->header('Content-Type', 'application/json');
  }

  public function postStore(Request $request)
  {
    $db = new DatabaseQueries();
    $result = $db->insertStoreOS($request->json()->all());

    $message[] = [
      'code' => ($result > 0) ? 202 : 304,
      'message' => ($result > 0) ? 'Record updated successfully.' : 'Record not updated successfully.'
    ];

    return response($message, $message[0]['code'])
      ->header('Content-Type', 'application/json');
  }

  public function putStore(Request $request)
  {
    $db = new DatabaseQueries();
    $result = $db->updateStoreOS($request->json()->all());

    $message[] = [
      'code' => ($result > 0) ? 202 : 304,
      'message' => ($result > 0) ? 'Record updated successfully.' : 'Record not updated successfully.'
    ];

    return response($message, $message[0]['code'])
      ->header('Content-Type', 'application/json');
  }

  public function postbackPagarme(Request $request)
  {
    $db = new DatabaseQueries();
    $db->insertPayload($request['id'], $request['subscription']['current_period_end']);

    $current_period_end = $request['subscription']['current_period_end'];
    $current_status = $request['current_status'];
    $customer_email = $request['subscription']['customer']['email'];
    $customer_name = $request['subscription']['customer']['name'];
    $event = $request['event'];
    $id = $request['id'];
    $manage_url = $request['subscription']['manage_url'];
    $payment_method = $request['subscription']['payment_method'];

    if ('subscription_status_changed' === $event) {
      $res_customer = $db->selectSubscriptionEmail($id);
      $email = $res_customer[0]->email;
      $document_number = $res_customer[0]->document_number;

      switch ($current_status) {
        case 'paid':
          // assinatura está paga e em dia //

          $new_current_period_end = dateFormatISO(dateFormat(addDaysToDate($current_period_end, 7)));
          $serial = $db->selectSerialNumberBySubscription($id);

          $key = generateKey($serial[0]->serial, $new_current_period_end);

          ($db->updateSubscriptionStatus($id, true) > 0)
            ? Mail::to($email)->send(new subscriptionPayment($manage_url, $current_status, $key))
            : null;
          break;

        case 'trialing':
          // assinatura ainda está em período de testes e não foi realizada nenhuma cobrança //
          break;

        case 'pending_payment':
          // assinatura ainda não foi paga, porém não ultrapassou o limite de dias de tolerância //

          ($db->updateSubscriptionStatus($id, true) > 0)
            ? Mail::to($email)->send(new subscriptionPayment($manage_url, $current_status, null))
            : null;
          break;

        case 'unpaid':
          // quando o pagamento não foi efetuado e o prazo de tolerância foi esgotado //

          ($db->updateSubscriptionStatus($id, false) > 0)
            ? Mail::to($email)->send(new subscriptionPayment($manage_url, $current_status, null))
            : null;
          break;

        case 'ended':
          // quando a assinatura concluiu todos as cobranças definidas pelo plano //

          ($db->updateSubscriptionStatus($id, false) > 0)
            ? Mail::to($email)->send(new subscriptionCancelled())
            : null;
          break;

        case 'canceled':
          // quando a assinatura foi cancelada antes do final do seu período //

          ($db->updateSubscriptionStatus($id, false) > 0)
            ? Mail::to($email)->send(new subscriptionCancelled())
            : null;
          break;
      }

      $KeyService = new KeyRequestService();
      $new_current_period_end = dateFormatISO(dateFormat(addDaysToDate($current_period_end, 7)));
      $KeyService->key($document_number, '', $new_current_period_end);
      $db->nextPromotionalValidationDate($res_customer[0]->id, $new_current_period_end);
    } elseif ('transaction_status_changed' === $event) {
      //
    }
  }

  public function mailReminders()
  {
    $db = new DatabaseQueries();
    $pagarMeService = new PagarMeRequestService();

    $stores = $db->selectStoresWithSubscription();

    foreach ($db->selectStoresWithSubscription() as $subscription) {
      $response_pagarme = $pagarMeService->getSubscription($subscription->subscription_id);
      $email = $db->selectSubscriptionEmail($subscription->subscription_id);

      if (!isset($response_pagarme['errors'])) {
        if ($response_pagarme['current_period_end']) {
          if ((strtotime($response_pagarme['current_period_end']) > strtotime('now')) || (strtotime($response_pagarme['current_period_end']) == strtotime('now'))) {
            $reminder_day = date('Y-m-d', strtotime("-7 days", strtotime($response_pagarme['current_period_end'])));
            //$today = date('Y-m-d', strtotime("+23 days", strtotime("now")));
            $today = date('Y-m-d');

            if ($reminder_day === $today) {
              $data = new \stdClass();

              if ('credit_card' === $response_pagarme['payment_method']) {
                $data->duedate = date('d/m/Y', strtotime($response_pagarme['current_period_end']));
                $data->amount = substr_replace($response_pagarme['plan']['amount'], '.', -2, 0);
                $data->mail = $email[0]->email;

                Mail::to($email[0]->email)->send(new subscriptionReminder($data, 'credit_card'));
              } elseif ('boleto' ===  $response_pagarme['current_transaction']['payment_method']) {
                $boleto_url = $response_pagarme['current_transaction']['boleto_url'];
                $boleto_barcode = $response_pagarme['current_transaction']['boleto_barcode'];
                $boleto_expiration_date = $response_pagarme['current_transaction']['boleto_expiration_date'];
                $boleto = $response_pagarme['current_transaction']['boleto'];

                $data->duedate = date('d/m/Y', strtotime($boleto_expiration_date));
                $data->amount = substr_replace($response_pagarme['plan']['amount'], '.', -2, 0);
                $data->boleto_barcode = $boleto_barcode;
                $data->boleto_url = $boleto_url;
                $data->mail = $email[0]->email;

                Mail::to($email[0]->email)->send(new subscriptionReminder($data, 'boleto'));
              }
            }

            return response(json_encode((array)$data), 200)
              ->header('Content-Type', 'application/json');
          }
        }
      }

      return response('', 200)
        ->header('Content-Type', 'application/json');
    }

    $message[] = [
      'code' => 202,
      'message' => 'Records updated successfully.'
    ];

    return response($stores, $message[0]['code'])
      ->header('Content-Type', 'application/json');
  }

  public function updatePunchedClock(Request $request, $id)
  {
    $db = new DatabaseQueries();

    $params = $request->json()->all();
    $start_date = $params[0]['start_date'];
    $end_date = $params[0]['end_date'];

    $result = $db->updatePunchedClock($id, $start_date, $end_date);

    $message[] = [
      'code' => ($result > 0) ? 202 : 304,
      'message' => ($result > 0) ? 'Registration updated successfully' : 'Registration not updated.'
    ];

    return response($message, $message[0]['code'])
      ->header('Content-Type', 'application/json');
  }

  public function generateKeyQuick(Request $request)
  {
    $params = $request->json()->all();
    $serial = $params[0]['serial'];
    $due_date = $params[0]['due_date'];

    $key = generateKey($serial, $due_date);

    if ($key) {
      $message[] = [
        'code' => 202,
        'key' => $key
      ];
    } else {
      $message[] = [
        'code' => 304,
        'key' => null
      ];
    }

    return response($message, $message[0]['code'])
      ->header('Content-Type', 'application/json');
  }

  public function deleteVacation($id)
  {
    $db = new DatabaseQueries();
    $result = $db->deleteVacation($id);

    $message[] = [
      'code' => ($result > 0) ? 202 : 304,
      'message' => ($result > 0) ? 'Registration deleted successfully' : 'Registration not deleted.'
    ];

    return response($message, $message[0]['code'])
      ->header('Content-Type', 'application/json');
  }

  public function putVacation(Request $request)
  {
    $db = new DatabaseQueries();
    $params = $request->json()->all();

    $result = $db->updateVacation($params);

    $message[] = [
      'code' => ($result > 0) ? 202 : 304,
      'message' => ($result > 0) ? 'Registration updated successfully' : 'Registration not updated.'
    ];

    return response($message, $message[0]['code'])
      ->header('Content-Type', 'application/json');
  }

  public function postVacation(Request $request)
  {
    $db = new DatabaseQueries();
    $params = $request->json()->all();

    $result = $db->createVacation($params);

    $message[] = [
      'code' => ($result > 0) ? 202 : 304,
      'message' => ($result > 0) ? 'Registration created successfully' : 'Registration not created.'
    ];

    return response($message, $message[0]['code'])
      ->header('Content-Type', 'application/json');
  }

  public function postActivationStore(Request $request)
  {
    $db = new DatabaseQueries();
    $params = $request->json()->all();

    $result = $db->createStore($params);

    $message[] = [
      'code' => ($result > 0) ? 202 : 304,
      'message' => ($result > 0) ? 'Registration created successfully' : 'Registration not created.'
    ];

    return response($message, $message[0]['code'])
      ->header('Content-Type', 'application/json');
  }

  public function deleteActivationStoreStation($store, $id)
  {
    $db = new DatabaseQueries();
    $result = $db->deleteStation($store, $id);

    $message[] = [
      'code' => ($result > 0) ? 202 : 304,
      'message' => ($result > 0) ? 'Registration deleted successfully' : 'Registration not deleted.'
    ];

    return response($message, $message[0]['code'])
      ->header('Content-Type', 'application/json');
  }

  public function putActivationStoreStation(Request $request)
  {
    $db = new DatabaseQueries();
    $params = $request->json()->all();

    foreach ($params as $param) {
      $result = $db->updateStation($param['store_id'], $param['name'], $param['serial'], $param['server'], $param['id']);
    }

    $message[] = [
      'code' => ($result > 0) ? 202 : 304,
      'message' => ($result > 0) ? 'Registration created successfully' : 'Registration not created.'
    ];

    return response($message, $message[0]['code'])
      ->header('Content-Type', 'application/json');
  }

  public function postActivationStoreStation(Request $request)
  {
    $db = new DatabaseQueries();
    $params = $request->json()->all();

    foreach ($params as $param) {
      $result = $db->createNewStation($param['store_id'], $param['name'], $param['serial'], $param['server']);
    }

    $message[] = [
      'code' => ($result > 0) ? 202 : 304,
      'message' => ($result > 0) ? 'Registration created successfully' : 'Registration not created.'
    ];

    return response($message, $message[0]['code'])
      ->header('Content-Type', 'application/json');
  }

  public function putActivationStore(Request $request)
  {
    $params = $request->json()->all();
    $checkParameters = $this->checkParameters($params);

    if ($checkParameters) {
      if ($this->updateStore($params)) {
        $updateSubscription = $this->updateSubscription($params);

        /*return response($updateSubscription, 200)
          ->header('Content-Type', 'application/json');*/

        if ($updateSubscription) {
          $message[] = [
            'code' => 202,
            'message' => 'Registration updated successfully.'
          ];
        } else {
          $message[] = [
            'code' => 409,
            'message' => 'Registration not updated.'
          ];
        }
      }

      $this->updatePriorityOS($params);
    } else {
      $message[] = [
        'code' => 422,
        'message' => 'Missing required parameters.'
      ];
    }

    return response($message, $message[0]['code'])
      ->header('Content-Type', 'application/json');
  }

  public function userLoggin(Request $request)
  {
    $params = $request->json()->all();

    if (isset($params['username']) && isset($params['password']) && isset($params['remember'])) {
      $db = new DatabaseQueries();
      $result = $db->userLoggin($params['username'], $params['password']);

      if ('carol' !== strtolower($params['username'])) {
        $message[] = [
          'message' => 'Usuário não identificado.',
          'code' => 401
        ];

        return response($message, 401)
          ->header('Content-Type', 'application/json');
      }

      foreach ($result as $user) {
        if ($user->id) {
          $message[] = [
            'user_id' => $user->id,
            'name' => $user->name
          ];

          $expires = ($params['remember']) ? 518400 : 1440;

          return response($message, 200)
            ->cookie('userInovaAdmin', $user->id, $expires)
            ->header('Content-Type', 'application/json');
        }
      }

      $message[] = [
        'message' => 'Usuário não identificado.',
        'code' => 401
      ];

      return response($message, 401)
        ->header('Content-Type', 'application/json');
    } else {
      $message[] = [
        'message' => 'Ausência de parâmetros.',
        'code' => 406
      ];

      return response($message, 406)
        ->header('Content-Type', 'application/json');
    }
  }

  private function updateSubscription($params)
  {
    $db = new DatabaseQueries();
    $subscription_id = null;
    $subscription_status = false;
    $subscription_cycle = 1;
    $subscription_amount = 1;

    $response = $db->getSubscription($params[0]['id']);

    if ($response) {
      foreach ($response as $res) {
        $subscription_id = ($res->subscription_id) ? $res->subscription_id : null;
        $subscription_status = ($res->subscription_status) ? boolval($res->subscription_status) : false;
        $subscription_cycle = ($res->subscription_cycle) ? $res->subscription_cycle : 1;
        $subscription_amount = ($res->subscription_amount) ? $res->subscription_amount : 1;
      }
    }

    foreach ($params as $param) {
      foreach ($param['subscription'] as $subscription) {
        $param_subscription_amount = $subscription['subscription_amount'];
        $param_subscription_cycle = $subscription['subscription_cycle'];
        $param_subscription_status = $subscription['subscription_status'];
        $param_subscription_free_trail = $subscription['subscription_free_trail'];
        $param_subscription_email = $subscription['subscription_email'];
      }
    }

    $resp[] = [
      'subscription_id' => $subscription_id,
      'subscription_status' => $subscription_status,
      'subscription_cycle' => $subscription_cycle,
      'subscription_amount' => $subscription_amount,
      'param_subscription_amount' => $subscription['subscription_amount'],
      'param_subscription_cycle' => $subscription['subscription_cycle'],
      'param_subscription_status' => $subscription['subscription_status'],
      'param_subscription_free_trail' => $subscription['subscription_free_trail'],
      'param_subscription_email' => $subscription['subscription_email'],
    ];

    if ($subscription_status == false && $param_subscription_status == false) {
      //return 'do-nothing';



      return true;
    } elseif ($subscription_status == false && $param_subscription_status == true) {
      //return 'new-subscription';



      $response = $this->createNewPlan($param_subscription_amount, $param_subscription_cycle, $subscription['subscription_document'], $param_subscription_free_trail);

      if ($response) {
        $response_1 = $this->createNewSubscription($param['id'], $response['id'], $param_subscription_email, $param['trade_name'], $subscription['subscription_document']);
        return ($response_1 > 0) ? true : false;
      } else {
        return false;
      }

      return false;
    } elseif ($subscription_status == true && $param_subscription_status == true) {
      //return 'update';

      if (($subscription_cycle != $param_subscription_cycle) || ($subscription_amount != $param_subscription_amount)) {
        $response = $this->createNewPlan($param_subscription_amount, $param_subscription_cycle, $param['document_number'], $param_subscription_free_trail);

        if ($response) {
          $response = $this->putNewPlanToSubscription($param['id'], $subscription_id, $response['id']);
          $email = $db->selectSubscriptionEmail($subscription_id);

          // $subscription_mail
          ($response[0]['status'] === true)
            ? Mail::to($email[0]->email)->send(new subscriptionChange($param_subscription_amount, $param_subscription_cycle, $response[0]['manage_url']))
            : null;

          return ($response > 0) ? true : false;
        } else {
          return false;
        }

        return $response;
      } else {
        return true;
      }
    } elseif ($subscription_status == true && $param_subscription_status == false) {
      //return 'cancel';



      $result = $this->cancelSubscription($param['id'], $subscription_id);
      return ($result > 0) ? true : false;
    }
  }

  private function cancelSubscription($store_id, $subscription_id)
  {
    $db = new DatabaseQueries();
    $pagarMeService = new PagarMeRequestService();

    $pagarMePlan[] = [
      'subscription_id' => $subscription_id
    ];

    $reponsePagarmeSubscription = $pagarMeService->cancelSubscription($subscription_id, $pagarMePlan[0]);
    $res = $db->cancelSubscription($store_id);

    $email = $db->selectSubscriptionEmail($subscription_id);

    // $subscription_mail
    ($res > 0)
      ? Mail::to($email[0]->email)->send(new subscriptionCancelled())
      : null;

    return ($res > 0) ? true : false;
  }

  private function createNewSubscription($store_id, $plan_id, $email, $trade_name, $document_number)
  {
    $db = new DatabaseQueries();
    $pagarMeService = new PagarMeRequestService();

    $pagarMeSubscriptionCustomer[] = [
      'email' => 'financeiro@inovasistemas.com.br',
      'name' => $trade_name,
      'document_number' => $document_number
    ];

    $pagarMeSubscription[] = [
      'plan_id' => $plan_id,
      'payment_method' => 'boleto',
      'customer' => $pagarMeSubscriptionCustomer[0],
      'postback_url' => 'https://inovasistemas.app/api/postback/pagarme'
    ];

    $reponsePagarmeSubscription = $pagarMeService->createNewSubscription($pagarMeSubscription[0]);

    if (isset($reponsePagarmeSubscription['id'])) {

      // $subscription_mail
      Mail::to($email)->send(new subscriptionCreated($reponsePagarmeSubscription['manage_url']));

      $current_period_end = str_replace('T', ' ', explode('.', $reponsePagarmeSubscription['current_period_end'])[0]);
      $current_period_end = Carbon::createFromFormat('Y-m-d H:i:s', $current_period_end);

      $current_date = Carbon::now();
      $status = ($current_date >= $current_period_end) ? false : true;

      return ($db->updateSubscription($store_id, $plan_id, $reponsePagarmeSubscription['id'], $status) > 0) ? true : false;
    } else {
      return false;
    }

    return false;
  }

  private function putNewPlanToSubscription($store_id, $subscription_id, $plan_id)
  {
    $db = new DatabaseQueries();
    $pagarMeService = new PagarMeRequestService();

    $pagarMeSubscriptionUpdate[] = [
      'subscription_id' => $subscription_id,
      'plan_id' => $plan_id
    ];

    $reponsePagarmeSubscription = $pagarMeService->updateSubscription($subscription_id, $pagarMeSubscriptionUpdate[0]);

    if (isset($reponsePagarmeSubscription['id'])) {
      $current_period_end = str_replace('T', ' ', explode('.', $reponsePagarmeSubscription['current_period_end'])[0]);
      $current_period_end = Carbon::createFromFormat('Y-m-d H:i:s', $current_period_end);

      $current_date = Carbon::now();
      $status = ($current_date >= $current_period_end) ? false : true;

      $res_put = $db->updateSubscription($store_id, $plan_id, $subscription_id, $status);

      $ret[] = [
        'status' => ($res_put > 0) ? true : false,
        'manage_url' => $reponsePagarmeSubscription['manage_url']
      ];

      return $ret;
    } else {
      return false;
    }

    return false;
  }

  private function createNewPlan($amount, $cycle, $document_number, $free_trial)
  {
    $db = new DatabaseQueries();
    $pagarMeService = new PagarMeRequestService();

    $name = $document_number . ' - R$ ' . $amount . ' - ' . $cycle;
    $amount_temp = $amount;
    $amount = (!strpos(strval($amount), '.')) ? (strval($amount) . '.00') : strval($amount);

    $objectPlan[] = [
      'name' => $name,
      'amount' => str_replace('.', '', $amount),
      'trial_days' => $free_trial,
      'days' => $cycle,
      'payment_methods' => ['boleto', 'credit_card'],
      'charges' => null,
      'installments' => '1',
      'invoice_reminder' => 7,
      'color' => '#cacaca'
    ];

    $reponsePagarme = $pagarMeService->createNewPlan($objectPlan[0]);

    if (isset($reponsePagarme['id'])) {
      $db->createPlan($reponsePagarme['id'], $document_number, $cycle, $amount_temp, $free_trial);

      return $reponsePagarme;
    } else {
      return false;
    }
  }

  private function updateStore($params)
  {
    $db = new DatabaseQueries();

    foreach ($params as $param) {
      $KeyService = new KeyRequestService();
      $KeyService->key($param['document_number'], $param['trade_name'], $param['due_date']);

      $db->nextPromotionalValidationDate($param['id'], $param['due_date']);
      $result = $db->updateKeyDetailsStore(
        $param['id'],
        $param['trade_name'],
        $param['document_number'],
        $param['line_of_business'],
        $param['plan'],
        $param['cycle'],
        $param['amount'],
        $param['renew_1'],
        $param['renew_2'],
        $param['renew_day'],
        $param['priority'],
        $param['subscription'][0]['subscription_email'],
        $param['subscription'][0]['subscription_document']
      );

      return true;
    }
  }

  private function checkParameters($params)
  {
    foreach ($params as $param) {
      $response[] = (!isset($param['id'])) ? false : true;
      $response[] = (!isset($param['trade_name'])) ? false : true;
      $response[] = (!isset($param['line_of_business'])) ? false : true;
      $response[] = (!isset($param['document_number'])) ? false : true;
      $response[] = (!isset($param['priority'])) ? false : true;
      $response[] = (!isset($param['plan'])) ? false : true;
      $response[] = (!isset($param['cycle'])) ? false : true;
      $response[] = (!isset($param['amount'])) ? false : true;
      $response[] = (!isset($param['renew_1'])) ? false : true;
      $response[] = (!isset($param['renew_2'])) ? false : true;
      $response[] = (!isset($param['renew_day'])) ? false : true;
      $response[] = (!isset($param['due_date'])) ? false : true;
      $response[] = (!isset($param['subscription'])) ? false : true;

      foreach ($response as $res) {
        if (!$res) return false;
      }

      return true;
    }
  }

  private function updatePriorityOS($params)
  {
    $db = new DatabaseQueries();

    foreach ($params as $param) {
      $document_number = $param['document_number'];
      $plan = $param['plan'];
      $cycle = $param['cycle'];
      $amount = $param['amount'];
      $priority = $param['priority'];

      $result = $db->updatePriorityOS($document_number, $plan, $amount, $cycle, $priority);
    }
  }
}
