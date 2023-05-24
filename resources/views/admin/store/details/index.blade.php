@extends('admin._templates.default.index')
@section('title', isset($store) ? normalizeText($store['trade_name']) : 'Criar loja')

@section('body')
<section id="swup" class="transition-fade">
  <div class="store-container">
    <div>
      <form key="{{ isset($id) ? $id : '' }}">
        <div>
          <div class="store-info-container">
            <div class="section-title">{{ isset($store) ? 'Dados da loja' : 'Criar loja' }}</div>
            <div>
              <div name="trade-name-container">
                <label class="label-title">Nome da loja</label>
                <div>
                  <input name="trade-name" type="text" value="{{ isset($store) ? normalizeText($store['trade_name']) : '' }}" autocomplete="off">
                </div>
              </div>

              <div name="corporate-name-container">
                <label class="label-title">Razão social</label>
                <div>
                  <input name="corporate-name" type="text" value="{{ isset($store) ? normalizeText($store['corporate_name']) : '' }}" autocomplete="off">
                </div>
              </div>

              <div name="document-container">
                <label class="label-title">Documento da loja</label>
                <div>
                  <input type="text" name="document-number" value="{{ isset($store) ? formatCnpjCpf($store['document_number']) : '' }}" autocomplete="off">
                </div>
              </div>

              <div name="state-registration-container">
                <label class="label-title">Inscrição Estadual</label>
                <div>
                  <input type="text" name="state-registration" value="{{ isset($store) ? somenteNumeros($store['state_registration']) : '' }}" autocomplete="off">
                </div>
              </div>

              <div name="situation-container">
                <label class="label-title">Situação</label>
                <div>
                  <select name="situation" autocomplete="off">
                    <option value="" {{ !isset($store) ? 'selected' : '' }} disabled>Selecione</option>
                    @foreach($list_status as $s)
                    <option {{ isset($store) ? ($store['type']==$s->id) ? 'selected' : '' : '' }} value="{{ normalizeText($s->id) }}">{{ normalizeText($s->name) }}</option>
                    @endforeach
                    <option value="99">Inativo</option>
                  </select>
                </div>
              </div>

              <div name="product-container">
                <label class="label-title">Produto</label>
                <div>
                  <select name="product" autocomplete="off">
                    <option value="" {{ !isset($store) ? 'selected' : '' }} disabled>Selecione</option>
                    @foreach($list_products as $s)
                    <option {{ isset($store) ? ($store['product_id']==$s->id) ? 'selected' : '' : '' }} value="{{ normalizeProduct($s->id) }}">{{ normalizeProduct($s->name) }}</option>
                    @endforeach
                  </select>
                </div>
              </div>

              <div name="responsible-container">
                <label class="label-title">Responsável</label>
                <div>
                  <input name="responsible" type="text" autocomplete="off" value="{{ isset($store) ? normalizeText($store['contact']) : '' }}">
                </div>
              </div>

              <div name="phone-container">
                <label class="label-title">Telefone</label>
                <div>
                  <input name="phone" type="text" autocomplete="off" value="{{ isset($store) ? formatPhoneNumber($store['phone']) : '' }}">
                </div>
              </div>

              <div name="amount-container">
                <label class="label-title">E-mail</label>
                <div>
                  <input name="email" type="text" autocomplete="off" value="{{ isset($store) ? strtolower($store['email']) : ''}}">
                </div>
              </div>

              <div name="entered-at-container">
                <label class="label-title">Data de entrada</label>
                <div>
                  <input name="entered-at" type="text" autocomplete="off" value="{{ isset($store) ? dateFormat($store['entered_at']) : '' }}">
                </div>
              </div>
            </div>
          </div>

          <div class="store-info-container no-border larger-bottom">
            <div class="section-title">Endereço</div>
            <div>
              <div name="zipcode-container">
                <label class="label-title">Código postal</label>
                <div>
                  <input name="zipcode" type="text" autocomplete="off" value="{{ isset($store) ? formatZipCode($store['zipcode']) : '' }}">
                </div>
              </div>

              <div name="address-container">
                <label class="label-title">Endereço</label>
                <div>
                  <input name="address" type="text" autocomplete="off" value="{{ isset($store) ? normalizeText($store['address']) : '' }}">
                </div>
              </div>

              <div name="house-number-container">
                <label class="label-title">Número</label>
                <div>
                  <input name="house-number" type="text" autocomplete="off" value="{{ isset($store) ? normalizeText($store['house_number']) : '' }}">
                </div>
              </div>

              <div name="neighborhood-container">
                <label class="label-title">Bairro</label>
                <div>
                  <input name="neighborhood" type="text" autocomplete="off" placeholder="" value="{{ isset($store) ? normalizeText($store['neighborhood']) : '' }}">
                </div>
              </div>

              <div name="state-container">
                <label class="label-title">Estado</label>
                <div>
                  <select name="state" autocomplete="off">
                    <option value="" {{ !isset($store) ? 'selected' : '' }} disabled>Selecione</option>
                    <option value="AC" {{ isset($store) ? ('AC' === $store['state']) ? 'selected' : '' : '' }}>Acre</option>
                    <option value="AL" {{ isset($store) ? ('AL' === $store['state']) ? 'selected' : '' : '' }}>Alagoas</option>
                    <option value="AP" {{ isset($store) ? ('AP' === $store['state']) ? 'selected' : '' : '' }}>Amapá</option>
                    <option value="AM" {{ isset($store) ? ('AM' === $store['state']) ? 'selected' : '' : '' }}>Amazonas</option>
                    <option value="BA" {{ isset($store) ? ('BA' === $store['state']) ? 'selected' : '' : '' }}>Bahia</option>
                    <option value="CE" {{ isset($store) ? ('CE' === $store['state']) ? 'selected' : '' : '' }}>Ceará</option>
                    <option value="DF" {{ isset($store) ? ('DF' === $store['state']) ? 'selected' : '' : '' }}>Distrito Federal</option>
                    <option value="ES" {{ isset($store) ? ('ES' === $store['state']) ? 'selected' : '' : '' }}>Espírito Santo</option>
                    <option value="GO" {{ isset($store) ? ('GO' === $store['state']) ? 'selected' : '' : '' }}>Goiás</option>
                    <option value="MA" {{ isset($store) ? ('MA' === $store['state']) ? 'selected' : '' : '' }}>Maranhão</option>
                    <option value="MT" {{ isset($store) ? ('MT' === $store['state']) ? 'selected' : '' : '' }}>Mato Grosso</option>
                    <option value="MS" {{ isset($store) ? ('MS' === $store['state']) ? 'selected' : '' : '' }}>Mato Grosso do Sul</option>
                    <option value="MG" {{ isset($store) ? ('MG' === $store['state']) ? 'selected' : '' : '' }}>Minas Gerais</option>
                    <option value="PA" {{ isset($store) ? ('PA' === $store['state']) ? 'selected' : '' : '' }}>Pará</option>
                    <option value="PB" {{ isset($store) ? ('PB' === $store['state']) ? 'selected' : '' : '' }}>Paraíba</option>
                    <option value="PR" {{ isset($store) ? ('PR' === $store['state']) ? 'selected' : '' : '' }}>Paraná</option>
                    <option value="PE" {{ isset($store) ? ('PE' === $store['state']) ? 'selected' : '' : '' }}>Pernambuco</option>
                    <option value="PI" {{ isset($store) ? ('PI' === $store['state']) ? 'selected' : '' : '' }}>Piauí</option>
                    <option value="RJ" {{ isset($store) ? ('RJ' === $store['state']) ? 'selected' : '' : '' }}>Rio de Janeiro</option>
                    <option value="RN" {{ isset($store) ? ('RN' === $store['state']) ? 'selected' : '' : '' }}>Rio Grande do Norte</option>
                    <option value="RS" {{ isset($store) ? ('RS' === $store['state']) ? 'selected' : '' : '' }}>Rio Grande do Sul</option>
                    <option value="RO" {{ isset($store) ? ('RO' === $store['state']) ? 'selected' : '' : '' }}>Rondônia</option>
                    <option value="RR" {{ isset($store) ? ('RR' === $store['state']) ? 'selected' : '' : '' }}>Roraima</option>
                    <option value="SC" {{ isset($store) ? ('SC' === $store['state']) ? 'selected' : '' : '' }}>Santa Catarina</option>
                    <option value="SP" {{ isset($store) ? ('SP' === $store['state']) ? 'selected' : '' : '' }}>São Paulo</option>
                    <option value="SE" {{ isset($store) ? ('SE' === $store['state']) ? 'selected' : '' : '' }}>Sergipe</option>
                    <option value="TO" {{ isset($store) ? ('TO' === $store['state']) ? 'selected' : '' : '' }}>Tocantins</option>
                    <option value="EX" {{ isset($store) ? ('EX' === $store['state']) ? 'selected' : '' : '' }}>Estrangeiro</option>
                  </select>
                </div>
              </div>

              <div name="city-container">
                <label class="label-title">Cidade</label>
                <div>
                  <input name="city" type="text" autocomplete="off" value="{{ isset($store) ? normalizeText($store['city']) : '' }}">
                </div>
              </div>
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
<script src="{{ asset('js/store.js') }}"></script>
@stop
