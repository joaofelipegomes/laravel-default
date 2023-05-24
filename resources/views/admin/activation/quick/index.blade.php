@extends('admin._templates.default.index')
@section('title', 'Ativação rápida')

@section('body')
<section>
  <div class="store-container">
    <div>
      <form>
        <div>
          <div class="store-info-container no-border">
            <div class="section-title">Ativação rápida</div>
            <div>
              <div name="serial-container">
                <label class="label-title">Número do HD</label>
                <div>
                  <input name="serial" type="text" value="" store="" autocomplete="off">
                </div>
              </div>

              <div name="due-date-key-container">
                <label class="label-title">Vencimento</label>
                <div>
                  <input type="text" name="due-date" value="" autocomplete="off">
                </div>
              </div>

              <div name="actions-generate">
                <button type="button" class="button-generate" name="generate">Gerar chave</button>

                <div>
                  <div name="key"></div>
                  <span class="material-symbols-outlined" name="key" key="">
                    content_copy
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</section>

<script src="{{ asset('js/activation-quick.js') }}"></script>
@stop