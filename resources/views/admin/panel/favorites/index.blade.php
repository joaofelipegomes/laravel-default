@extends('admin._templates.default.index')
@section('title', 'Favoritos')

@section('body')
<section>
  <div class="search-container">
    <div>
      <div class="title-page">Favoritos</div>
    </div>

    <div class="navigator-favorites">
      <ul>
        <li>
          <a href="/admin/lojas">
            <span class="material-symbols-outlined">store</span>
            <span class="description">Lojas</span>
          </a>
        </li>
        <li>
          <a href="https://inovapdv.com.br/os/beta/crm_fin.php" target="_blank">
            <span class="material-symbols-outlined">space_dashboard</span>
            <span class="description">CRM</span>
          </a>
        </li>
        <li>
          <a href="/admin/colaborador/ferias">
            <span class="material-symbols-outlined">nature</span>
            <span class="description">Férias</span>
          </a>
        </li>
        <li>
          <a href="/admin/colaborador/ponto">
            <span class="material-symbols-outlined">timer</span>
            <span class="description">Ponto</span>
          </a>
        </li>
        <li>
          <a href="/admin/empresa">
            <span class="material-symbols-outlined">domain</span>
            <span class="description">Empresa</span>
          </a>
        </li>
        <li>
          <a href="/admin/modulos">
            <span class="material-symbols-outlined">extension</span>
            <span class="description">Módulos</span>
          </a>
        </li>
        <!--<li>
          <a href="https://solucoesinova.com.br/nps/resultado.php" target="_blank">
            <span class="material-symbols-outlined">inventory</span>
            <span class="description">NPS</span>
          </a>
        </li>
        <li>
          <a href="/admin/produtos">
            <span class="material-symbols-outlined">inventory_2</span>
            <span class="description">Produtos</span>
          </a>
        </li>-->
      </ul>
    </div>
  </div>
</section>
@stop