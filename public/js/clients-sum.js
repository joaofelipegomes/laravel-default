axios.get('/api/clients/values')
.then(function(response) {
  if (response.data[0].code === 200) {
    var spark2 = {
      chart: {
        toolbar: {
          show: false
        },
        height: 150,
        parentHeightOffset: 0,
        parentWidthOffset: 0,
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
          name: "Valor",
          data: response.data[0].results
        }
      ],
      colors: ['#16a34a'],
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
      annotations: {
            xaxis: [{
              x: response.data[0].day,
              strokeDashArray: 3,
              borderColor: '#c2c2c2',
              label: {
                borderColor: '#000',
                style: {
                  color: '#fff',
                  background: '#775DD0',
                },
                text: '',
              }
            }]
          },
    };

    document.querySelector('div[name="chart-sum-title"]').innerHTML = formatarParaReais(response.data[0].value)

    new ApexCharts(document.querySelector("#chart-sum"), spark2).render();
  } else {
    displaySnackbar('Erro na visualização de dados', 'error')
  }
})
.catch(function(error) {
  displaySnackbar('Erro na visualização de dados', 'error')
})
