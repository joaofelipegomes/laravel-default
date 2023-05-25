@section("title", $trade_name)
@extends('delivery._templates.default.index')

@section("body")
<div id="swup" class="main-container no-padding swup-transition-fade">
    <div class="item-container">
        <div class="back-container">
            <a href="/delivery/{{ getCookies('store') }}" class="back-navigator">
                <span class="material-symbols-outlined weight">
                    arrow_back_ios
                </span>
            </a>
        </div>

        @if($product["image"])
        @php
        $baseURL = "https://solucoesinova.com.br/inovadelivery/produto_img/";
        $imageURL = $baseURL . $id . "/" . $product['image'];
        @endphp
        <div class="item-image" style="background-image: url('{{ $imageURL }}')"></div>
        <div class="item-details">
        @else
        <div class="item-details override">
        @endif
            <div class="product-info">
                <div class="name">{{ formatText($product["name"]) }}</div>
                <div class="description">{{ formatDescription($product["description"]) }}</div>
                <div class="price" amount="{{ $product["amount"] }}">R$ {{ number_format($product["amount"], 2, ',', '.') }}</div>
            </div>

            @if($product["kilogram"])
            <div class="warning-weight">
                <div class="icon">
                    <span class="material-symbols-outlined fill">
                    scale
                    </span>
                </div>
                <div class="text">
                    <p>
                        Atenção: Este item tem peso variável e seu valor total pode ser atualizado pela loja após a pesagem.
                    </p>
                </div>
            </div>
            @endif

            <div class="comments">
                <div class="icon">
                    <span class="material-symbols-outlined fill">
                    chat
                    </span>
                </div>
                <div class="text">
                    <textarea></textarea>
                </div>
            </div>



            <div class="product-cart">
            @if($product["kilogram"])
            <div class="counter" x-data="{ count: 50 }">
                    <button class="decrement" x-on:click="count = count > 50 ? count-50 : count">
                        <span class="material-symbols-outlined">
                            remove
                        </span>
                    </button>
                    <div class="count-container">
                        <div class="count" x-text="count >= 1000 ? count / 1000 : count" quantity="50"></div>
                        <span x-text="count >= 1000 ? 'kg' : 'g'" class="unit"></span>
                    </div>
                    <button class="increment" x-on:click="count = count + 50">
                        <span class="material-symbols-outlined">
                            add
                        </span>
                    </button>
                </div>
            @else
            <div class="counter" x-data="{ count: 1 }">
                    <button class="decrement" x-on:click="count = count > 1 ? count-1 : count">
                        <span class="material-symbols-outlined">
                            remove
                        </span>
                    </button>
                    <div class="count-container">
                        <div class="count" x-text="count" quantity="1"></div>
                        <span class="unit">un</span>
                    </div>
                    <button class="increment" x-on:click="count = count + 1">
                        <span class="material-symbols-outlined">
                            add
                        </span>
                    </button>
                </div>
            @endif



                <button>
                    <span class="add">Adicionar</span>
                    @if($product["kilogram"])
                    <span class="money">R$ {{ number_format(($product["amount"] / 1000) * 50, 2, ',', '.') }}</span>
                    @else
                    <span class="money">R$ {{ number_format($product["amount"], 2, ',', '.') }}</span>
                    @endif
                </button>
            </div>


        </div>
    </div>
</div>

<script type="module" src="{{ asset('js/delivery/product.js') }}"></script>
@stop
