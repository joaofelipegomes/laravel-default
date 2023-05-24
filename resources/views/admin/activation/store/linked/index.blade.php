@extends('admin._templates.default.index')
@section('title', 'Vinculação de lojas')

@section('body')
<section>
  <div class="store-container">
    <div>
      <form>
        <div>
          <div class="store-info-container no-border">
            <div class="section-title">Vinculação de lojas</div>
            <div class="linked">
            </div>
          </div>
        </div>

        <div class="actions">
          <div>
            <button type="button" class="delete">Excluir</button>
            <button type="button" class="cancel">Cancelar</button>
            <button type="button" class="save" name="save">Saltar alterações</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</section>

<script src="{{ asset('js/activation-linked.js') }}"></script>
@stop