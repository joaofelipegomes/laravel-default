let timeout = null

const hideBadge = () => {
  const badge = document.querySelector('body > div.bag > .badge')

  if (!badge.classList.contains('hide')) {
    badge.classList.add('hide')
    badge.classList.remove('show')
  }
}

const search = (element) => {
  const searchInput = document.querySelector('input[name="search"]')

  searchInput.addEventListener('keyup', function (e) {
    if (timeout) clearTimeout(timeout)

    timeout = setTimeout(() => {
      fetchProducts(1, searchInput.value, element)
    }, 1000)
  })
}

const fetchProducts = (storeID, textSearch, element) => {
  fetch(`https://api.inovasistemas.app/delivery/store/${storeID}/products?search=${textSearch}`, {
    method: 'GET',
    headers: {
      "Content-Type": "application/json",
    }
  })
    .then((response) => response.json())
    .then((data) => {
      deleteElements()
      createElements(data, element)
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

const createElements = (data, element) => {
  const container = document.querySelector('div.content > section > div')

  if (data) {
    for (const object in data) {
      let product = element.cloneNode(true)
      product.classList.add('child')
      product.style.display = 'flex';

      product.querySelector('name').innerHTML = data[object]['name']

      container.appendChild(product)
    }
  }
}

document.addEventListener('DOMContentLoaded', () => {
  const element = document.querySelector('div.content > section > div > a')
  element.remove()

  hideBadge()
  search(element)
})
