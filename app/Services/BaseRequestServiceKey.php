<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class BaseRequestServiceKey
{
  private function makeRequest()
  {
    return Http::withBasicAuth('1', "x");
  }

  private function getUri($action)
  {
    return sprintf("%s%s", "https://www.solucoesinova.com.br/", $action);
  }

  protected function get($action)
  {
    return $this->makeRequest()->get($this->getUri($action))->json();
  }

  protected function post($action, $body)
  {
    return $this->makeRequest()->post($this->getUri($action), $body)->json();
  }

  protected function put($action, $body)
  {
    return $this->makeRequest()->put($this->getUri($action), $body)->json();
  }
}
