<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsLoggedOS
{
  protected $route;

  public function __construct(Route $route)
  {
    $this->route = $route;
  }

  public function handle(Request $request, Closure $next): Response
  {
    $userInovaOS = returnCookie('userInovaOS');

    if (!$userInovaOS) {
      return redirect('/suporte/entrar');
    } else {
      return $next($request);
    }
  }
}
