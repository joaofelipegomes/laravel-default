@extends('admin._templates.default.index')
@section('title', 'Criar loja')

@section('body')
<section>
  <div class="store-container">
    <div>
      <form>
        <div>
          <div class="store-info-container no-border">
            <div class="section-title">Criar loja</div>
            <div>
              <div name="trade-name-container">
                <label class="label-title">Nome da loja</label>
                <div>
                  <input name="trade-name" type="text" value="">
                </div>
              </div>

              <div name="line-of-business-container">
                <label name="label-title">Ramo de atividade</label>
                <div>
                  <select name="line-of-business" autocomplete="off">
                    <option value="" disabled selected></option>
                    @foreach($array_line_of_business as $category)
                    <option value="{{ $category->id }}">{{ $category->description }}</option>
                    @endforeach
                  </select>
                </div>
              </div>

              <div name="document-number-container">
                <label class="label-title">Número da loja</label>
                <div>
                  <input type="text" name="document-number" value="" autocomplete="off">
                </div>
              </div>

              <div name="priority-container">
                <label class="label-title">Prioridade da loja</label>
                <div>
                  <ul>
                    <li>
                      <input checked type="radio" id="minimum" name="priority" value="1" class="peer">
                      <label for="minimum" class="peer-checked:border-gray-600 peer-checked:text-gray-600 hover:text-gray-600">
                        <div>
                          <div>Mínima</div>
                        </div>
                      </label>
                    </li>
                    <li>
                      <input type="radio" id="low" name="priority" value="2" class="peer">
                      <label for="low" class="peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-blue-600">
                        <div>
                          <div>Baixa</div>
                        </div>
                      </label>
                    </li>
                    <li>
                      <input type="radio" id="normal" name="priority" value="3" class="peer">
                      <label for="normal" class="peer-checked:border-green-600 peer-checked:text-green-600 hover:text-green-600">
                        <div>
                          <div>Normal</div>
                        </div>
                      </label>
                    </li>
                    <li>
                      <input type="radio" id="high" name="priority" value="4" class="peer">
                      <label for="high" class="peer-checked:border-yellow-600 peer-checked:text-yellow-600 hover:text-yellow-600">
                        <div>
                          <div>Alta</div>
                        </div>
                      </label>
                    </li>
                    <li>
                      <input type="radio" id="urgent" name="priority" value="5" class="peer">
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
                    <option value="" selected disabled>Selecione</option>
                    <option value="Bronze">Bronze (Antigo)</option>
                    <option value="Prata">Prata (Antigo)</option>
                    <option value="Ouro">Ouro (Antigo)</option>
                    <option value="Lite">Lite (Descontinuado)</option>
                    <option value="Store">Store</option>
                    <option value="Gold">Gold</option>
                    <option value="Prime">Prime</option>
                    <option value="Platinum">Platinum</option>
                  </select>
                </div>
              </div>

              <div name="cycle-container">
                <label class="label-title">Tipo de pagamento</label>
                <div>
                  <select name="cycle" autocomplete="off">
                    <option value="" selected disabled>Selecione</option>
                    <option value="Mensal">Mensal</option>
                    <option value="Trimestral">Trimestral</option>
                    <option value="Semestral">Semestral</option>
                    <option value="Anual">Anual</option>
                  </select>
                </div>
              </div>

              <div name="amount-container">
                <label class="label-title">Valor do pagamento</label>
                <div>
                  <input name="amount" type="text" autocomplete="off" value="">
                </div>
              </div>

              <div name="renew-container">
                <label class="label-title">Mês da renovação</label>
                <div>
                  <div>
                    <select name="renew-1" autocomplete="off">
                      <option selected disabled>Selecione</option>
                      <option>Janeiro</option>
                      <option>Fevereiro</option>
                      <option>Março</option>
                      <option>Abril</option>
                      <option>Maio</option>
                      <option>Junho</option>
                      <option>Julho</option>
                      <option>Agosto</option>
                      <option>Setembro</option>
                      <option>Agosto</option>
                      <option>Setembro</option>
                      <option>Outubro</option>
                      <option>Novembro</option>
                      <option>Dezembro</option>
                    </select>
                  </div>
                  <div>
                    <select name="renew-2" autocomplete="off">
                      <option selected disabled>Selecione</option>
                      <option>Janeiro</option>
                      <option>Fevereiro</option>
                      <option>Março</option>
                      <option>Abril</option>
                      <option>Maio</option>
                      <option>Junho</option>
                      <option>Julho</option>
                      <option>Agosto</option>
                      <option>Setembro</option>
                      <option>Agosto</option>
                      <option>Setembro</option>
                      <option>Outubro</option>
                      <option>Novembro</option>
                      <option>Dezembro</option>
                    </select>
                  </div>
                </div>
              </div>

              <div name="renew-day-container">
                <label class="label-title">Dia da renovação</label>
                <div>
                  <select name="renew-day" autocomplete="off">
                    <option selected disabled>Selecione</option>
                    <option>10</option>
                    <option>15</option>
                    <option>20</option>
                    <option>30</option>
                  </select>
                </div>
              </div>

              <div name="due-date-container">
                <label class="label-title">Data do vencimento</label>
                <div>
                  <input name="due-date" type="text" autocomplete="off" value="">
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="actions">
          <div>
            <button type="button" class="cancel">Cancelar</button>
            <button type="button" class="save" name="save">Criar loja</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</section>

<script src="{{ asset('js/activation-store-create.js') }}"></script>
@stop