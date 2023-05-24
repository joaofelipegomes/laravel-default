<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\DeliveryRequestService;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Response;

class CartController extends Controller
{
    public function show() {
        return view('api.localstorage');
    }

    public function set(Request $request) {
        $bodyContent = $request->getContent();
        setCookies('bag', $bodyContent);
        echo $bodyContent;
    }

    public function cart() {
        $user = getCookies('user');
        $store = session('store');
        //setCookies('store', $store);
        $deliveryService = new DeliveryRequestService();

        foreach($deliveryService->findStore($store) as $findStore) {
            foreach($deliveryService->getStore($findStore["id"]) as $getStore) {
                $id = $getStore["id"];
                $corporate_name = formatText($getStore["corporate_name"]);
                $trade_name = formatText($getStore["trade_name"]);
            }
        }

        $user = $user ? '/carrinho/entrega' : '/perfil';

        $data = deleteCookie('bag');
        $data = getCookies('bag');

        return view('app.cart.index')
            ->with('link', $user)
            ->with('trade_name', $trade_name)
            ->with('bag', json_decode($data));
    }

    public function confirm() {
        $user = getCookies('user');
        $store = session('store');
        //setCookies('store', $store);
        $deliveryService = new DeliveryRequestService();

        foreach($deliveryService->findStore($store) as $findStore) {
            foreach($deliveryService->getStore($findStore["id"]) as $getStore) {
                $id = $getStore["id"];
                $corporate_name = formatText($getStore["corporate_name"]);
                $trade_name = formatText($getStore["trade_name"]);
            }
        }

        $user = $user ? '/carrinho/entrega' : '/perfil';

        $data = deleteCookie('bag');
        $data = getCookies('bag');

        return view('app.cart.fee.index')
            ->with('link', $user)
            ->with('trade_name', $trade_name)
            ->with('bag', json_decode($data));
    }
}
