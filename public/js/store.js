document.querySelector('button.cancel').addEventListener('click', (e) => {
  window.location.href = '/admin/lojas';
})

document.querySelector('button[name="save"]').addEventListener('click', (e) => {
  const id = document.querySelector('form').getAttribute('key')
  const trade_name = document.querySelector('input[name="trade-name"]').value
  const corporate_name = document.querySelector('input[name="corporate-name"]').value
  const document_number = extractOnlyNumbers(document.querySelector('input[name="document-number"]').value)
  const state_registration = extractOnlyNumbers(document.querySelector('input[name="state-registration"]').value)
  const situation = document.querySelector('select[name="situation"]').value
  const product = document.querySelector('select[name="product"]').value
  const responsible = document.querySelector('input[name="responsible"]').value
  const phone = document.querySelector('input[name="phone"]').value
  const email = document.querySelector('input[name="email"]').value
  const entered_at = (document.querySelector('input[name="entered-at"]').value) ? formatDateISO(document.querySelector('input[name="entered-at"]').value) : null
  const address = document.querySelector('input[name="address"]').value
  const house_number = document.querySelector('input[name="house-number"]').value
  const zipcode = document.querySelector('input[name="zipcode"]').value
  const neighborhood = document.querySelector('input[name="neighborhood"]').value
  const state = document.querySelector('select[name="state"]').value
  const city = document.querySelector('input[name="city"]').value

  const store_data = [{
      id,
      trade_name,
      corporate_name,
      document_number,
      state_registration,
      situation,
      product,
      responsible,
      phone,
      email,
      entered_at,
      address,
      house_number,
      zipcode,
      neighborhood,
      state,
      city
    }]

    if (id) {
      axios.put('/api/store', store_data)
      .then(function(response) {
        if (response.data[0].code === 202) {
          displaySnackbar('Cadastro atualizado com sucesso!', 'success')
          setTimeout(function () { window.location.href = `/admin/lojas` }, 2000)
        } else {
          displaySnackbar('Não conseguimos alterar os dados.', 'error')
        }
      })
      .catch(function(error) {
        displaySnackbar('Não conseguimos alterar os dados.', 'error')
      })
    } else {
      axios.post('/api/store', store_data)
      .then(function(response) {
        if (response.data[0].code === 202) {
          displaySnackbar('Loja criada com sucesso!', 'success')
          setTimeout(function () { window.location.href = `/admin/lojas` }, 2000)
        } else {
          displaySnackbar('Não conseguimosss criar essa loja.', 'error')
        }
      })
      .catch(function(error) {
        displaySnackbar('Não conseguimos criar essa loja.', 'error')
      })
    }
})
