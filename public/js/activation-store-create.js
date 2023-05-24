document.querySelector('button.cancel').addEventListener('click', (e) => {
  window.location.href = '/admin/ativacao';
})

document.querySelector('button[name="save"]').addEventListener('click', (e) => {
  const trade_name = document.querySelector('input[name="trade-name"]').value
  const line_of_business = document.querySelector('select[name="line-of-business"]').value
  const document_number = extractOnlyNumbers(document.querySelector('input[name="document-number"]').value)
  const priority = document.querySelector('input[name="priority"]:checked').value
  const plan = document.querySelector('select[name="plan"]').value
  const cycle = document.querySelector('select[name="cycle"]').value
  const amount = formatNumberISO(document.querySelector('input[name="amount"]').value)
  const renew_1 = document.querySelector('select[name="renew-1"]').value
  const renew_2 = document.querySelector('select[name="renew-2"]').value
  const renew_day = document.querySelector('select[name="renew-day"]').value
  const due_date = formatDateISO(document.querySelector('input[name="due-date"]').value)

  const store_data = [{
    trade_name,
    line_of_business,
    document_number,
    priority,
    plan,
    cycle,
    amount,
    renew_1,
    renew_2,
    renew_day,
    due_date
  }]

  axios.post(`/api/activation/store`, store_data)
    .then(function(response) {
      if (response.data[0].code === 202) {
        displaySnackbar('Loja criada com sucesso!', 'success')

        setTimeout(function () { window.location.href = `/admin/ativacao` }, 2000)
      } else {
        displaySnackbar('Não conseguimos criar essa loja.', 'error')
      }
    })
    .catch(function(error) {
      displaySnackbar('Não conseguimos criar essa loja.', 'error')
    })
})
