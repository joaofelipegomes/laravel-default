@extends('admin._templates.default.index')
@section('title', 'Módulos')

@section('body')
<section>
  <div class="search-container">
    <div>
      <!--<div class="title-page">Módulos</div>-->

      <div class="w-full grid grid-cols-1 sm:grid-cols-2 gap-6">
        <div class="min-h-[200px] cursor-pointer relative w-full h-full rounded-2xl shadow-lg hover:shadow-xl hover:scale-105 outline-0 hover:outline hover:outline-offset-[-6px] hover:outline-8 outline-white/30 transition-all duration-300 p-6" style="background-image: linear-gradient(45deg, hsl(145deg 100% 27%) 0%, hsl(145deg 100% 28%) 11%, hsl(145deg 100% 29%) 22%, hsl(145deg 100% 30%) 33%, hsl(145deg 100% 32%) 44%, hsl(145deg 100% 33%) 56%, hsl(146deg 100% 34%) 67%, hsl(146deg 100% 35%) 78%, hsl(146deg 100% 36%) 89%, hsl(146deg 100% 37%) 100%);">
          <div class="text-4xl text-white font-semibold">Delivery</div>
          <div class="grid gap-3 pt-4 text-base absolute bottom-0 mb-6 ml-6 left-0">
            <div class="font-medium flex items-center gap-1 text-white">
              Gerenciar lojas
              <span class="material-symbols-outlined text-2xl" style="font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 48;">
                chevron_right
              </span>
            </div>
          </div>
        </div>

        <div class="min-h-[200px] cursor-pointer relative w-full h-full rounded-2xl shadow-lg hover:shadow-xl hover:scale-105 outline-0 hover:outline hover:outline-offset-[-6px] hover:outline-8 outline-white/30 transition-all duration-300 p-6" style="background-image: linear-gradient(45deg, hsl(247deg 95% 66%) 0%, hsl(251deg 97% 66%) 11%, hsl(255deg 97% 66%) 22%, hsl(258deg 98% 66%) 33%, hsl(261deg 99% 65%) 44%, hsl(264deg 99% 65%) 56%, hsl(268deg 100% 65%) 67%, hsl(271deg 100% 64%) 78%, hsl(274deg 100% 64%) 89%, hsl(276deg 100% 63%) 100%);">
          <div class="text-4xl text-white font-semibold">Online</div>
          <div class="grid gap-3 pt-4 text-base absolute bottom-0 mb-6 ml-6 left-0">
            <div class="font-medium flex items-center gap-1 text-white">
              Gerenciar lojas
              <span class="material-symbols-outlined text-2xl" style="font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 48;">
                chevron_right
              </span>
            </div>
          </div>
        </div>

        <a href="https://solucoesinova.com.br/nps/resultado.php" target="_blank" class="min-h-[200px] cursor-pointer relative w-full h-full rounded-2xl shadow-lg hover:shadow-xl hover:scale-105 outline-0 hover:outline hover:outline-offset-[-6px] hover:outline-8 outline-white/30 transition-all duration-300 p-6" style="background-image: linear-gradient(45deg, rgba(0,113,229,1) 40%, rgba(54,153,255,1) 100%);">
          <div class="text-4xl text-white font-semibold">NPS</div>
          <div class="grid gap-3 pt-4 text-base absolute bottom-0 mb-6 ml-6 left-0">
            <div class="font-medium flex items-center gap-1 text-white">
              Visualizar respostas
              <span class="material-symbols-outlined text-2xl" style="font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 48;">
                chevron_right
              </span>
            </div>
          </div>
        </a>

        <div class="min-h-[200px] cursor-pointer relative w-full h-full rounded-2xl shadow-lg hover:shadow-xl hover:scale-105 outline-0 hover:outline hover:outline-offset-[-6px] hover:outline-8 outline-white/30 transition-all duration-300 p-6" style="background-image: linear-gradient(45deg, rgba(229,78,0,1) 40%, rgba(255,136,54,1) 100%);">
          <div class="text-4xl text-white font-semibold">Produtos</div>
          <div class="grid gap-3 pt-4 text-base absolute bottom-0 mb-6 ml-6 left-0">
            <div class="font-medium flex items-center gap-1 text-white">
              Visualizar produtos
              <span class="material-symbols-outlined text-2xl" style="font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 48;">
                chevron_right
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@stop
