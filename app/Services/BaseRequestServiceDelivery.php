<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class BaseRequestServiceDelivery
{
  private function makeRequest()
  {
    return Http::withBasicAuth(env('API_KEY_DELIVERY'), 'x');
  }

  private function getUri($action)
  {
    return sprintf('%s%s', env('URI_BASE_DELIVERY'), $action);
  }

  protected function get($action)
  {
    return $this->makeRequest()->get($this->getUri($action))->json();
  }

  protected function post($action, $body)
  {
    return $this->makeRequest()->post($this->getUri($action), $body)->json();
  }
}
