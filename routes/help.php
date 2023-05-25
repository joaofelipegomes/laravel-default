<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Help\HomeController;

Route::get('/', function () {
  return redirect('https://www.inovasistemas.com.br');
});

Route::get(
  '/',
  [HomeController::class, 'home']
);
