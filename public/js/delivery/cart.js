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

const editItems = () => {
  const countersDecrement = document.querySelectorAll('.decrement')
  const countersIncrement = document.querySelectorAll('.increment')

  countersDecrement.forEach(counter => {
    counter.addEventListener('click', function () {
      console.log('decrement')
      const span = (counter.querySelector('span').innerHTML).trim()
      const count = counter.parentElement.querySelector('.count').innerHTML
      const price = counter.parentElement.parentElement.querySelector('.price').getAttribute('price')
      const unit = counter.parentElement.getAttribute('unit')
      const aux = (unit === 'KG') ? 50 : 1

      if (counter.parentElement.querySelector('.count').getAttribute('quantity') == 0) {
        counter.parentElement.parentElement.parentElement.parentElement.remove()
      } else {
        if (parseInt(count) - aux > aux) {
          counter.querySelector('span').innerHTML = 'remove'
          counter.parentElement.querySelector('.count').setAttribute('quantity', 1)
        } else {
          counter.querySelector('span').innerHTML = 'delete'
          counter.parentElement.querySelector('.count').setAttribute('quantity', 0)
        }

        if (aux > 1) {
          counter.parentElement.parentElement.querySelector('.price').innerHTML = parseFloat((price / 1000) * (parseInt(count) - 50)).toLocaleString('pt-br', { style: 'currency', currency: 'BRL' })
          counter.parentElement.querySelector('.count').innerHTML = String(parseInt(count) - 50)
        } else {
          counter.parentElement.parentElement.querySelector('.price').innerHTML = parseFloat(price * (parseInt(count) - 1)).toLocaleString('pt-br', { style: 'currency', currency: 'BRL' })
          counter.parentElement.querySelector('.count').innerHTML = String(parseInt(count) - 1)
        }
      }

      updateCart()
    })
  })

  countersIncrement.forEach(counter => {
    counter.addEventListener('click', function () {
      const span = (counter.parentElement.querySelector('.decrement > span').innerHTML).trim()
      const count = counter.parentElement.querySelector('.count').innerHTML
      const price = parseFloat(counter.parentElement.parentElement.querySelector('.price').getAttribute('price'))
      const unit = counter.parentElement.getAttribute('unit')
      const aux = (unit === 'KG') ? 50 : 0

      if (parseInt(count) + 1 > aux) {
        counter.parentElement.querySelector('.decrement > span').innerHTML = 'remove'
      } else {
        counter.parentElement.querySelector('.decrement > span').innerHTML = 'delete'
      }

      counter.parentElement.querySelector('.count').setAttribute('quantity', 1)

      if (aux > 0) {
        counter.parentElement.parentElement.querySelector('.price').innerHTML = parseFloat((price / 1000) * (parseInt(count) + 50)).toLocaleString('pt-br', { style: 'currency', currency: 'BRL' })
        counter.parentElement.querySelector('.count').innerHTML = String(parseInt(count) + 50)
      } else {
        counter.parentElement.parentElement.querySelector('.price').innerHTML = parseFloat(price * (parseInt(count) + 1)).toLocaleString('pt-br', { style: 'currency', currency: 'BRL' })
        counter.parentElement.querySelector('.count').innerHTML = String(parseInt(count) + 1)
      }

      updateCart()
    })
  })
}

const updateCart = () => {
  const bagJSON = {}
  const items = JSON.parse(localStorage.getItem('bag'))
  const itemsOnCart = document.querySelectorAll('.product')
  let quantityItems = 0
  let amountTotal = 0

  for (const chave in items) {
    bagJSON['uuid'] = items['uuid']
    bagJSON['store'] = items['store']
    bagJSON['user'] = items['user']
    bagJSON['status'] = items['status']
    bagJSON['amount'] = 0
    bagJSON['quantity'] = 0
    bagJSON['created_at'] = items['created_at']
    bagJSON['items'] = []
  }

  itemsOnCart.forEach(item => {
    const paramsJSON = {}

    paramsJSON['id'] = item.getAttribute('product')
    paramsJSON['name'] = item.querySelector('.product-info > .name').innerHTML
    paramsJSON['image'] = item.querySelector('.image.cart').style.backgroundImage
    paramsJSON['quantity'] = item.querySelector('.count-container > .count').innerHTML
    paramsJSON['price'] = item.querySelector('.margin-obs > .price').getAttribute('price')
    paramsJSON['amount'] = parseFloat((item.querySelector('.margin-obs > .price').innerHTML).replace('R$ ', '').replace('.', '').replace(',', '.').replace('R$&nbsp;', ''))
    paramsJSON['unit'] = item.querySelector('.counter').getAttribute('unit')
    paramsJSON['observations'] = item.querySelector('.product-info > .description').innerHTML

    quantityItems = quantityItems + 1
    amountTotal = amountTotal + parseFloat((item.querySelector('.margin-obs > .price').innerHTML).replace('R$ ', '').replace('.', '').replace(',', '.').replace('R$&nbsp;', ''))
    bagJSON.quantity = quantityItems
    bagJSON.amount = amountTotal
    bagJSON.items.push(paramsJSON)
  })

  if (quantityItems > 0) {
    document.querySelector('.bag-continue').classList.remove('hide')
    document.querySelector('.bag-continue').classList.add('show')

    document.querySelector('.total').classList.remove('hide')
    document.querySelector('.total').classList.add('show')

    document.querySelector('.empty-cart').classList.remove('show')
    document.querySelector('.empty-cart').classList.add('hide')
  } else {
    document.querySelector('.bag-continue').classList.add('hide')
    document.querySelector('.bag-continue').classList.remove('show')

    document.querySelector('.total').classList.add('hide')
    document.querySelector('.total').classList.remove('show')

    document.querySelector('.empty-cart').classList.add('show')
    document.querySelector('.empty-cart').classList.remove('hide')
  }

  document.querySelector('.total > .amount').innerHTML = parseFloat(amountTotal).toLocaleString('pt-br', { style: 'currency', currency: 'BRL' });
  localStorage.setItem('bag', JSON.stringify(bagJSON))
}

const verifyUser = () => {
  if (document.querySelector('.bag-continue > div')) {
    document.querySelector('.bag-continue > div').addEventListener('click', function () {
      const cartJSON = JSON.parse(localStorage.getItem('bag'))

      if (cartJSON.user) {
        console.log('tem usuario')
      } else {
        document.querySelector('.profile').click()
      }
    })
  }
}

(async () => {
  createCartItems()
  editItems()
  verifyUser()
})()
