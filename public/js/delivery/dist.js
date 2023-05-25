const badge = () => {
  const badge = document.querySelector('body > div.bag > .badge')
  const bagLocalStorage = JSON.parse(localStorage.getItem('bag'))
  const location = window.location.href
  let routeParametersRegex = String(location.pathname).split('/')
  console.log(routeParametersRegex)

  if (bagLocalStorage) {
    console.log(bagLocalStorage.store, routeParametersRegex)
    if (bagLocalStorage.store === routeParametersRegex[2]) {

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

  return routeParametersRegex[2]
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

const navigator = async () => {
  const menu_items = document.querySelectorAll('.menu-container > li > a')

  menu_items.forEach(function (element) {
    element.addEventListener('click', function (e) {
      const span_list = document.querySelectorAll('.menu-container > li > a > span')

      span_list.forEach(function (element) {
        element.classList.remove('active')

        if (element.innerHTML.trim() === 'search') {
          element.classList.remove('weight')
        }
      })

      if (e.target.innerHTML.trim() === 'search') {
        e.target.classList.add('weight')
      } else {
        e.target.classList.add('active')
      }
    })
  })
}

const onScrollTopBar = async () => {
  if (document.getElementById('fixednavigator')) {
    if (document.body.scrollTop > 180 || document.documentElement.scrollTop > 180) {
      document.getElementById('fixednavigator').style.display = 'block'
      document.getElementById('fixednavigator').style.marginTop = '0px'
    } else {
      document.getElementById('fixednavigator').style.marginTop = '-100px'
      document.getElementById('fixednavigator').style.marginTop = '-200px'
    }
  }

  if (document.getElementsByClassName('back-container')[0]) {
    if (document.body.scrollTop > 50 || document.documentElement.scrollTop > 50) {
      document.getElementsByClassName('back-container')[0].classList.add('bg-[#fffbfe]')
    } else {
      document.getElementsByClassName('back-container')[0].classList.remove('bg-[#fffbfe]')
    }
  }
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
  navigator()
  navigatorWeight(window.location.href)
  badge()
  displayView()

  window.onscroll = function () {
    onScrollTopBar()
  }
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
