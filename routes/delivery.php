<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Delivery\HomeController;
use App\Http\Controllers\Delivery\ProductController;
use App\Http\Controllers\Delivery\CartController;
use App\Http\Controllers\Delivery\ProfileController;

Route::get('/teste', function () {
  return view('app.welcome');
});

Route::get('/', function () {
  return view('app.home.index');
});

Route::get(
  '/{store}/item/{item}',
  [ProductController::class, 'product']
);

Route::get(
  '/{store}/buscar',
  [ProductController::class, 'search']
);

/*Route::get('/carrinho', function () {
  return view('app.cart.index');
});*/

Route::get(
  '/carrinho',
  [CartController::class, 'cart']
);

Route::get(
  '/carrinho/entrega',
  [CartController::class, 'confirm']
);

Route::get(
  '/perfil',
  [ProfileController::class, 'profile']
);

Route::get(
  '/perfil/entrar',
  [ProfileController::class, 'login']
);

Route::post(
  '/profile/auth',
  [ProfileController::class, 'verifylogin']
);

Route::post(
  '/profile/create',
  [ProfileController::class, 'createUser']
);

Route::get(
  '/profile/logout',
  [ProfileController::class, 'logout']
);

Route::get(
  '/{store}',
  [HomeController::class, 'home']
);

/* Internal API */

Route::get(
  '/{store}/status',
  [HomeController::class, 'status']
);

Route::post(
  '/localstorage',
  [CartController::class, 'set']
);

Route::get(
  '/api/localstorage',
  [CartController::class, 'show']
);
