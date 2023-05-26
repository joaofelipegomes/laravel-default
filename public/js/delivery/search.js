const hideBadge = () => {
  if (!document.querySelector('body > div.bag > .badge').classList.contains('hide')) {
    document.querySelector('body > div.bag > .badge').classList.add('hide')
    document.querySelector('body > div.bag > .badge').classList.remove('show')
  }
}

(async () => {
  hideBadge()
})()
