<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use DatabaseQueries;

class AuthController extends Controller
{
  public function redirectUser()
  {
    return redirect('/admin/entrar');
  }

  public function userLoggin()
  {
    return view('admin.auth.loggin.index');
  }

  public function userLogout()
  {
    deleteCookie('userInovaAdmin');
    return redirect('/admin/entrar');
  }
}
