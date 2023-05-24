document.querySelector('div > button').addEventListener('click', (e) => {
  const username = document.querySelector('input[name="username"]').value
  const password = document.querySelector('input[name="password"]').value
  const remember = document.querySelector('input[type="checkbox"]').checked

  axios.post('/api/user/login', {
      username,
      password,
      remember
    })
    .then(function(response) {
      if (response.data[0].user_id) {
        window.location.href = '/admin/painel'
      } else {
        displaySnackbar('Usuário e/ou senha incorretos.', 'error')
      }
    })
    .catch(function(error) {
      displaySnackbar('Usuário e/ou senha incorretos.', 'error')
    })
})

document.addEventListener('keypress', function (e) {
  if (e.key === 'Enter') {
    document.querySelector('div > button').click()
  }
});
