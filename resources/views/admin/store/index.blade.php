@extends('admin._templates.default.index')
@section('title', 'Lojas')

@section('body')
<section>
  <div class="search-container">
    <div>
      <div class="title-page">Lojas</div>

      <form action="" method="get">
        <div>
          <div class="add">
            <a href="/admin/lojas/criar">
              <span class="material-symbols-outlined">add_circle</span>
            </a>
            <div>
              <span class="material-symbols-outlined">search</span>
              <input type="text" placeholder="Buscar" value="{{ $search }}" name="busca" autocomplete="off">
            </div>
          </div>

          <div class="filters">
            <div>
              <select name="status">
                <option {{ (!$status) ? 'selected' : '' }} value="">Selecione</option>
                @foreach($list_status as $s)
                <option {{ ($status==$s->id) ? 'selected' : '' }} value="{{ normalizeText($s->id) }}">{{ normalizeText($s->name) }}</option>
                @endforeach
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

        @foreach($list_clients as $client)
        <a name="store" href="/admin/lojas/{{ $client['id'] }}/detalhes">
          <div name="trade-name"  class="{{ ($client['trade_name']) ? '' : 'empty-color' }}">
            @php $tip = whatTypeItIs($client['type'])  @endphp
            <span title="{{ $tip['name'] }}" class="status-tip" style="background-color: {{ $tip['color'] }}">
            </span>
            <div class="text-hide">
              {{ normalizeText($client['trade_name']) }}
            </div>
          </div>
          <div name="document-number" class="{{ ($client['document_number']) ? '' : 'empty-color' }}">
            {{ ($client['document_number']) ? formatCnpjCpf(somenteNumeros($client['document_number'])) : 'Vazio' }}
          </div>
          <div name="contact" class="{{ ($client['contact']) ? '' : 'empty-color' }}">
            {{ ($client['contact']) ? normalizeText(removeNumbersSpecialChar($client['contact'])) : 'Vazio' }}
          </div>
          <div name="phone" class="{{ ($client['phone']) ? '' : 'empty-color' }}">
            {{ ($client['phone']) ? formatPhoneNumber($client['phone']) : 'Vazio' }}
          </div>
          <div name="type" class="{{ ($client['product']) ? '' : 'empty-color' }}">
            {{ ($client['product']) ? whatProductItIs($client['product']) : 'Vazio' }}
          </div>
          <div name="action">
            <button>Editar</button>
          </div>
        </a>
        @endforeach
      </div>
    </div>
  </div>
</section>
@stop
