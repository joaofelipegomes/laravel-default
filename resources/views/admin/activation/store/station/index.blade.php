@extends('admin._templates.default.index')
@section('title', 'Estação')

@section('body')
<section>
  <div class="store-container">
    <div>
      <form>
        <div>
          <div class="store-info-container no-border">
            <div class="section-title">Estação</div>
            <div class="station">
              <div name="station-server-container">
                <label class="label-title">Servidor</label>
                <div>
                  <select name="station-server" autocomplete="off">
                    <option value="" {{ isset($station->server) ? '' : 'selected' }} disabled>Selecione</option>
                    <option value="true" {{ isset($station->server) ? ($station->server) ? 'selected' : '' : '' }}>Sim</option>
                    <option value="false" {{ isset($station->server) ? (!$station->server) ? 'selected' : '' : '' }}>Não</option>
                  </select>
                </div>
              </div>

              <div name="station-name-container">
                <label class="label-title">Nome</label>
                <div>
                  <input name="station-name" type="text" autocomplete="off" placeholder="" value="{{ isset($station->description) ? $station->description : '' }}">
                </div>
              </div>

              <div name="station-number-container">
                <label class="label-title">Série HD</label>
                <div>
                  <input name="station-number" type="text" autocomplete="off" value="{{ isset($station->serial) ? $station->serial : '' }}" id="{{ isset($station->station_id) ? $station->station_id : '' }}" store="{{ $store_id }}">
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

<script src="{{ asset('js/activation-station.js') }}"></script>
@stop