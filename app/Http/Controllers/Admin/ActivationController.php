<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DatabaseQueries;

class ActivationController extends Controller
{
  public function activationQuick()
  {
    return view('admin.activation.quick.index');
  }

  public function storeCreate()
  {
    $db = new DatabaseQueries();
    $arrayLineOfBusiness = $db->lineOfBusiness();

    return view('admin.activation.store.create.index')
      ->with('array_line_of_business', $arrayLineOfBusiness);
  }

  public function storeLinkedStores($id)
  {
    return view('admin.activation.store.linked.index');
  }

  public function storeWithoutStation($id)
  {
    return view('admin.activation.store.station.index')
      ->with('store_id', $id);
  }

  public function storeStation($id, $station)
  {
    $db = new DatabaseQueries();
    $station = $db->getStation($id, $station);

    return view('admin.activation.store.station.index')
      ->with('station', $station[0])
      ->with('store_id', $id);
  }

  public function storeDetails($id)
  {
    $db = new DatabaseQueries();
    $result = $db->storeActivationDetails($id);
    $arrayLineOfBusiness = $db->lineOfBusiness();

    foreach ($result as $store) {
      $id = $store->id;
      $trade_name = normalizeText($store->trade_name);
      $priority = ($store->priority) ? intval($store->priority) : 1;
      $document_number = $store->document_number;
      $plan = $store->plan;
      $cycle = $store->cycle;
      $amount = $store->amount;
      $renew_1 = $store->renew_1;
      $renew_2 = $store->renew_2;
      $renew_date = $store->renew_date;
      $next_date_validation = $store->next_date_validation;
      $lineOfBusiness = $store->line_of_business;
      $pagarme = $store->pagarme;
      $pagarme_status = ($store->pagarme_status == '1') ? 'checked' : '';
      $pagarme_email = $store->pagarme_email;
      $pagarme_document = $store->pagarme_document;
    }

    $pagarme_cycle = null;
    $pagarme_amount = null;
    $pagarme_free_trial = null;

    foreach ($db->pagarmePlan($pagarme) as $pagarme_res) {
      $pagarme_cycle = $pagarme_res->cycle;
      $pagarme_amount = $pagarme_res->amount;
      $pagarme_free_trial = $pagarme_res->free_trial;
    }

    $likedStores = $db->linkedStores($document_number);

    $arrayOfLinkedStores = [];
    foreach ($likedStores as $linked_stores) {
      if (!empty($linked_stores)) {
        $linked_stores = $linked_stores->stores;
        $linked_stores = explode(';', $linked_stores);

        foreach ($linked_stores as $linked_store) {
          if (!empty($linked_store)) {
            $linkedStore = $db->linkedStore($linked_store);

            foreach ($linkedStore as $linked) {
              $store_id = $linked->id;
              $store_trade_name = normalizeText($linked->trade_name);
              $store_document_number = formatCnpjCpf($linked->document_number);

              $arrayOfLinkedStores[] = array(
                "id" => $store_id,
                "trade_name" => $store_trade_name,
                "document_number" => $store_document_number
              );
            }
          }
        }
      }
    }

    $stations = $db->stations($id);

    return view('admin.activation.store.index')
      ->with('id', $id)
      ->with('trade_name', $trade_name)
      ->with('document_number', formatCnpjCpf($document_number))
      ->with('priority', $priority)
      ->with('plan', $plan)
      ->with('cycle', $cycle)
      ->with('amount', $amount)
      ->with('renew_1', $renew_1)
      ->with('renew_2', $renew_2)
      ->with('renew_date', $renew_date)
      ->with('next_date_validation', $next_date_validation)
      ->with('line_of_business', $lineOfBusiness)
      ->with('array_line_of_business', $arrayLineOfBusiness)
      ->with('linked_stores', $arrayOfLinkedStores)
      ->with('stations', $stations)
      ->with('pagarme_status', $pagarme_status)
      ->with('pagarme_email', $pagarme_email)
      ->with('pagarme_document', $pagarme_document)
      ->with('pagarme_cycle', $pagarme_cycle)
      ->with('pagarme_amount', $pagarme_amount)
      ->with('pagarme_free_trial', $pagarme_free_trial);
  }

  public function activation(Request $request)
  {
    $__display = 50;
    $resultsArray = [];
    $search = ($request->busca) ? $request->busca : null;
    $order = ($request->ordem) ? $request->ordem : null;

    $db = new DatabaseQueries();
    $result = $db->searchStoresForActivation($search, $order);

    foreach ($result as $row) {
      $resultsArray[] = (array) $row;
    }

    $numberOfRowsDisplayed = (count($result) < $__display) ? count($result) : $__display;
    $numberOfRows = count($result);

    return view('admin.activation.index')
      ->with('search', $search)
      ->with('order', $order)
      ->with('stores', array_slice($resultsArray, 0, $__display))
      ->with('number_of_rows_displayed', $numberOfRowsDisplayed)
      ->with('number_of_rows', $numberOfRows);
  }
}
