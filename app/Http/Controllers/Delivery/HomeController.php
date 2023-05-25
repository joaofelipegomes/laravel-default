<?php

namespace App\Http\Controllers\Delivery;

use Illuminate\Support\Facades\Route;
use App\Services\DeliveryRequestService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
  public function home(string $store)
  {
    if ($store) {
      setCookies('store', $store);
      session(['store' => $store]);
      deleteCookie('store');
      setCookies('store', $store);
      $deliveryService = new DeliveryRequestService();

      foreach ($deliveryService->findStore($store) as $findStore) {

        foreach ($deliveryService->getStore($findStore["id"]) as $getStore) {
          $categories = [];
          $categoriesProducts = [];
          $products = [];

          foreach ($deliveryService->getCategories($findStore["id"]) as $category) {
            $categories[] = array(
              "id" => $category["id"],
              "name" => formatText($category["name"])
            );
          }

          foreach ($deliveryService->getProducts($findStore["id"]) as $product) {
            $products[] = array(
              "id" => $product["id"],
              "name" => formatText($product["name"]),
              "description" => formatDescription($product["description"]),
              "amount" => number_format($product["amount"], 2, ',', '.'),
              "amount_table_2" => $product["amount_table_2"],
              "category_id" => $product["category_id"],
              "family_id" => $product["family_id"],
              "image" => $product["image"],
            );
          }

          foreach ($categories as $category => $c) {
            if (array_search($c['id'], array_column($products, 'category_id'))) {
              $categoriesProducts[] = array(
                "id" => $c['id'],
                "name" => $c['name']
              );
            }
          }

          $id = $getStore["id"];
          $corporate_name = formatText($getStore["corporate_name"]);
          $trade_name = formatText($getStore["trade_name"]);
          $federal_registration = $getStore["federal_registration"];
          $address = formatText($getStore["address"]);
          $address_zipcode = extractNumber($getStore["address_zipcode"]);
          $address_number = $getStore["address_number"];
          $address_neighborhood = formatText($getStore["address_neighborhood"]);
          $address_city = formatText($getStore["address_city"]);
          $phone_1 = extractNumber($getStore["phone_1"]);
          $phone_2 = extractNumber($getStore["phone_2"]);
          $address_state = $getStore["address_state"];
          $image = $getStore["image"];
          $header = $getStore["header"];
          $logo = $getStore["logo"];

          return view("delivery.home.index")
            ->with('storename', $store)
            ->with('id', $id)
            ->with('trade_name', $trade_name)
            ->with('logo', $logo)
            ->with('header', $header)
            ->with('categories', $categoriesProducts)
            ->with('products', $products);
        }
      }
    }
  }

  public function status(string $store)
  {
    $deliveryService = new DeliveryRequestService();

    setCookies('store', $store);
    $deliveryService = new DeliveryRequestService();

    foreach ($deliveryService->findStore($store) as $findStore) {
      foreach ($deliveryService->getStoreStus($findStore["id"]) as $res) {
        $json_string = json_encode($res, JSON_PRETTY_PRINT);
        echo $json_string;
      }
    }
  }
}
