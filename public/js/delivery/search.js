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
      console.log(searchInput.value)
    }, 1000)
  })
}

document.addEventListener("DOMContentLoaded", () => {
  hideBadge()
  search()
})
