import { v4 as uuidv4 } from 'https://jspm.dev/uuid';

const badge = () => {
  const badge = document.querySelector('body > div.bag > .badge')
  const bagLocalStorage = JSON.parse(localStorage.getItem('bag'))
  let parser = document.createElement('a')
  let routeParametersRegex = parser.pathname.split('/')

  parser.href = window.location.href

  if (bagLocalStorage) {
    if (bagLocalStorage.store === routeParametersRegex[1]) {
      const badgeItemsQuantity = bagLocalStorage.quantity
      const badgeItemsAmount = bagLocalStorage.amount

      if (badgeItemsQuantity > 0) {
        document.querySelector('body > div.bag > div > div.icon > div > span.quantity').innerHTML = badgeItemsQuantity
        document.querySelector('body > div.bag > div > div.price > span').innerHTML = new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(badgeItemsAmount)

        if (badge.classList.contains('hide')) {
          badge.classList.remove('hide')
          badge.classList.add('show')
        }
      }
    }
  }
}

const storeURI = () => {
  let parser = document.createElement('a')
  parser.href = uri
  let routeParametersRegex = parser.pathname.split('/')

  return routeParametersRegex[1]
}

const verifyStoreStatus = () => {
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

const navigatorWeight = (uri) => {
  const menus = document.querySelectorAll('.active')
  menus.forEach(menu => {
    menu.classList.remove('active')
  })

  switch (true) {
    case (uri.includes('carrinho')):
      document.querySelector('.material-symbols-outlined.cart').classList.add('active')
      break
    case (uri.includes('perfil')):
      document.querySelector('.material-symbols-outlined.account').classList.add('active')
      break
    default:
      document.querySelector('.material-symbols-outlined.search').classList.add('weight', 'active')
      break
  }
}

const displayView = () => {
  window.addEventListener('resize', function (e) {
    windowResize()
  })

  window.addEventListener('DOMContentLoaded', function (e) {
    windowResize()
  })

  $('body').delay(500).animate({
    opacity: 1
  }, 300)
}

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

const windowResize = () => {
  const back_container = document.getElementsByClassName('back-container')[0]
  const content_width = window.innerWidth
  const fixed_navigator = document.getElementsByClassName('fixed-navigator')[0]
  const main_container = document.getElementsByClassName('main-container')[0]
  const navigator = document.getElementsByClassName('navigator')[0]
  let content_padding = 0

  content_padding = (content_width <= 800) ? 0 : ((content_width - 800) / 2)

  if (!(main_container.classList.contains('no-padding')) || (content_padding != 20)) {
    main_container.style.paddingLeft = `${content_padding}px`
    main_container.style.paddingRight = `${content_padding}px`
  }

  if (fixed_navigator) {
    fixed_navigator.style.paddingLeft = `${content_padding}px`
    fixed_navigator.style.paddingRight = `${content_padding}px`
  }

  if (navigator) {
    navigator.style.paddingLeft = `${content_padding}px`
    navigator.style.paddingRight = `${content_padding}px`
  }

  if (back_container) {
    if (content_padding != 20) {
      content_padding = content_padding + 20
    }
    back_container.style.paddingLeft = `${content_padding}px`
    back_container.style.paddingRight = `${content_padding}px`
  }
}

(async () => {
  $(window).scrollTop(0, 0)
  navigatorWeight(window.location.href)
  badge()
  displayView()
})()


// --> getBadge
// --> getStoreFromURI
// --> isStoreOpen
// navigator
// postLocalStorage
// scrollNavigator
// --> setNatigatorWeight
// --> showBody
// --> storeStatus
// --> windowResize
