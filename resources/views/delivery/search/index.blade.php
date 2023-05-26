@section("title", $trade_name)
@extends('delivery._templates.default.index')

@section("body")
<div id="swup" class="main-container no-padding swup-transition-fade">
  <div class="item-container">
    <div class="back-container">
      <a href="/delivery/{{ getCookies('store') }}" class="back-navigator">
        <span class="material-symbols-outlined weight">arrow_back_ios</span>
      </a>
    </div>
  </div>

  <div class="content-container">
    <div class="group-search">
      <div class="search-container">
        <a href="/delivery/flordavila/buscar" class="search">
          <span class="material-symbols-outlined">search</span>
          <p>Buscar na Flor da Vila Mini Salgados</p>
        </a>
      </div>
    </div>
  </div>
</div>
@stop

<script src="{{ asset('js/delivery/search.js') }}"></script>
