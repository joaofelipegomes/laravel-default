document.querySelector('div > button').addEventListener('click', (e) => {
  const document_number = extractOnlyNumbers(document.querySelector('input[name="document-number-check"]').value)

  axios.get(`/api/check/${document_number}/`)
  .then(function(response) {
    if (response.data[0].code === 200) {
      window.location.href = response.data[0].manage_url
    } else {
      displaySnackbar('Não encontramos uma assinatura ativa com esse documento.', 'error')
    }
  })
  .catch(function(error) {
    displaySnackbar('Não encontramos uma assinatura ativa com esse documento.', 'error')
  })
})

document.addEventListener('keypress', function (e) {
  if (e.key === 'Enter') {
    document.querySelector('div > button').click()
  }
});
