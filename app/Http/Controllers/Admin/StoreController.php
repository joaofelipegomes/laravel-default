<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DatabaseQueries;

class StoreController extends Controller
{
  public function storeCreate()
  {
    $db = new DatabaseQueries();
    $listStatus = $db->selectClientStatus();
    $listProducts = $db->selectProducts();

    return view('admin.store.details.index')
    ->with([
      'list_status' => $listStatus,
      'list_products' => $listProducts
    ]);
  }

  public function storeDetails($id)
  {
    $resultsArray = [];
    $db = new DatabaseQueries();
    $details = $db->selectClientOS($id);
    $listStatus = $db->selectClientStatus();
    $listProducts = $db->selectProducts();

    foreach ($details as $row) {
      $resultsArray[] = (array) $row;
    }

    return view('admin.store.details.index')
    ->with([
      'id' => $id,
      'store' => $resultsArray[0],
      'list_status' => $listStatus,
      'list_products' => $listProducts
    ]);
  }

  public function stores(Request $request)
  {
    $__display = 50;
    $resultsArray = [];
    $db = new DatabaseQueries();

    $search = ($request->busca) ? $request->busca : null;
    $status = ($request->status) ? $request->status : null;

    $listStatus = $db->selectClientStatus();
    $listClients = $db->selectClientsOS($search, $status);

    foreach ($listClients as $row) {
      $resultsArray[] = (array) $row;
    }

    $numberOfRowsDisplayed = (count($listClients) < $__display) ? count($listClients) : $__display;
    $numberOfRows = count($listClients);

    return view('admin.store.index')
    ->with([
      'search' => $search,
      'status' => $status,
      'list_status' => $listStatus,
      'list_clients' => array_slice($resultsArray, 0, $__display),
      'number_of_rows_displayed' => $numberOfRowsDisplayed,
      'number_of_rows' => $numberOfRows
    ]);
  }
}
