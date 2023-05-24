@section("title", $trade_name)
@extends('delivery._templates.default.index')

@section("header")
@stop

@section("body")
<div id="swup" class="main-container swup-transition-fade">
    <div class="cover">
        <div class="cover-container relative justify-center items-center flex" style="background-image: url('{{ $header }}')">
            <div class="cover-fade"></div>
            <dt class="color-white absolute text-xl font-normal text-zinc-100 flex items-center gap-x-3 h-1/2">
            </dt>
        </div>
    </div>

    <div class="fixed-navigator" id="fixednavigator">
        <div class="search-container">
            <div class="search">
                <div>{{ $trade_name }}</div>
                <a href="/delivery/{{ getCookies('store') }}/buscar">
                    <span class="material-symbols-outlined">
                        search
                    </span>
                </a>
            </div>
        </div>
        <div class="scroll-navigator !cursor-grab overflow-x-scroll overflow-y-hidden whitespace-nowrap p-2 w-full select-none">
            <div class="text-sm font-normal text-gray-400 w-full">
                @foreach($categories as $category => $c)
                @if(array_search($c['id'], array_column($products, 'category_id')))
                <a class="px-5 py-2 menu-item rounded-full !mr-1.5" to="{{ $c['id'] }}" id="s{{ $c['id'] }}">{{ $c["name"] }}</a>
                @endif
                @endforeach
            </div>
        </div>

        <div class="mobile">
            <div class="group-search">
                <div class="categories-container">
                    <div class="categories">
                        <select name="categories-dropdown">
                            @foreach($categories as $category => $c)
                            @if(array_search($c['id'], array_column($products, 'category_id')))
                            <option value="{{ $c['id'] }}">{{ $c["name"] }}</option>
                            @endif
                            @endforeach
                        </select>
                        <span class="material-symbols-outlined">
                            expand_more
                        </span>
                    </div>
                </div>

                <div class="search-container sm:block hidden">
                    <a href="/delivery/{{ getCookies('store') }}/buscar" class="search">
                        <span class="material-symbols-outlined">
                            search
                        </span>
                        <p>Buscar na {{ $trade_name }}</p>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="pt-16">
        <div class="content-container">
            <div class="header">
                <div class="pic" style="background-image: url('{{ $logo }}')"></div>
                <div class="info">
                    <div class="title">{{ $trade_name }}</div>
                    <div class="open">
                        <span class="material-symbols-outlined clock">
                            schedule
                        </span>
                        <span class="status">Loja Fechada</span>
                    </div>
                    <div class="fee">
                        <span class="material-symbols-outlined money">
                            sports_motorsports
                        </span>
                        <span class="text">Endereço de entrega</span>
                    </div>
                </div>
            </div>

            <div class="group-search">
                <div class="categories-container">
                    <div class="categories">
                        <select name="categories-dropdown">
                            @foreach($categories as $category => $c)
                            <option value="{{ $c["id"] }}">{{ $c["name"] }}</option>
                            @endforeach
                        </select>
                        <span class="material-symbols-outlined">
                            expand_more
                        </span>
                    </div>
                </div>

                <div class="search-container">
                    <a href="/delivery/{{ getCookies('store') }}/buscar" class="search">
                        <span class="material-symbols-outlined">
                            search
                        </span>
                        <p>Buscar na {{ $trade_name }}</p>
                    </a>
                </div>
            </div>

            <div class="content">
                @foreach($categories as $category => $c)
                @if(array_search($c['id'], array_column($products, 'category_id')))
                <section id="{{ $c['id'] }}">
                    <dt class="category-name">{{ $c["name"] }}</dt>

                    <div class="group-products">
                        @foreach($products as $product => $p)
                        @if($p["category_id"] === $c["id"])
                        <a href="/delivery/{{ $storename }}/item/{{ convertToNumber($p['id']) }}" class="product" id="{{ $p['id'] }}">
                            <div class="product-info">
                                <div class="name">{{ $p["name"] }}</div>
                                <div class="description">{{ $p["description"] }}</div>
                                <div class="price">R$ {{ $p["amount"] }}</div>
                            </div>
                            @if($p['image'])
                            @php
                            $baseURL = "https://solucoesinova.com.br/inovadelivery/produto_img/";
                            $imageURL = $baseURL . $id . "/" . $p['image'];
                            @endphp
                            <div class="image" style="background-image: url('{{ $imageURL }}')"></div>
                            @else
                            <div class="image"></div>
                            @endif
                        </a>
                        @endif
                        @endforeach
                    </div>
                </section>
                @endif
                @endforeach
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/delivery/navigator.js') }}"></script>
@stop
