const hideBadge = () => {
  const badge = document.querySelector('body > div.bag > .badge')

  if (!badge.classList.contains('hide')) {
    badge.classList.add('hide')
    badge.classList.remove('show')
  }
}

const search = () => {
  const inputSearch = document.querySelector('input[name="search"]').addEventListener('keyup', function () {
    setInterval(() => { console.log('oi') }, 1000)
  })
}

document.addEventListener("DOMContentLoaded", () => {
  hideBadge()
  search()
})
