document.querySelector('button.cancel').addEventListener('click', (e) => {
  window.location.href = '/admin/colaborador/ferias';
})

document.querySelector('button[name="save"]').addEventListener('click', (e) => {
  const id = document.querySelector('select[name="collaborator"]').getAttribute('id')
  const days = parseInt(extractOnlyNumbers(document.querySelector('input[name="days"]').value))
  const collaborator = document.querySelector('select[name="collaborator"]').value
  const observations = document.querySelector('textarea[name="observations"]').value
  const start_date = formatDateISO(document.querySelector('input[name="start-date"]').value)
  const end_date = formatDateISO(document.querySelector('input[name="end-date"]').value)
  let vacation_data

  if (id) {
    vacation_data = [{
      id,
      collaborator,
      start_date,
      end_date,
      days,
      observations
    }]

    axios.put(`/api/collaborator/vacation`, vacation_data)
    .then(function(response) {
      if (response.data[0].code === 202) {
        displaySnackbar('Férias atualizada com sucesso!', 'success')

        setTimeout(function () { window.location.href = `/admin/colaborador/ferias` }, 2000)
      } else {
        displaySnackbar('Não conseguimos atualizar essa férias.', 'error')
      }
    })
    .catch(function(error) {
      displaySnackbar('Não conseguimos atualizar essa férias.', 'error')
    })
  } else {
    vacation_data = [{
      collaborator,
      start_date,
      end_date,
      days,
      observations
    }]

    axios.post(`/api/collaborator/vacation`, vacation_data)
    .then(function(response) {
      if (response.data[0].code === 202) {
        displaySnackbar('Férias criada com sucesso!', 'success')

        setTimeout(function () { window.location.href = `/admin/colaborador/ferias` }, 2000)
      } else {
        displaySnackbar('Não conseguimos criar essa férias.', 'error')
      }
    })
    .catch(function(error) {
      displaySnackbar('Não conseguimos criar essa férias.', 'error')
    })
  }
})

document.querySelector('button[name="delete"]').addEventListener('click', (e) => {
  const id = parseInt(document.querySelector('select[name="collaborator"]').getAttribute('id'))

  axios.delete(`/api/collaborator/vacation/${id}`)
    .then(function(response) {
      if (response.data[0].code === 202) {
        displaySnackbar('Férias excluída com sucesso!', 'success')

        setTimeout(function () { window.location.href = `/admin/colaborador/ferias` }, 2000)
      } else {
        displaySnackbar('Não conseguimos excluir essa férias.', 'error')
      }
    })
    .catch(function(error) {
      displaySnackbar('Não conseguimos excluir essa férias.', 'error')
    })
})
