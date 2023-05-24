<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Delivery\HomeController;
use App\Http\Controllers\Delivery\ProductController;
use App\Http\Controllers\Delivery\CartController;
use App\Http\Controllers\Delivery\ProfileController;

Route::get(
  '/',
  function () {
    return 'oi';
  }
);
