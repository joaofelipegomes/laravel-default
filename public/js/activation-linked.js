document.querySelector('button.cancel').addEventListener('click', (e) => {
  const location = (window.location.href).split('/vincular')
  window.location.href = location[0];
})
