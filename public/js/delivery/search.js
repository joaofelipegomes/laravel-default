let timeout = null

const formatToReais = (number) => {
  let int = parseInt(number).toLocaleString('pt-BR');
  let decimal = (number % 1).toFixed(2).substring(2);

  return `R$ ${int},${decimal}`;
}

function capitalizeText(text) {
  const connectors = ['e', 'ou', 'mas', 'por', 'para', 'com', 'sem', 'como', 'até', 'de', 'desde', 'em', 'entre', 'sob', 'sobre', 'a', 'o', 'os', 'as', 'um', 'uns', 'uma', 'umas'];
  const words = text.toLowerCase().split(' ');

  for (let i = 0; i < words.length; i++) {
    if (!connectors.includes(words[i])) {
      words[i] = words[i][0].toUpperCase() + words[i].slice(1);
    }
  }

  return words.join(' ');
}

function capitalizeText(text) {
  if (text.length === 0) {
    return '';
  }

  const capitalizedText = text.charAt(0).toUpperCase() + text.slice(1).toLowerCase();

  return capitalizedText;
}


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
    }, 500)
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

const currentURI = () => {
  let routeParametersRegex = document.createElement('a')
  routeParametersRegex.href = window.location.href;
  routeParametersRegex = String(routeParametersRegex.pathname).split('/')

  console.log(`/${routeParametersRegex[0]}/${routeParametersRegex[1]}/`)
  return `/delivery/${routeParametersRegex[1]}/`
}

const createElements = (data, element) => {
  const container = document.querySelector('div.content > section > div')
  const uri = currentURI()


  if (data) {
    for (const object in data) {
      let product = element.cloneNode(true)
      product.classList.add('child')
      product.setAttribute('href', `${uri}/item/${data[object]['id']}`)
      product.style.display = 'flex';

      product.querySelector('.name').innerHTML = capitalizeText(data[object]['name'])
      product.querySelector('.description').innerHTML = capitalizeText(data[object]['description'])
      product.querySelector('.price').innerHTML = formatToReais(data[object]['amount'])

      if (data[object]['image']) {
        product.querySelector('.image').style.backgroundImage = `url('https://solucoesinova.com.br/inovadelivery/produto_img/1/${data[object]['image']}')`
      }

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
