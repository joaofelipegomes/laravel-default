const createCartItems = () => {
  const container = document.querySelector('.group-items')
  const element = document.querySelector('#swup > div > div > div > a')
  const items = JSON.parse(localStorage.getItem('bag'))
  let parser = document.createElement('a')
  let routeParametersRegex = parser.pathname.split('/')
  parser.href = window.location.href

  if (items) {
    for (const chave in items['items']) {
      let childElement = element.cloneNode(true)
      childElement.setAttribute('product', items['items'][chave]['id'])
      childElement.querySelector('.product-info > .name').innerHTML = items['items'][chave]['name']
      childElement.querySelector('.product-info > .description').innerHTML = items['items'][chave]['observations']
      childElement.querySelector('.image.cart').style.backgroundImage = items['items'][chave]['image']
      childElement.querySelector('.product-info > div > .price').innerHTML = parseFloat(items['items'][chave]['amount']).toLocaleString('pt-br', { style: 'currency', currency: 'BRL' });
      childElement.querySelector('.product-info > div > .price').setAttribute('price', items['items'][chave]['price'])
      childElement.querySelector('.counter').setAttribute('x-data', `{ count: ${items['items'][chave]['quantity']} }`)
      childElement.querySelector('.counter').setAttribute('unit', items['items'][chave]['unit'])

      if (items['items'][chave]['unit'] == 'KG') {
        childElement.querySelector('.decrement').setAttribute('x-on:click', 'count = count > 50 ? count-50 : count')
        childElement.querySelector('.increment').setAttribute('x-on:click', 'count = count + 50')
      }

      if (items['items'][chave]['quantity'] == 1) {
        childElement.querySelector('.decrement > span').innerHTML = 'delete'
        childElement.querySelector('.count-container > .count').setAttribute('quantity', 0)
      } else {
        childElement.querySelector('.count-container > .count').setAttribute('quantity', 1)
      }

      childElement.classList.remove('hidden')
      container.appendChild(childElement)
    }

    if (document.querySelector('.bag-continue')) {
      if (items['quantity'] > 0) {
        document.querySelector('.bag-continue').classList.remove('hide')
        document.querySelector('.bag-continue').classList.add('show')
      } else {
        document.querySelector('.bag-continue').classList.add('hide')
        document.querySelector('.bag-continue').classList.remove('show')
      }
    }
    document.querySelector('.total > .amount').innerHTML = parseFloat(items.amount).toLocaleString('pt-br', { style: 'currency', currency: 'BRL' });

    element.remove()
  } else {
    document.querySelector('.bag-continue').classList.add('hide')
    document.querySelector('.bag-continue').classList.remove('show')
  }
}

(async () => {
  createCartItems()
})()
