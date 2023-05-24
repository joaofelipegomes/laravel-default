<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsLogged
{
  public function handle(Request $request, Closure $next): Response
  {
    $userInovaAdmin = returnCookie('userInovaAdmin');

    if ($userInovaAdmin) {
      return redirect('/admin/painel');
    }

    return $next($request);
  }
}
