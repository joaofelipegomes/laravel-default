<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\DeliveryRequestService;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function profile(Request $request) {
        $store = session('store');
        $user = getCookies('user');

        //setCookies('store', $store);

        $deliveryService = new DeliveryRequestService();

        foreach($deliveryService->findStore($store) as $findStore) {
            foreach($deliveryService->getStore($findStore["id"]) as $getStore) {
                $id = $getStore["id"];
                $corporate_name = formatText($getStore["corporate_name"]);
                $trade_name = formatText($getStore["trade_name"]);
            }
        }

        //echo "User: $user.";

        if ($user) {
            return view('app.profile.index')
            ->with('trade_name', $trade_name);
        } else {
            return view('app.profile.create.index')
            ->with('trade_name', $trade_name);
        }
    }

    public function login() {
        $store = session('store');

        $deliveryService = new DeliveryRequestService();

        foreach($deliveryService->findStore($store) as $findStore) {
            foreach($deliveryService->getStore($findStore["id"]) as $getStore) {
                $id = $getStore["id"];
                $corporate_name = formatText($getStore["corporate_name"]);
                $trade_name = formatText($getStore["trade_name"]);
            }
        }

        return view('app.profile.login.index')
        ->with('trade_name', $trade_name);
    }

    public function verifylogin(Request $request) {
        $store = session('store');

        $credentials = $request->all();
        $json = [
            "username" => $credentials["username"],
            "password" => $credentials["password"],
        ];

        $deliveryService = new DeliveryRequestService();

        foreach($deliveryService->findStore($store) as $findStore) {
            foreach($deliveryService->getStore($findStore["id"]) as $getStore) {
                $id = $getStore["id"];
                $corporate_name = formatText($getStore["corporate_name"]);
                $trade_name = formatText($getStore["trade_name"]);
            }
        }

        foreach($deliveryService->findUser($json) as $findUser) {
            $id = $findUser["id"];
            $authentication = boolval($findUser["authentication"]);
            $verified = $findUser["verified"];

            setCookies("user", $id);

            return redirect('/perfil')
                ->with('trade_name', $trade_name);
        }
    }

    public function createUser(Request $request) {
        $store = session('store');

        $credentials = $request->all();
        $json = [
            "name" => $credentials["name"],
            "email" => $credentials["email"],
            "phone" => $credentials["phone"],
            "password" => $credentials["password"],
        ];

        $deliveryService = new DeliveryRequestService();

        foreach($deliveryService->findStore($store) as $findStore) {
            foreach($deliveryService->getStore($findStore["id"]) as $getStore) {
                $id = $getStore["id"];
                $corporate_name = formatText($getStore["corporate_name"]);
                $trade_name = formatText($getStore["trade_name"]);
            }
        }

        $deliveryService->createUser($json);
        $json_find = [
            "username" => $credentials["email"],
            "password" => $credentials["password"],
        ];

        foreach($deliveryService->findUser($json_find) as $findUser) {
            $id = $findUser["id"];
            $authentication = boolval($findUser["authentication"]);
            $verified = $findUser["verified"];

            setCookies("user", $id);

            return redirect('/perfil')
                ->with('trade_name', $trade_name);
        }
    }

    public function logout() {
        $store = session('store');
        deleteCookie("user");

        Cookie::queue(
            Cookie::forget('user')
        );

        $deliveryService = new DeliveryRequestService();

        foreach($deliveryService->findStore($store) as $findStore) {
            foreach($deliveryService->getStore($findStore["id"]) as $getStore) {
                $id = $getStore["id"];
                $corporate_name = formatText($getStore["corporate_name"]);
                $trade_name = formatText($getStore["trade_name"]);
            }
        }

        return redirect('/perfil')
                ->with('trade_name', $trade_name);
    }
}
