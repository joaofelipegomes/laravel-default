<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CheckController;

Route::get('/', function () {
  return redirect('https://www.inovasistemas.com.br');
});

Route::get(
  '/pagamento/{document?}',
  [CheckController::class, 'checkStore']
);
