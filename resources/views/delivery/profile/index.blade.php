@section("title", $trade_name)
@extends('delivery._templates.default.index')

@section('body')
<div id="swup" class="main-container swup-transition-fade">
    <div class="item-container">
        <div class="item-details override-cart">
            <div class="title">Meu cadastro</div>
            <div class="group-items divide-y divide-zinc-100 mt-6 flex items-center justify-center">
                <div class="w-full flex justify-center items-center">
                    <div class="grid grid-cols-1 w-full gap-y-3 text-base text-zinc-900">
                        <div class="w-full py-3 flex gap-x-3 items-center">
                            <div class="font-medium">Meus dados</div>
                            <div class="flex items-center">
                                <span class="material-symbols-outlined cart !font-light" style="line-height: 0;">
                                chevron_right
                                </span>
                            </div>
                        </div>
                        <div class="w-full py-3 flex gap-x-3 items-center">
                            <div class="font-medium">Pedidos</div>
                            <div class="flex items-center">
                                <span class="material-symbols-outlined cart !font-light" style="line-height: 0;">
                                chevron_right
                                </span>
                            </div>
                        </div>
                        <a href="/profile/logout" class="w-full rounded-full py-3 flex gap-x-3 items-center">
                            <div class="font-medium">Sair</div>
                            <div class="flex items-center">
                                <span class="material-symbols-outlined cart !font-light" style="line-height: 0;">
                                chevron_right
                                </span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@stop
