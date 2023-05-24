document.querySelectorAll('a[name="store"]').forEach(element => {
  element.addEventListener('click', (e) => {
    const redirect = element.getAttribute('redirect')

    window.location.href = `/admin/ativacao/loja/${redirect}`;
  })
})

document.querySelectorAll('button[name="key"]').forEach(element => {
  element.addEventListener('click', (e) => {
    const key = e.target.getAttribute('key')

    displaySnackbar('Chave copiada para a sua área de transferência', 'success')

    navigator.clipboard.writeText(`Digite essa chave para liberar o sistema: ${key}`);
    e.stopPropagation()
  })
})
