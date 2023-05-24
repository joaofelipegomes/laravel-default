axios.get('/api/company/data')
.then(function(response) {
  if (response.data[0].code === 200) {

var options = {
  chart: {
    toolbar: {
      show: false,
      offsetX: 0,
        offsetY: 0,
    },
    height: 140,
    parentHeightOffset: 0,
    type: "line"
  },
  grid: {
    show: false
},
  stroke: {
    curve: 'smooth'
  },
  dataLabels: {
    enabled: false
  },
  legend: {
    show: false
  },
  series: [
    {
      name: "Entradas",
      data: response.data[0].money_in,
    },
    {
      name: "Saídas",
      data: response.data[0].money_out,
    },
  ],
  colors: ['#16a34a', '#dc2626'],
  fill: {
    type: "solid",
    opacity: 1
  },
  tooltip: {
    fixed: {
      enabled: false,
      position: 'right'
    },
    x: {
      show: true,
    },
    y: {
      formatter: function(value, { series, seriesIndex, dataPointIndex, w }) {
        let parteInteira = parseInt(value).toLocaleString('pt-BR');
        let parteDecimal = (value % 1).toFixed(2).substring(2);

        return `R$ ${parteInteira},${parteDecimal}`;
      },
    }
  },
  yaxis: {
    show: false,
    showAlways: false,
  },
  xaxis: {
    tooltip: {
      enabled: false
    },
    labels: {
          show: true,
      style: {
              colors: ['white'],
              fontSize: '1px',
              fontWeight: 100,
          },
    },
    categories: response.data[0].labels,
    axisBorder: {
    show: false,
  },
  axisTicks: {
    show: false,
  },
  },
};

var chart = new ApexCharts(document.querySelector("#chart-year"), options);
chart.render();
} else {
  displaySnackbar('Erro na visualização de dados', 'error')
}
})
.catch(function(error) {
displaySnackbar('Erro na visualização de dados', 'error')
})
