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
}

document.addEventListener('DOMContentLoaded', () => {
  hideBadge()
  search()
})
