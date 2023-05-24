@extends('admin._templates.default.index')
@section('title', 'Férias')

@section('body')
<section>
  <div class="search-container">
    <div>
      <div class="title-page">Férias</div>
      <form action="" method="get">
        <div>
          <div class="add">
            <a href="/admin/colaborador/ferias/criar">
              <span class="material-symbols-outlined">add_circle</span>
            </a>
            <div>
              <span class="material-symbols-outlined">search</span>
              <input type="text" placeholder="Buscar" value="{{ $search }}" name="busca" autocomplete="off">
            </div>
          </div>

          <div class="filters">
            <div>
              <select name="colaborador">
                <option value="">Selecione</option>
                @foreach($users as $user)
                <option {{ ($collaborator == $user->id) ? 'selected' : ''  }} value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="actions">
            <button type="submit" class="button-generate">Buscar</button>
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

        @foreach($vacations as $vacation)
        <a name="vacation" redirect="{{ $vacation['id'] }}">
          <div name="collaborator">
            <div>{{ $vacation['collaborator'] }}</div>
          </div>
          <div name="start_date">
            {{ dateFormat($vacation['start_date']) }}
          </div>
          <div name="end_date">
            {{ dateFormat($vacation['end_date']) }}
          </div>
          <div name="days">
            <div>{{ $vacation['days'] }}</div> dias
          </div>
          <div name="observations">
            <div>{{ $vacation['observations'] }}</div>
          </div>
          <div name="actions" class="">
            <button name="edit">Editar férias</button>
          </div>
        </a>
        @endforeach
      </div>
    </div>
</section>

<script src="{{ asset('js/vacation.js') }}"></script>
@stop