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
      console.log(data)
    })
}

document.addEventListener('DOMContentLoaded', () => {
  hideBadge()
  search()
})
