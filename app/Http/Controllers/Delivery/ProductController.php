<?php

namespace App\Http\Controllers\Delivery;

use App\Services\DeliveryRequestService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
  public function product(string $store, string $item)
  {
    $deliveryService = new DeliveryRequestService();

    foreach ($deliveryService->findStore($store) as $findStore) {
      foreach ($deliveryService->getStore($findStore["id"]) as $storeDetails) {
        $id = $storeDetails["id"];
        $trade_name = formatText($storeDetails["trade_name"]);
      }

      $product = [];
      foreach ($deliveryService->getProduct($findStore["id"], $item) as $product) {
        $product[] = array(
          "id" => $product["id"],
          "internal_id" => $product["internal_id"],
          "code" => $product["code"],
          "barcode" => $product["barcode"],
          "name" => formatText($product["name"]),
          "description" => formatText($product["description"]),
          "amount" => $product["amount"],
          "amount_table_2" => $product["amount_table_2"],
          "stock" => $product["stock"],
          "unit" => $product["unit"],
          "category_id" => $product["category_id"],
          "family_id" => $product["family_id"],
          "maker" => $product["maker"],
          "image" => $product["image"],
          "kilogram" => $product["kilogram"],
          "additional_code" => $product["additional_code"],
          "additionals_id" => $product["additionals_id"]
        );
      }

      return view("delivery.product.index")
        ->with("id", $id)
        ->with("trade_name", $trade_name)
        ->with("product", $product);
    }
  }

  public function search(string $store)
  {
    $deliveryService = new DeliveryRequestService();

    foreach ($deliveryService->findStore($store) as $findStore) {
      foreach ($deliveryService->getStore($findStore["id"]) as $storeDetails) {
        $id = $storeDetails["id"];
        $trade_name = formatText($storeDetails["trade_name"]);
      }
    }

    dd('oi');
    /*return view("delivery.search.index")
      ->with("trade_name", $trade_name);*/
  }
}
