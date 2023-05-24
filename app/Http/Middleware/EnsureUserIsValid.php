<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsValid
{
  protected $route;

  public function __construct(Route $route)
  {
    $this->route = $route;
  }

  public function handle(Request $request, Closure $next): Response
  {
    $userInovaAdmin = returnCookie('userInovaAdmin');

    if (!$userInovaAdmin) {
      return redirect('/admin/entrar');
    } else {
      return $next($request);
    }
  }
}
