<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Help\HomeController;

Route::get(
  '/',
  [HomeController::class, 'home']
);
