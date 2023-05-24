@extends('admin._templates.default.index')
@section('title', 'Painel')

@section('body')
<section>
  <div class="search-container">
    <div class="!p-4 select-none space-y-4">
      <div class="{{ ($count_delayed_payments > 0) ? '' : 'hidden' }} bg-[#eee79a] w-full pl-4 pr-3 pt-3 pb-2.5 rounded-lg items-center grid grid-cols-12 gap-6">
        <div class="col-span-11 sm:col-span-6 flex items-center gap-2 text-[#2e1500]">
          <span class="material-symbols-rounded filled !text-2xl">gpp_maybe</span>
          <span class="text-sm">{{ $count_delayed_payments }} lojas ainda não realizaram o pagamento da mensalidade</span>
        </div>
        <div class="col-span-1 sm:col-span-6 flex justify-end pr-3">
          <span class="text-sm font-medium cursor-pointer text-zinc-950 hover:opacity-60 transition-all duration-300">Visualizar</span>
        </div>
      </div>

      <div class="grid sm:grid-cols-3 gap-4 w-full">
        <div class="bg-[#f3f6fb] w-full pl-4 pr-3 pt-3 pb-2.5 rounded-lg items-center gap-6">
          <div class="text-[26px] font-[450]" name="chart-entry-title"></div>
          <div id="chart-entry" class="!w-full">
          </div>
        </div>

        <div class="bg-[#f3f6fb] w-full pl-4 pr-3 pt-3 pb-2.5 rounded-lg items-center gap-6 relative min-h-[171px]">
          <div class="text-[26px] font-[450]" name="chart-sum-title"></div>
          <div id="chart-sum" class="!w-full -mt-[30px] absolute left-0 bottom-0">
          </div>
        </div>

        <div class="bg-[#f3f6fb] w-full pl-4 pr-3 pt-3 pb-2.5 rounded-lg items-center gap-6 relative min-h-[171px]">
          <div class="text-[26px] font-[450]" name="chart-year-title">Resumo</div>
          <div id="chart-year" class="!w-full -mt-[30px] absolute left-0 bottom-0">
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
window.Apex = {
  dataLabels: {
    enabled: false
  }
};
</script>
<script src="{{ asset('js/clients-entry.js') }}"></script>
<script src="{{ asset('js/clients-sum.js') }}"></script>
<script src="{{ asset('js/finances-year.js') }}"></script>
@stop
