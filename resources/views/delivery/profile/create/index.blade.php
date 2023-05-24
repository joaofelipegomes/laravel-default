@section("title", $trade_name)
@extends('delivery._templates.default.index')

@section('body')
<div id="swup" class="main-container swup-transition-fade">
    <div class="item-container">
        <div class="item-details override-cart">
            <div class="title">Informações de contato</div>
            <div class="group-items divide-y divide-zinc-100 mt-6 flex items-center justify-center">
                <div class="w-full px-5 flex justify-center items-center">
                <form class="space-y-2 md:space-y-6 min-w-[320px] max-w-[500px]" action="/profile/create" method="POST">
                @csrf
                    <div>
                      <label for="name" class="block ml-2 mb-2 text-sm font-medium text-gray-900">Seu nome</label>
                      <input type="text" name="name" id="name" class="bg-[#f3edf7] text-gray-900 text-sm rounded-full focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 px-5 focus:outline-none" placeholder="" required="">
                    </div>
                    <div>
                        <label for="email" class="block ml-2 mb-2 text-sm font-medium text-gray-900">E-mail</label>
                        <input type="email" name="email" id="email" class="bg-[#f3edf7] text-gray-900 text-sm rounded-full focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 px-5 focus:outline-none" placeholder="" required="">
                    </div>
                    <div>
                        <label for="phone" class="block ml-2 mb-2 text-sm font-medium text-gray-900">Telefone</label>
                        <input type="phone" name="phone" id="phone" class="bg-[#f3edf7] text-gray-900 text-sm rounded-full focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 px-5 focus:outline-none" placeholder="" required="">
                    </div>
                    <div>
                        <label for="password" class="block ml-2 mb-2 text-sm font-medium text-gray-900">Senha</label>
                        <input type="password" name="password" id="password" placeholder="" class="bg-[#f3edf7] text-gray-900 text-sm rounded-full focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 px-5 focus:outline-none" required="">
                    </div>
                    <div class="py-5 space-y-3">
                        <button type="submit" class="w-full text-white bg-red-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-full text-sm px-5 py-2.5 text-center">Criar conta</button>
                        <p class="text-sm font-light text-gray-900">Já possui uma conta? <a href="/delivery/perfil/entrar" class="font-medium text-primary-600 hover:underline">Entre aqui</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
@stop
