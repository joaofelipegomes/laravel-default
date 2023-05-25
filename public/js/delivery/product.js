import { v4 as uuidv4 } from 'https://jspm.dev/uuid';

const sumProducts = () => {
  document.querySelector('.increment').addEventListener('click', function () {
    const unit = (document.querySelector('.unit').innerHTML === 'un') ? 1 : 50
    const quantity = document.querySelector('.count-container > .count').getAttribute('quantity')
    const amount = document.querySelector('.price').getAttribute('amount')

    document.querySelector('.count-container > .count').setAttribute('quantity', parseInt(quantity) + parseInt(unit))

    if (unit === 1) {
      document.querySelector('.money').innerHTML = ((parseInt(quantity) + unit) * parseFloat(amount)).toLocaleString('pt-br', { style: 'currency', currency: 'BRL' });
    } else {
      document.querySelector('.money').innerHTML = ((parseFloat(amount) / 1000) * (parseInt(quantity) + unit)).toLocaleString('pt-br', { style: 'currency', currency: 'BRL' });
    }
  })

  document.querySelector('.decrement').addEventListener('click', function () {
    const unit = (document.querySelector('.unit').innerHTML === 'un') ? 1 : 50
    const quantity = document.querySelector('.count-container > .count').getAttribute('quantity')
    const amount = document.querySelector('.price').getAttribute('amount')

    document.querySelector('.count-container > .count').setAttribute('quantity', parseInt(quantity) - parseInt(unit))

    if (unit === 1) {
      if (parseInt(quantity) >= 2) {
        document.querySelector('.money').innerHTML = ((parseInt(quantity) - unit) * parseFloat(amount)).toLocaleString('pt-br', { style: 'currency', currency: 'BRL' });
      }
    } else {
      if (parseInt(quantity) >= 100) {
        document.querySelector('.money').innerHTML = ((parseFloat(amount) / 1000) * (parseInt(quantity) - unit)).toLocaleString('pt-br', { style: 'currency', currency: 'BRL' });
      }
    }
  })
}

const bagBadge = () => {
  document.querySelector('.product-cart > button').addEventListener('click', function () {
    const badge = document.querySelector('body > div.bag > .badge')
    const paramsJSON = {}

    let parser = document.createElement('a')
    parser.href = window.location.href
    let routeParametersRegex = parser.pathname.split('/')

    const id = routeParametersRegex[4]
    const name = document.querySelector('#swup > div > div.item-details > div.product-info > div.name').innerHTML
    const image = (document.querySelector('#swup > div > div.item-image').style.backgroundImage) ? document.querySelector('#swup > div > div.item-image').style.backgroundImage : null
    const quantity = document.querySelector('#swup > div > div.item-details > div.product-cart > div > div > div').getAttribute('quantity')
    const amount = parseFloat((document.querySelector('#swup > div > div.item-details > div.product-cart > button > span.money').innerHTML).replace('R$ ', '').replace('.', '').replace(',', '.').replace('R$&nbsp;', ''))
    const unit = (document.querySelector('.counter').getAttribute('x-data') === '{ count: 50 }') ? 'KG' : 'UN'
    const price = parseFloat((document.querySelector('.product-info > .price').innerHTML).replace('R$ ', '').replace('.', '').replace(',', '.').replace('R$&nbsp;', ''))
    const observations = document.querySelector('#swup > div > div.item-details > div.comments > div.text > textarea').value

    paramsJSON['id'] = id
    paramsJSON['name'] = name
    paramsJSON['image'] = image
    paramsJSON['quantity'] = quantity
    paramsJSON['price'] = price
    paramsJSON['amount'] = amount
    paramsJSON['unit'] = unit
    paramsJSON['observations'] = observations

    if (!localStorage.getItem('bag')) {
      const now = new Date();
      const bagJSON = {}

      bagJSON['uuid'] = uuidv4()
      bagJSON['store'] = routeParametersRegex[2]
      bagJSON['user'] = null
      bagJSON['status'] = false
      bagJSON['amount'] = parseFloat(amount)
      bagJSON['quantity'] = parseInt(1)
      bagJSON['created_at'] = date.format(now, 'YYYY-MM-DD HH:mm:ss')
      bagJSON['items'] = [paramsJSON]

      localStorage.setItem('bag', JSON.stringify(bagJSON))
    } else {
      const responseBag = JSON.parse(localStorage.getItem('bag'))

      responseBag.amount = parseFloat(responseBag.amount) + parseFloat(amount)
      responseBag.quantity = parseInt(responseBag.quantity) + 1
      responseBag.items.push(paramsJSON)
      localStorage.setItem('bag', JSON.stringify(responseBag))
    }

    const bagLocalStorage = JSON.parse(localStorage.getItem('bag'))
    const badgeItemsQuantity = bagLocalStorage.quantity
    const badgeItemsAmount = bagLocalStorage.amount

    if (document.querySelector('body > div.bag > div > div.icon > div > span.quantity')) {
      document.querySelector('body > div.bag > div > div.icon > div > span.quantity').innerHTML = badgeItemsQuantity
      document.querySelector('body > div.bag > div > div.price > span').innerHTML = new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(badgeItemsAmount)


      if (badge.classList.contains('hide')) {
        badge.classList.remove('hide')
        badge.classList.add('show')
      }
    }

    document.querySelector('#swup > div > div.back-container > a').click()
  })
}

(async () => {
  sumProducts()
  bagBadge()
})()
