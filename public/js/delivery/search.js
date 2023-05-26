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

  searchInput.addEventListener('keyup', function () {
    if (timeout) clearTimeout(timeout)

    timeout = setTimeout(() => {
      console.log('oi')
    }, 1000)
  })

  searchInput.addEventListener('keypress', function (e) {
    if (e.key === 'Enter') {
      if (!timeout) {
        console.log('enter')
      }
    }
  })
}

document.addEventListener("DOMContentLoaded", () => {
  hideBadge()
  search()
})
