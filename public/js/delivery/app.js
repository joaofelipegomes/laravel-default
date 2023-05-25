import { v4 as uuidv4 } from 'https://jspm.dev/uuid';
let eventListener = false

async function init() {
  function scrollNavigator() {
    console.log('scrollNavigator')
    var $navigationLinks = $('.scroll-navigator > div > a')
    var $sections = $($(".content > section").get().reverse())

    var sectionIdTonavigationLink = {}
    $sections.each(function () {
      var id = $(this).attr('id')
      sectionIdTonavigationLink[id] = $('.scroll-navigator > div > a[to=' + id + ']')
    })

    $(window).scroll(throttle(highlightNavigation, 100));

    function throttle(fn, interval) {
      var lastCall, timeoutId;
      return function () {
        var now = new Date().getTime();
        if (lastCall && now < (lastCall + interval)) {
          clearTimeout(timeoutId);
          timeoutId = setTimeout(function () {
            lastCall = now;
            fn.call();
          }, interval - (now - lastCall));
        } else {
          lastCall = now;
          fn.call();
        }
      };
    }

    function highlightNavigation() {
      var scrollPosition = $(window).scrollTop();

      $sections.each(function () {
        var currentSection = $(this);
        var sectionTop = currentSection.offset().top;

        if (scrollPosition + 170 >= sectionTop) {
          var id = currentSection.attr('id');
          var $navigationLink = sectionIdTonavigationLink[id];

          if (!document.querySelector('.clicked')) {
            if (!$navigationLink.hasClass('active')) {
              $navigationLinks.removeClass('active');
              $navigationLink.addClass('active');

              if (document.querySelector('.scroll-navigator')) {
                const { left } = getOffset(document.getElementById($navigationLink.attr('id')));
                document.querySelector('.scroll-navigator').scrollTo({ left: left - 8, top: 0, behavior: 'smooth' });
              }
            }
          }

          return false;
        }
      });
    }

    function getOffset(el) {
      var _x = 0;
      var _y = 0;
      while (el && !isNaN(el.offsetLeft) && !isNaN(el.offsetTop)) {
        _x += el.offsetLeft - el.scrollLeft;
        _y += el.offsetTop - el.scrollTop;
        el = el.offsetParent;
      }
      return { top: _y, left: _x };
    }

    document.querySelectorAll('.scroll-navigator > div > a').forEach(element => {
      element.addEventListener('click', (event) => {
        event.preventDefault()

        if (!$(element).hasClass('active')) {
          $navigationLinks.removeClass('active')
          $(element).addClass('active')
          $(element).addClass('clicked')

          var currentSection = $(element).attr('to')
          var { top } = getOffset(document.getElementById(currentSection))

          var { left } = getOffset(element);

          if (document.querySelector('.scroll-navigator')) {
            document.querySelector('.scroll-navigator').scrollTo({ left: left - 8, top: 0, behavior: 'smooth' });

            window.scrollTo({ left: 0, top: top - 125, behavior: 'smooth' })
            setInterval(function () {
              $(element).removeClass('clicked')
            }, 1000)
          }
        }
      });
    })
  }

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

  function getItemsFromLocal() {
    console.log('getItemsFromLocal')
    let parser = document.createElement('a')
    parser.href = window.location.href
    let routeParametersRegex = parser.pathname.split('/')
    const items = JSON.parse(localStorage.getItem('bag'))
    const container = document.querySelector('.group-items')
    const element = document.querySelector('#swup > div > div > div > a')


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

  function editItems() {
    console.log('editItems')
    const countersDecrement = document.querySelectorAll('.decrement')
    const countersIncrement = document.querySelectorAll('.increment')

    countersDecrement.forEach(counter => {
      counter.addEventListener('click', function () {
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

  function updateCart() {
    console.log('updateCart')
    let amountTotal = 0
    let quantityItems = 0
    const items = JSON.parse(localStorage.getItem('bag'))
    const itemsOnCart = document.querySelectorAll('.product')
    const bagJSON = {}

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
    } else {
      document.querySelector('.bag-continue').classList.add('hide')
      document.querySelector('.bag-continue').classList.remove('show')
    }

    document.querySelector('.total > .amount').innerHTML = parseFloat(amountTotal).toLocaleString('pt-br', { style: 'currency', currency: 'BRL' });

    localStorage.setItem('bag', JSON.stringify(bagJSON))
  }

  function verifyUser() {
    console.log('verifyUser')
    if (document.querySelector('.bag-continue > div')) {
      const button = document.querySelector('.bag-continue > div').addEventListener('click', function () {
        const cartJSON = JSON.parse(localStorage.getItem('bag'))

        if (cartJSON.user) {
          console.log('tem usuario')
        } else {
          document.querySelector('.profile').click()
        }
      })
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
