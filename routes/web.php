<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CheckController;

Route::get('/', function () {
  return response('', 200)
    ->header('Content-Type', 'text/plain');
});

Route::get(
  '/pagamento/{document?}',
  [CheckController::class, 'checkStore']
);
