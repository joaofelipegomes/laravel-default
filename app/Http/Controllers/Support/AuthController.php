<?php

namespace App\Http\Controllers\Support;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
  public function redirectUser()
  {
    return redirect('/suporte/entrar');
  }

  public function loggin()
  {
    return view('support.auth.loggin.index');
  }
}
