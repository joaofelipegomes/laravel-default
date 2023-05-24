@extends('admin._templates.default.index')
@section('title', 'Ponto')

@section('body')
<section>
  <div class="search-container">
    <div>
      <div class="title-page">Ponto</div>
      <form action="" method="get">
        <div>
          <div class="filters punched-clock">
            <div>
              <select name="colaborador">
                <option value="">Selecione</option>
                @foreach($users as $user)
                <option {{ ($collaborator == $user->id) ? 'selected' : ''  }} value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="calendar-filter">
            <div>
              <span class="material-symbols-outlined">
                calendar_today
              </span>
              <input type="text" placeholder="" value="{{ $start_date }}" name="inicio" autocomplete="off">
            </div>
          </div>

          <div class="calendar-filter">
            <div>
              <span class="material-symbols-outlined">
                calendar_today
              </span>
              <input type="text" placeholder="" value="{{ $end_date }}" name="fim" autocomplete="off">
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

        @foreach($punched_clock as $punched)
        <div class="punched-item" key="{{ $punched['id'] }}">
          <div name="name">
            <div>{{ $punched['name'] }}</div>
          </div>
          <div name="start">
            <input type="text" autocomplete="off" value="{{ dateFullFormat($punched['start']) }}" class="w-full py-1 bg-[#e8e8ed]/50 px-3 rounded-lg text-center focus:outline-none focus:ring-2 focus:ring-blue-300" name="punched-start">
          </div>
          <div name="end">
            <input date="{{ $punched['end'] }}" type="text" autocomplete="off" value="{{ ($punched['end']) ? dateFullFormat($punched['end']) : '' }}" class="w-full py-1 bg-[#e8e8ed]/50 px-3 rounded-lg text-center focus:outline-none focus:ring-2 focus:ring-blue-300" name="punched-end">
          </div>
          <div name="company">
            <div>{{ ($punched['company'] == 1) ? 'Inova Sistemas' : 'Oficina das Balanças' }}</div>
          </div>
          <div name="duration">
            {{ $punched['duration'] }}
          </div>
          <div name="amount">
            R$ {{ $punched['amount'] }}
          </div>
          <div name="actions">
            <button name="save">Salvar</button>
          </div>
        </div>
        @endforeach
      </div>
    </div>

    <div class="store-container">
      <div>
        <form>
          <div class="actions">
            <div>
              <div class="gap-x-3 sm:gap-x-5 w-full bg-white rounded-2xl px-6 py-3 shadow-sm flex items-center outline-0 hover:outline hover:outline-offset-[-3px] hover:outline-4 outline-zinc-400/10 transition-all duration-300">
                <div class="font-medium text-sm sm:text-base">
                  Soma total
                </div>
                <span class="material-symbols-outlined text-2xl">
                  navigate_next
                </span>
                <div class="text-sm sm:text-base">
                  {{ $total_hours }}
                </div>
                <span class="material-symbols-outlined text-2xl">
                  navigate_next
                </span>
                <div class="text-sm sm:text-base">
                  R$ {{ $amount }}
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
</section>

<script src="{{ asset('js/punchedclock.js') }}"></script>
@stop