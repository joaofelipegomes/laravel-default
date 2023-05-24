@extends('admin._templates.basic.index')
@section('title', 'Entrar')

@section('body')
<section class="basic">
  <div>
    <img src="{{ asset('img/logo-escuro.png') }}" class="logo-auth">
    <div>
      <div>
        <!--<h1>Portal administrativo {{ returnCookie('userInovaAdm') }}</h1>-->
        <div>
          <div>
            <label for="username">Usuário {{ returnCookie('userInovaAdmin') }}</label>
            <input type="text" name="username" placeholder="" required="" autocomplete="off">
          </div>

          <div>
            <label for="password">Senha</label>
            <input type="password" name="password" placeholder="" required="" autocomplete="off">
          </div>

          <div class="remeber-me-container">
            <div>
              <label>
                <input type="checkbox" value="" class="sr-only peer remember">
                <div class="peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-300 peer peer-checked:after:translate-x-full peer-checked:bg-blue-600"></div>
                <span>Mantenha-me conectado</span>
              </label>
            </div>
          </div>

          <button type="button" name="submit">Entrar</button>
        </div>
      </div>
    </div>
  </div>
</section>

<script src="{{ asset('js/loggin.js') }}"></script>
@stop
