@extends('admin._templates.default.index')
@section('title', 'Ativação')

@section('body')
<section id="swup" class="transition-fade">
  <div class="search-container">
    <div>
      <div class="title-page">Ativação</div>
      <form action="" method="get">
        <div>
          <div class="add">
            <a href="/admin/ativacao/rapida">
              <span class="material-symbols-outlined">offline_bolt</span>
            </a>
            <a href="/admin/ativacao/loja/criar" class="-ml-1">
              <span class="material-symbols-outlined">add_circle</span>
            </a>
            <div>
              <span class="material-symbols-outlined">search</span>
              <input type="text" placeholder="Buscar" value="{{ $search }}" name="busca" autocomplete="off">
            </div>
          </div>

          <div class="filters">
            <div>
              <select name="ordem">
                <option {{ (!$order) ? 'selected' : '' }} value="">Selecione</option>
                <option {{ ($order=='alfabetica') ? 'selected' : '' }} value="alfabetica">Alfabética</option>
                <option {{ ($order=='prioridade') ? 'selected' : '' }} value="prioridade">Prioridade</option>
                <option {{ ($order=='vencimento') ? 'selected' : '' }} value="vencimento">Vencimento</option>
              </select>
            </div>
          </div>

          <div class="actions">
            <button type="submit">Buscar</button>
          </div>
        </div>
      </form>

      <div class="list-of-stores">
        <div class="number-displayed">
          <div>
            <span>Mostrando</span>
            <span class="display">{{ $number_of_rows_displayed }}</span>
            <span>de</span>
            <span class="display">{{ $number_of_rows }}</span>
          </div>
        </div>

        @foreach($stores as $store)
        <a name="store" redirect="{{ $store['id'] }}">
          <div name="trade-name" class="{{ ($store['trade_name']) ? '' : 'empty-color' }}">
            <div>
              {{ ($store['trade_name']) ? normalizeText($store['trade_name']) : 'Vazio' }}
            </div>
          </div>
          <div name="document-number" class="{{ ($store['document_number']) ? '' : 'empty-color' }}">
            {{ ($store['document_number']) ? formatCnpjCpf($store['document_number']) : 'Vazio' }}
          </div>
          <div name="priority">
            <div>
              {{ ($store['priority']) ? $store['priority'] : 0 }}
            </div>
          </div>
          <div name="validation_next_date_promotion" class="{{ ($store['validation_next_date_promotion']) ? '' : 'empty-color' }}">
            {{ ($store['validation_next_date_promotion']) ? dateFormat($store['validation_next_date_promotion']) : 'Vazio' }}
          </div>
          <div name="key">
            @php $key = (($store['serial']) && ($store['validation_next_date_promotion'])) ? generateKey($store['serial'], $store['validation_next_date_promotion']) : ''; echo $key @endphp
            <button name="key" key="{{ $key }}">Copiar chave</button>
          </div>
        </a>
        @endforeach
      </div>
    </div>
</section>

<script src="{{ asset('js/activation.js') }}"></script>
@stop
