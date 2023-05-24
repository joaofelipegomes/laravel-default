<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CheckController extends Controller
{
  public static function checkStore(Request $request)
  {
    $document = (isset($request['loja']))
    ? $request['loja']
    : '';

    return view('admin.check.index')
    ->with([
      'document' => $document
    ]);
  }
}
