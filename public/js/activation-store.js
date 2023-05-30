document.querySelectorAll('button[name="key"]').forEach(element => {
  element.addEventListener('click', (e) => {
    const key = e.target.getAttribute('key')

    displaySnackbar('Copiado com sucesso!', 'success')

    navigator.clipboard.writeText(`Digite essa chave para liberar o sistema: ${key}`);
    e.stopPropagation()
  })
})

document.querySelector('button.cancel').addEventListener('click', (e) => {
  window.location.href = '/admin/ativacao';
})

document.querySelectorAll('button[name="station-update"]').forEach(element => {
  element.addEventListener('click', (e) => {
    const id = parseInt(extractOnlyNumbers(document.querySelector('input[name="trade-name"]').getAttribute('store')))
    const station_id = element.getAttribute('station')

    window.location.href = `/admin/ativacao/loja/${id}/estacao/${station_id}`;
  })
})

document.querySelector('button[name="save"]').addEventListener('click', (e) => {
  let validation_1;

  const id = parseInt(extractOnlyNumbers(document.querySelector('input[name="trade-name"]').getAttribute('store')))
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

  const subscription_status = document.querySelector('input[name="subscription-status"]').checked
  const subscription_document = extractOnlyNumbers(document.querySelector('input[name="subscription-document"]').value)
  const subscription_amount = formatNumberISO(document.querySelector('input[name="subscription-amount"]').value)
  let subscription_cycle = document.querySelector('select[name="subscription-cycle"]').value
  const subscription_free_trail = document.querySelector('input[name="subscription-free-trail"]').value
  const subscription_email = document.querySelector('input[name="subscription-email"]').value

  if ((document_number) && (subscription_status)) {
    validation_1 = validateCNPJ(subscription_document);

    if (!validation_1) {
      if (!validateCPF(subscription_document)) {
        validation_1 = false;
      } else {
        validation_1 = true;
      }
    } else {
      validation_1 = true;
    }
  } else {
    validation_1 = true;
  }

  if (validation_1) {
    const store_data = [{
      id,
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
      due_date,
      subscription: [{
        subscription_status,
        subscription_document,
        subscription_amount,
        subscription_cycle,
        subscription_free_trail,
        subscription_email
      }]
    }]

    axios.put('/api/activation/store', store_data)
      .then(function (response) {
        if (response.data[0].code === 202) {
          displaySnackbar('Cadastro atualizado com sucesso!', 'success')
        } else {
          displaySnackbar('Não conseguimos alterar os dados.', 'error')
        }
      })
      .catch(function (error) {
        displaySnackbar('Não conseguimos alterar os dados.', 'error')
      })
  } else {
    displaySnackbar('Número de documento incorreto.', 'error')
  }
})


document.querySelector('input[name="subscription-document"]').addEventListener('change', function (e) {
  const document_number = e.target.value;

  if (document_number) {
    const validation_1 = validateCNPJ(document_number);

    if (!validation_1) {
      if (!validateCPF(document_number)) {
        displaySnackbar('Número de documento incorreto.', 'error')
      } else {
        displaySnackbar('Número de documento válido!', 'success')
      }
    } else {
      displaySnackbar('Número de documento válido!', 'success')
    }
  }
})
