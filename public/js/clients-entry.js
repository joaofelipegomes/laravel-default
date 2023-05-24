axios.get('/api/clients/entry')
.then(function(response) {
  if (response.data[0].code === 200) {
    var spark1 = {
      chart: {
        id: 'sparkline1',
        type: 'line',
        height: 110,
        sparkline: {
          enabled: true
        },
        group: 'sparklines'
      },
      series: [{
        name: 'Lojas',
        data: response.data[0].results
      }],
      stroke: {
        curve: 'smooth'
      },
      markers: {
        size: 0
      },
      tooltip: {
        fixed: {
          enabled: true,
          position: 'right'
        },
        x: {
          show: false
        }
      },
      colors: ['#2563eb']
    }

    document.querySelector('div[name="chart-entry-title"]').innerHTML = `${response.data[0].total} lojas`
    new ApexCharts(document.querySelector("#chart-entry"), spark1).render();
  } else {
    displaySnackbar('Erro na visualização de dados', 'error')
  }
})
.catch(function(error) {
  displaySnackbar('Erro na visualização de dados', 'error')
})
