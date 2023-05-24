document.querySelectorAll('a[name="vacation"]').forEach(element => {
  element.addEventListener('click', (e) => {
    const redirect = element.getAttribute('redirect')

    window.location.href = `/admin/colaborador/ferias/editar/${redirect}`;
  })
})

document.querySelectorAll('button[name="key"]').forEach(element => {
  element.addEventListener('click', (e) => {
    const key = e.target.getAttribute('key')

    displaySnackbar('Copiado com sucesso!', 'success')

    navigator.clipboard.writeText(`Digite essa chave para liberar o sistema: ${key}`);
    e.stopPropagation()
  })
})
