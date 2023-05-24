@extends('admin._templates.basic.index')
@section('title', 'Verificar loja')

@section('body')
<section class="basic">
  <div>
    <img src="{{ asset('img/logo-escuro.png') }}" class="logo-auth">
    <div>
      <div>
        <div>
          <div>
            <label for="document-number">Documento da loja</label>
            <input type="text" name="document-number-check" placeholder="" required="" autocomplete="off" value="{{ $document }}">
          </div>

          <button type="button" name="submit">Verificar</button>
        </div>
      </div>
    </div>
  </div>
</section>

<script src="{{ asset('js/check-store.js') }}"></script>
<script>

</script>
@stop
