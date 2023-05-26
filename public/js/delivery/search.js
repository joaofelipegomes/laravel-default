let timeout = null

const hideBadge = () => {
  const badge = document.querySelector('body > div.bag > .badge')

  if (!badge.classList.contains('hide')) {
    badge.classList.add('hide')
    badge.classList.remove('show')
  }
}

const search = () => {
  const searchInput = document.querySelector('input[name="search"]')

  searchInput.addEventListener('keyup', function (e) {
    if (timeout) clearTimeout(timeout)

    timeout = setTimeout(() => {
      fetchProducts(1, searchInput.value)
    }, 1000)
  })
}

const fetchProducts = (storeID, textSearch) => {
  fetch(`https://api.inovasistemas.app/delivery/store/${storeID}/products?search=${textSearch}`, {
    method: 'GET',
    headers: {
      "Content-Type": "application/json",
    }
  })
    .then((response) => response.json())
    .then((data) => {
      deleteElements()
      createElements(data)
    })
}

const deleteElements = () => {
  const elements = document.querySelectorAll('div.content > section > div > a.child')

  if (elements !== null) {
    elements.forEach(element => {
      element.remove()
    })
  }
}

const createElements = (data) => {
  let element = document.createElement('a').classList.add('product')
  element.appendChild(document.createElement('div').classList.add('product-info'))
  element.querySelector('.product-info').appendChild(document.createElement('div').classList.add('name'))
  element.querySelector('.product-info').appendChild(document.createElement('div').classList.add('description'))
  element.querySelector('.product-info').appendChild(document.createElement('div').classList.add('price'))
  element.appendChild(document.createElement('div').classList.add('image'))

  const container = document.querySelector('div.content > section > div')
  //const element = document.querySelector('div.content > section > div > a')

  if (data) {
    for (const object in data) {
      let product = element.cloneNode(true)

      product.style.display = 'flex';

      container.appendChild(product)
    }
  }
}

document.addEventListener('DOMContentLoaded', () => {
  hideBadge()
  search()
})
