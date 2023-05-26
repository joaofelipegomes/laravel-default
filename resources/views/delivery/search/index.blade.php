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
    <div class="group-search" style="padding-left: 50px;">
      <div class="search-container">
        <div class="search">
          <span class="material-symbols-outlined">search</span>
          <input type="text" name="search" value="" placeholder="Digite sua buscas">
        </div>
      </div>
    </div>
  </div>
</div>
@stop

<script src="{{ asset('js/delivery/search.js') }}"></script>
