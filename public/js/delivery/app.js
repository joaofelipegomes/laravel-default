import { v4 as uuidv4 } from 'https://jspm.dev/uuid';
let eventListener = false

async function init() {
  function hideBadge() {
    console.log('hideBadge')
    const badge = document.querySelector('body > div.bag > .badge')

    if (!badge.classList.contains('hide')) {
      badge.classList.add('hide')
      badge.classList.remove('show')
    }
  }

  function hideBadgeCart() {
    console.log('hideBadgeCart')
    const badge = document.querySelector('body > .bag-continue')

    if (badge) {
      if (!badge.classList.contains('hide')) {
        badge.classList.add('hide')
        badge.classList.remove('show')
      }
    }
  }

  function showBadgeCart() {
    console.log('showBadgeCart')
    const badge = document.querySelector('body > .bag-continue')

    if (badge) {
      if (badge.classList.contains('hide')) {
        badge.classList.remove('hide')
        badge.classList.add('show')
      }
    }
  }

  function postLocalStorage() {
    console.log('postLocalStorage')
    if (!eventListener) {
      document.querySelector('body > div.navigator > ul > li:nth-child(2) > a').addEventListener('click', function (e) {
        e.preventDefault()

        fetch('/delivery/api/localstorage', {
          method: 'POST',
          headers: {
            "Content-Type": "application/json",
          },
          body: localStorage.getItem('bag')
        })
          .then((response) => response.json())
          .then((data) => {
            console.log(data);
          })
      })

      eventListener = true
    }
  }





  switch (true) {
    case (uri.includes('item')):
      await storeStatus(getStoreFromURI(uri))
      //windowResize()
      //sumProduct()
      //bagBadge()
      break
    case (uri.includes('carrinho')):
      windowResize()
      showBadgeCart()
      getItemsFromLocal()
      hideBadge()
      editItems()
      //verifyUser()
      break
    case (uri.includes('perfil')):
      windowResize()
      hideBadgeCart()
      hideBadge()
      break;
    default:
      //navigator()
      //scrollNavigator()
      //windowResize()
      //isStoreOpen(await storeStatus(getStoreFromURI(uri)))
      break
  }


  postLocalStorage()
}
