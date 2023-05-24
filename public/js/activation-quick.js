document.querySelector('button[name="generate"').addEventListener('click', (e) => {
  const serial = document.querySelector('input[name="serial"]').value
  const due_date = formatDateISO(document.querySelector('input[name="due-date"]').value)
  const data = [{
    serial,
    due_date
  }]

  console.log(data)

  axios.post(`/api/activation/quick`, data)
  .then(function(response) {
    if (response.data[0].code == 202) {
      document.querySelector('div[name="key"]').innerHTML = response.data[0].key
      document.querySelector('span[key=""]').setAttribute('key', response.data[0].key)

      $('div[name="actions-generate"] > div').animate({
        opacity: 1
      }, 300)
    } else {
      displaySnackbar('Não conseguimos gerar essa chave.', 'error')
    }
  })
  .catch(function(error) {
    displaySnackbar('Não conseguimos gerar essa chave.', 'error')
  })
})

document.querySelectorAll('span[name="key"]').forEach(element => {
  element.addEventListener('click', (e) => {
    const key = e.target.getAttribute('key')

    displaySnackbar('Copiado com sucesso!', 'success')

    navigator.clipboard.writeText(`Digite essa chave para liberar o sistema: ${key}`);
    e.stopPropagation()
  })
})
