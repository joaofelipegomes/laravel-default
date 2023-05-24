document.querySelector('button.cancel').addEventListener('click', (e) => {
  const location = (window.location.href).split('/estacao')
  window.location.href = location[0];
})

document.querySelector('button.save').addEventListener('click', (e) => {
  const id = document.querySelector('input[name="station-number"]').getAttribute('id')
  const store_id = document.querySelector('input[name="station-number"]').getAttribute('store')
  const serial = document.querySelector('input[name="station-number"]').value
  const name = document.querySelector('input[name="station-name"]').value
  const server = document.querySelector('select[name="station-server"]').value

  const store_data = [{
    id,
    store_id,
    serial,
    name,
    server
  }]

  if (id != '') {
    axios.put('/api/activation/store/station', store_data)
      .then(function(response) {
        if (response.data[0].code === 202) {
          displaySnackbar('Estação atualizada com sucesso!', 'success')

          setTimeout(function () { window.location.href = `/admin/ativacao/loja/${store_id}` }, 2000)
        } else {
          displaySnackbar('Não conseguimos atualizar essa estação.', 'error')
        }
      })
      .catch(function(error) {
        displaySnackbar('Não conseguimos atualizar essa estação.', 'error')
      })
  } else {
    axios.post('/api/activation/store/station', store_data)
      .then(function(response) {
        if (response.data[0].code === 202) {
          displaySnackbar('Estação criada com sucesso!', 'success')

          setTimeout(function () { window.location.href = `/admin/ativacao/loja/${store_id}` }, 2000)
        } else {
          displaySnackbar('Não conseguimos criar essa estação.', 'error')
        }
      })
      .catch(function(error) {
        displaySnackbar('Não conseguimos criar essa estação.', 'error')
      })
  }
})

document.querySelector('button.delete').addEventListener('click', (e) => {
  const id = parseInt(document.querySelector('input[name="station-number"]').getAttribute('id'))
  const store_id = parseInt(document.querySelector('input[name="station-number"]').getAttribute('store'))

  axios.delete(`/api/activation/store/${store_id}/station/${id}`)
    .then(function(response) {
      if (response.data[0].code === 202) {
        displaySnackbar('Estação excluída com sucesso!', 'success')

        setTimeout(function () { window.location.href = `/admin/ativacao/loja/${store_id}` }, 2000)
      } else {
        displaySnackbar('Não conseguimos excluir essa estação.', 'error')
      }
    })
    .catch(function(error) {
      displaySnackbar('Não conseguimos excluir essa estação.', 'error')
    })
})
