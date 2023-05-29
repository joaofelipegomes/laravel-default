<?php

namespace App\Services;

class PagarMeRequestService extends BaseRequestService
{
  public function storeIsValid($storename)
  {
    return $this->get(sprintf("%s/%s?%s=%s", "store", "find", "search", $storename));
  }

  public function getStore($id)
  {
    return $this->get(sprintf("%s/%s", "store", $id));
  }

  public function getCategories($id)
  {
    return $this->get(sprintf('%s/%s/%s', 'store', $id, 'categories'));
  }

  public function getProducts($id)
  {
    return $this->get(sprintf('%s/%s/%s', 'store', $id, 'products'));
  }

  public function createNewPlan($body)
  {
    return $this->post(sprintf('%s', 'plans'), $body);
  }

  public function createNewSubscription($body)
  {
    return $this->post(sprintf('%s', 'subscriptions'), $body);
  }

  public function updateSubscription($id, $body)
  {
    return $this->put(sprintf('%s/%s', 'subscriptions', $id), $body);
  }

  public function cancelSubscription($id, $body)
  {
    return $this->post(sprintf('%s/%s/%s', 'subscriptions', $id, 'cancel'), $body);
  }

  public function getSubscription($id)
  {
    return $this->get(sprintf('%s/%s', 'subscriptions', $id));
  }
}
