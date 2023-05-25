const storeStatus = async () => {
  return new Promise((resolve, reject) => {
    fetch(`https://api.inovasistemas.app/delivery/store/1/status`, {
      method: 'GET',
      headers: {
        "Content-Type": "application/json",
      }
    })
      .then((response) => response.json())
      .then((data) => {
        return resolve(data);
      })
  })
}

const verifyStoreStatus = async () => {
  const data = await storeStatus()
  const status = document.querySelector('.info > .open')
  status.setAttribute('class', '')

  if ((!data.open) && (!data.outside_business_hours)) {
    status.setAttribute('class', 'open closed')
    status.querySelector('.status').innerHTML = 'Loja Fechada'
  } else if ((!data.open) && (data.outside_business_hours)) {
    status.setAttribute('class', 'open schedule')
    status.querySelector('.status').innerHTML = 'Agendar Entrega'
  } else if (data.open) {
    status.setAttribute('class', 'open opened')
    status.querySelector('.status').innerHTML = 'Loja Aberta'
  }
}

(async () => {
  await verifyStoreStatus()
})()
