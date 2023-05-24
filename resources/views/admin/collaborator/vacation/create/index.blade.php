@extends('admin._templates.default.index')
@section('title', 'Criar férias')

@section('body')
<section>
  <div class="store-container">
    <div>
      <form>
        <div>
          <div class="store-info-container no-border">
            <div class="section-title">{{ isset($id) ? 'Atualizar férias' : 'Criar férias'  }}</div>
            <div class="vacation">

              <div name="collaborator-container">
                <label class="label-title">Colaborador</label>
                <div>
                  <select name="collaborator" autocomplete="off" id="{{ isset($id) ? $id : ''  }}">
                    <option value="" selected disabled>Selecione</option>
                    @foreach($users as $user)
                    <option {{ (isset($vacation[0]->collaborator)) ? ($vacation[0]->collaborator ==  $user->name) ? 'selected' : '' : '' }} value="{{ $user->name }}">{{ $user->name }}</option>
                    @endforeach
                  </select>
                </div>
              </div>

              <div name="days-container">
                <label class="label-title">Quantidade em dias</label>
                <div>
                  <input type="text" name="days" value="{{ (isset($vacation[0]->days)) ? $vacation[0]->days . ' dias' : '' }}" autocomplete="off" placeholder="0 dias">
                </div>
              </div>

              <div name="date-container">
                <label class="label-title">Início da férias</label>
                <div>
                  <input name="start-date" type="text" autocomplete="off" value="{{ (isset($vacation[0]->start_date)) ? dateFormat($vacation[0]->start_date) : '' }}">
                </div>
              </div>

              <div name="date-container">
                <label class="label-title">Fim da férias</label>
                <div>
                  <input name="end-date" type="text" autocomplete="off" value="{{ (isset($vacation[0]->end_date)) ? dateFormat($vacation[0]->end_date) : '' }}">
                </div>
              </div>

              <div name="observations-container">
                <label class="label-title">Observações</label>
                <div>
                  <textarea type="text" name="observations" value="" autocomplete="off">{{ (isset($vacation[0]->observations)) ? $vacation[0]->observations : '' }}</textarea>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="actions">
          <div>
            @php
            if (isset($id)) {
            @endphp
            <button type="button" class="delete" name="delete">Excluir</button>
            @php
            }
            @endphp
            <button type="button" class="cancel">Cancelar</button>
            <button type="button" class="save" name="save">{{ isset($id) ? 'Atualizar férias' : 'Criar férias'  }}</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</section>

<script src="{{ asset('js/vacation-create.js') }}"></script>
@stop