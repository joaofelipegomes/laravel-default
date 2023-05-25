@section('title', $trade_name)
@extends('delivery._templates.default.index')

@section('body')

<div id="swup" class="main-container swup-transition-fade">
  <div class="bag-continue show">
    <div>
      <a href="{{ $link }}" class="button">
        <div class="button" id="verify-user">
          Continuar
        </div>
      </a>
    </div>
  </div>

  <div class="item-container">
    <div class="item-details override-cart">
      <div class="title">Meu pedido</div>
      <div class="group-items divide-y divide-zinc-100 mt-6">
        <a class="product hidden">
          <div class="image cart"></div>
          <div class="product-info cart">
            <div class="name"></div>
            <div class="description"></div>

            <div class="margin-obs">
              <div class="price">R$ 0,00</div>
              <div class="counter" x-data="{ count: 1 }">
                <button class="decrement" x-on:click="count = count > 1 ? count-1 : count">
                  <span class="material-symbols-outlined">remove</span>
                </button>

                <div class="count-container">
                  <div class="count" x-text="count" quantity="1"></div>
                </div>

                <button class="increment" x-on:click="count = count + 1">
                  <span class="material-symbols-outlined">add</span>
                </button>
              </div>
            </div>
          </div>
        </a>
      </div>

      <div class="total">
        <div class="title">Subtotal</div>
        <div class="amount">R$ 0,00</div>
      </div>

      <div class="empty-cart">
        Sacola vazia
      </div>
    </div>
  </div>

  <script src="{{ asset('js/delivery/cart.js') }}"></script>
</div>
@stop
