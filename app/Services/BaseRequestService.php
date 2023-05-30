<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class BaseRequestService
{
  private function makeRequest()
  {
    // ak_live_hlW39hjS94aSgH3ZVX4QmJRQTWWUyC
    // ak_test_KnxGmTuQJJ82rbAlU4pS0bpia7F0Vc
    return Http::withBasicAuth('ak_test_KnxGmTuQJJ82rbAlU4pS0bpia7F0Vc', "x");
  }

  private function getUri($action)
  {
    return sprintf("%s%s", "https://api.pagar.me/1/", $action);
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
