@extends('admin._templates.default.index')
@section('title', $trade_name)

@section('body')
<section id="swup" class="transition-fade">
  <div class="store-container">
    <div>
      <form>
        <div>
          <div class="store-info-container">
            <div class="section-title">Dados da loja</div>
            <div>
              <div name="trade-name-container">
                <label class="label-title">Nome da loja</label>
                <div>
                  <input name="trade-name" type="text" value="{{ $trade_name }}" store="{{ $id }}">
                </div>
              </div>

              <div name="line-of-business-container">
                <label class="label-title">Ramo de atividade</label>
                <div>
                  <select name="line-of-business" autocomplete="off">
                    <option value="" disabled selected></option>
                    @foreach($array_line_of_business as $category)
                    <option value="{{ $category->id }}" {{ ($category->id == $line_of_business) ? 'selected' : '' }}>{{ $category->description }}</option>
                    @endforeach
                  </select>
                </div>
              </div>

              <div name="document-number-container">
                <label class="label-title">Documento da loja</label>
                <div>
                  <input type="text" name="document-number" value="{{ $document_number }}" autocomplete="off">
                </div>
              </div>

              <div name="priority-container">
                <label class="label-title">Prioridade da loja</label>
                <div>
                  <ul>
                    <li>
                      <input {{ ($priority == '1') ? 'checked' : '' }} type="radio" id="minimum" name="priority" value="1" class="peer">
                      <label for="minimum" class="peer-checked:border-gray-600 peer-checked:text-gray-600 hover:text-gray-600">
                        <div>
                          <div>Mínima</div>
                        </div>
                      </label>
                    </li>
                    <li>
                      <input {{ ($priority == '2') ? 'checked' : '' }} type="radio" id="low" name="priority" value="2" class="peer">
                      <label for="low" class="peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-blue-600">
                        <div>
                          <div>Baixa</div>
                        </div>
                      </label>
                    </li>
                    <li>
                      <input {{ ($priority == '3') ? 'checked' : '' }} type="radio" id="normal" name="priority" value="3" class="peer">
                      <label for="normal" class="peer-checked:border-green-600 peer-checked:text-green-600 hover:text-green-600">
                        <div>
                          <div>Normal</div>
                        </div>
                      </label>
                    </li>
                    <li>
                      <input {{ ($priority == '4') ? 'checked' : '' }} type="radio" id="high" name="priority" value="4" class="peer">
                      <label for="high" class="peer-checked:border-yellow-600 peer-checked:text-yellow-600 hover:text-yellow-600">
                        <div>
                          <div>Alta</div>
                        </div>
                      </label>
                    </li>
                    <li>
                      <input {{ ($priority == '5') ? 'checked' : '' }} type="radio" id="urgent" name="priority" value="5" class="peer">
                      <label for="urgent" class="peer-checked:border-red-600 peer-checked:text-red-600 hover:text-red-600">
                        <div>
                          <div>Urgente</div>
                        </div>
                      </label>
                    </li>
                  </ul>
                </div>
              </div>

              <div name="plan-container">
                <label class="label-title">Plano atual</label>
                <div>
                  <select name="plan" autocomplete="off">
                    <option value="Bronze" {{ ($plan == 'Bronze') ? 'selected' : '' }}>Bronze (Antigo)</option>
                    <option value="Prata" {{ ($plan == 'Prata') ? 'selected' : '' }}>Prata (Antigo)</option>
                    <option value="Ouro" {{ ($plan == 'Ouro') ? 'selected' : '' }}>Ouro (Antigo)</option>
                    <option value="Lite" {{ ($plan == 'Lite') ? 'selected' : '' }}>Lite (Descontinuado)</option>
                    <option value="Store" {{ ($plan == 'Store') ? 'selected' : '' }}>Store</option>
                    <option value="Gold" {{ ($plan == 'Gold') ? 'selected' : '' }}>Gold</option>
                    <option value="Prime" {{ ($plan == 'Prime') ? 'selected' : '' }}>Prime</option>
                    <option value="Platinum" {{ ($plan == 'Platinum') ? 'selected' : '' }}>Platinum</option>
                  </select>
                </div>
              </div>

              <div name="cycle-container">
                <label class="label-title">Tipo de pagamento</label>
                <div>
                  <select name="cycle" autocomplete="off">
                    <option {{ ($cycle == 'Mensal') ? 'selected' : '' }}>Mensal</option>
                    <option {{ ($cycle == 'Trimestral') ? 'selected' : '' }}>Trimestral</option>
                    <option {{ ($cycle == 'Semestral') ? 'selected' : '' }}>Semestral</option>
                    <option {{ ($cycle == 'Anual') ? 'selected' : '' }}>Anual</option>
                  </select>
                </div>
              </div>

              <div name="amount-container">
                <label class="label-title">Valor do pagamento</label>
                <div>
                  <input name="amount" type="text" autocomplete="off" value="R$ {{ moneyFormat($amount) }}">
                </div>
              </div>

              <div name="renew-container">
                <label class="label-title">Mês da renovação</label>
                <div>
                  <div>
                    <select name="renew-1" autocomplete="off">
                      <option {{ ($renew_1 == '') ? 'selected' : '' }} disabled></option>
                      <option {{ ($renew_1 == 'Janeiro') ? 'selected' : ''  }}>Janeiro</option>
                      <option {{ ($renew_1 == 'Fevereiro') ? 'selected' : ''  }}>Fevereiro</option>
                      <option {{ ($renew_1 == 'Março') ? 'selected' : ''  }}>Março</option>
                      <option {{ ($renew_1 == 'Abril') ? 'selected' : ''  }}>Abril</option>
                      <option {{ ($renew_1 == 'Maio') ? 'selected' : ''  }}>Maio</option>
                      <option {{ ($renew_1 == 'Junho') ? 'selected' : ''  }}>Junho</option>
                      <option {{ ($renew_1 == 'Julho') ? 'selected' : ''  }}>Julho</option>
                      <option {{ ($renew_1 == 'Agosto') ? 'selected' : ''  }}>Agosto</option>
                      <option {{ ($renew_1 == 'Setembro') ? 'selected' : ''  }}>Setembro</option>
                      <option {{ ($renew_1 == 'Agosto') ? 'selected' : ''  }}>Agosto</option>
                      <option {{ ($renew_1 == 'Setembro') ? 'selected' : ''  }}>Setembro</option>
                      <option {{ ($renew_1 == 'Outubro') ? 'selected' : ''  }}>Outubro</option>
                      <option {{ ($renew_1 == 'Novembro') ? 'selected' : ''  }}>Novembro</option>
                      <option {{ ($renew_1 == 'Dezembro') ? 'selected' : ''  }}>Dezembro</option>
                    </select>
                  </div>
                  <div>
                    <select name="renew-2" autocomplete="off">
                      <option {{ ($renew_2 == '') ? 'selected' : '' }} disabled></option>
                      <option {{ ($renew_2 == 'Janeiro') ? 'selected' : ''  }}>Janeiro</option>
                      <option {{ ($renew_2 == 'Fevereiro') ? 'selected' : ''  }}>Fevereiro</option>
                      <option {{ ($renew_2 == 'Março') ? 'selected' : ''  }}>Março</option>
                      <option {{ ($renew_2 == 'Abril') ? 'selected' : ''  }}>Abril</option>
                      <option {{ ($renew_2 == 'Maio') ? 'selected' : ''  }}>Maio</option>
                      <option {{ ($renew_2 == 'Junho') ? 'selected' : ''  }}>Junho</option>
                      <option {{ ($renew_2 == 'Julho') ? 'selected' : ''  }}>Julho</option>
                      <option {{ ($renew_2 == 'Agosto') ? 'selected' : ''  }}>Agosto</option>
                      <option {{ ($renew_2 == 'Setembro') ? 'selected' : ''  }}>Setembro</option>
                      <option {{ ($renew_2 == 'Agosto') ? 'selected' : ''  }}>Agosto</option>
                      <option {{ ($renew_2 == 'Setembro') ? 'selected' : ''  }}>Setembro</option>
                      <option {{ ($renew_2 == 'Outubro') ? 'selected' : ''  }}>Outubro</option>
                      <option {{ ($renew_2 == 'Novembro') ? 'selected' : ''  }}>Novembro</option>
                      <option {{ ($renew_2 == 'Dezembro') ? 'selected' : ''  }}>Dezembro</option>
                    </select>
                  </div>
                </div>
              </div>

              <div name="renew-day-container">
                <label class="label-title">Dia da renovação</label>
                <div>
                  <select name="renew-day" autocomplete="off">
                    <option {{ ($renew_date == '') ? 'selected' : '' }} disabled></option>
                    <option {{ ($renew_date == '10') ? 'selected' : '' }}>10</option>
                    <option {{ ($renew_date == '15') ? 'selected' : '' }}>15</option>
                    <option {{ ($renew_date == '20') ? 'selected' : '' }}>20</option>
                    <option {{ ($renew_date == '30') ? 'selected' : '' }}>30</option>
                  </select>
                </div>
              </div>

              <div name="due-date-container">
                <label class="label-title">Data do vencimento</label>
                <div>
                  <input name="due-date" type="text" autocomplete="off" value="{{ dateFormat($next_date_validation) }}">
                </div>
              </div>
            </div>
          </div>

          <div class="store-info-container">
            <div class="section-title">Assinatura</div>
            <div>
              <div name="subscription-status-container">
                <div>
                  <div class="checkbox-container">
                    <input id="subscription-status" name="subscription-status" type="checkbox" {{ $pagarme_status }}>
                  </div>
                  <div class="info-container">
                    <label for="subscription-status">Assinatura ativa</label>
                    <p for="subscription-status">A assinatura habilita o cliente à resolver questões financeiras de forma automatizada.</p>
                  </div>
                </div>
              </div>

              <div name="subscription-document-container">
                <label class="label-title">Documento</label>
                <div>
                  <input name="subscription-document" type="text" autocomplete="off" value="{{ $pagarme_document }}">
                </div>
              </div>

              <div name="subscription-amount-container">
                <label class="label-title">Valor do pagamento</label>
                <div>
                  <input name="subscription-amount" type="text" autocomplete="off" value="R$ {{ moneyFormat($pagarme_amount) }}">
                </div>
              </div>

              <div name="subscription-cycle-container">
                <label class="label-title">Tipo do pagamento</label>
                <div>
                  <select name="subscription-cycle" autocomplete="off">
                    <option value="" {{ (!$pagarme_cycle) ? 'selected' : '' }} disabled>Selecione</option>
                    <option {{ ($pagarme_cycle == '30') ? 'selected' : '' }} value="30">Mensal</option>
                    <option {{ ($pagarme_cycle == '90') ? 'selected' : '' }} value="90">Trimestral</option>
                    <option {{ ($pagarme_cycle == '180') ? 'selected' : '' }} value="180">Semestral</option>
                    <option {{ ($pagarme_cycle == '360') ? 'selected' : '' }} value="360">Anual</option>
                  </select>
                </div>
              </div>

              <div name="subscription-free-trail-container">
                <label class="label-title">Dias de teste</label>
                <div>
                  <input name="subscription-free-trail" type="text" autocomplete="off" placeholder="0" value="{{ ($pagarme_free_trial) ? $pagarme_free_trial : '' }}">
                </div>
              </div>

              <div name="subscription-email-container">
                <label class="label-title">E-mail de notificação</label>
                <div>
                  <input name="subscription-email" type="email" autocomplete="off" value="{{ ($pagarme_email) ? $pagarme_email : '' }}" {{ ($pagarme_status == 'checked') ? 'disabled' : '' }}>
                </div>
              </div>
            </div>
          </div>

          <div class="store-info-container">
            <div class="section-title plus">
              <span>Estações</span>
              <a href="/admin/ativacao/loja/{{ $id }}/estacao">
                <span class="material-symbols-outlined">add_circle</span>
              </a>
            </div>

            <div class="list">
              @foreach($stations as $station)
              <div>
                <div>
                  <div name="description">
                    <div>
                      {{ normalizeText($station->description) }}
                    </div>
                  </div>

                  <div name="serial">
                    {{ $station->serial }}
                  </div>

                  <div name="server">
                    @php if ($station->server == '1') { @endphp
                    <div>
                      {{ ($station->server == '1') ? 'Servidor' : '' }}
                    </div>
                    @php } @endphp
                  </div>

                  <div name="key">
                    @php $key = generateKey($station->serial, $next_date_validation); if ($station->server == '1') echo $key @endphp
                  </div>

                  <div name="actions">
                    <button type="button" class="update" name="station-update" station="{{ $station->station_id }}">Alterar</button>
                    <button type="button" key="{{ ($station->server == '1') ? $key : '' }}" name="key" class="save">Copiar chave</button>
                  </div>
                </div>
              </div>
              @endforeach
            </div>
          </div>

          <div class="store-info-container no-border">
            <div class="section-title plus">
              <span>Lojas vinculadas</span>
              <a href="/admin/ativacao/loja/{{ $id }}/vincular">
                <span class="material-symbols-outlined">add_circle</span>
              </a>
            </div>

            <div class="list">
              @foreach($linked_stores as $linked)
              <div>
                <a>
                  <div name="linked-trade-name">
                    <div>
                      {{ $linked['trade_name'] }}
                    </div>
                  </div>

                  <div name="linked-document-number">
                    {{ $linked['document_number'] }}
                  </div>

                  <div name="actions">
                    <button class="delete">Excluir</button>
                  </div>
                </a>
              </div>
              @endforeach
            </div>
          </div>
        </div>

        <div class="actions">
          <div>
            <button type="button" class="delete">Excluir</button>
            <button type="button" class="cancel">Cancelar</button>
            <button type="button" class="save" name="save">Saltar alterações</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</section>

<script src="{{ asset('js/validate.js') }}"></script>
<script src="{{ asset('js/activation-store.js') }}"></script>
@stop
