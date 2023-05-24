document.querySelectorAll('div[name="actions"] > button[name="save"]').forEach(element => {
  element.addEventListener('click', function() {
    const key = element.parentElement.parentElement.getAttribute('key')
    const start_date = formatDateTimeISO(element.parentElement.parentElement.querySelector('input[name="punched-start"]').value)
    const end_date = formatDateTimeISO(element.parentElement.parentElement.querySelector('input[name="punched-end"]').value)

    const data = [{
      key,
      start_date,
      end_date
    }]

    axios.put(`/api/collaborator/punchedclock/${key}`, data)
    .then(function(response) {
      if (response.data[0].code === 202) {
        displaySnackbar('Ponto atualizado com sucesso!', 'success')
      } else {
        displaySnackbar('Não conseguimos alterar o ponto.', 'error')
      }
    })
    .catch(function(error) {
      displaySnackbar('Não conseguimos alterar o ponto.', 'error')
    })
  })
})
