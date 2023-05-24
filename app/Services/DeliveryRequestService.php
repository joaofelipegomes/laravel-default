<?php

namespace App\Services;

class DeliveryRequestService extends BaseRequestServiceDelivery
{
  public function findStore($text)
  {
    return $this->get(sprintf('%s/%s?%s=%s', 'store', 'find', 'search', $text));
  }

  public function findUser($body)
  {
    return $this->post(sprintf('%s/%s', 'client', 'auth'), $body);
  }

  public function createUser($body)
  {
    return $this->post(sprintf('%s/%s', 'client', 'create'), $body);
  }

  public function getStore($id)
  {
    return $this->get(sprintf('%s/%s', 'store', $id));
  }

  public function getCategories($id)
  {
    return $this->get(sprintf('%s/%s/%s', 'store', $id, 'categories'));
  }

  public function getProducts($id)
  {
    return $this->get(sprintf('%s/%s/%s', 'store', $id, 'products'));
  }

  public function getProduct($store, $id)
  {
    return $this->get(sprintf('%s/%s/%s/%s', 'store', $store, 'products', $id));
  }

  public function getStoreStus($store)
  {
    return $this->get(sprintf('%s/%s/%s', 'store', $store, 'status'));
  }
}
