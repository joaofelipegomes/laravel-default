<?php

namespace App\Services;

class KeyRequestService extends BaseRequestServiceKey
{
  public function key($document_number, $trade_name, $due_date)
  {
    return $this->get(sprintf("%s/%s?%s=%s&%s=%s&%s=%s", "chave", "set", "document_number", $document_number, 'trade_name', $trade_name, 'due_date', $due_date));
  }
}
