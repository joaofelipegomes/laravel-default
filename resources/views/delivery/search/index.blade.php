@section("title", $trade_name)
@extends('delivery._templates.default.index')

@section("body")
<div id="swup" class="main-container no-padding swup-transition-fade">
    <div class="item-container">
        <div class="back-container">
            <a href="/{{ getCookies('store') }}" class="back-navigator">
                <span class="material-symbols-outlined weight">
                    arrow_back_ios
                </span>
            </a>
        </div>

        <div class="item-image"></div>
        <div class="item-details">
        </div>
    </div>
</div>
@stop