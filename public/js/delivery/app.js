import { v4 as uuidv4 } from 'https://jspm.dev/uuid';
let eventListener = false

async function init() {
    function windowResize() {
        let content_padding = 0
        const content_width = window.innerWidth
        const main_container = document.getElementsByClassName('main-container')[0]
        const fixed_navigator = document.getElementsByClassName('fixed-navigator')[0]
        const navigator = document.getElementsByClassName('navigator')[0]
        const back_container = document.getElementsByClassName('back-container')[0]

        content_padding = (content_width <= 800) ? 0 : ((content_width - 800) / 2)

        if (!(main_container.classList.contains('no-padding')) || (content_padding != 20)) {
            main_container.style.paddingLeft = `${content_padding}px`
            main_container.style.paddingRight = `${content_padding}px`
        }

        if (fixed_navigator) {
            fixed_navigator.style.paddingLeft = `${content_padding}px`
            fixed_navigator.style.paddingRight = `${content_padding}px`
        }

        if (navigator) {
            navigator.style.paddingLeft = `${content_padding}px`
            navigator.style.paddingRight = `${content_padding}px`
        }

        if (back_container) {
            if (content_padding != 20) {
                content_padding = content_padding + 20
            }
            back_container.style.paddingLeft = `${content_padding}px`
            back_container.style.paddingRight = `${content_padding}px`
        }
    }

    function showBody() {
        window.addEventListener('resize', function(e) {
            windowResize()
        })

        window.addEventListener('DOMContentLoaded', function(e) {
           windowResize()
        })

        $('body').delay(500).animate({
            opacity: 1
        }, 300)
    }

    function navigator() {
        const menu_items = document.querySelectorAll('.menu-container > li > a')

        menu_items.forEach(function (element) {
            element.addEventListener('click', function (e) {
                const span_list = document.querySelectorAll(
                    '.menu-container > li > a > span'
                )

                span_list.forEach(function (element) {
                    element.classList.remove('active')

                    if (element.innerHTML.trim() === 'search') {
                        element.classList.remove('weight')
                    }
                })

                if (e.target.innerHTML.trim() === 'search') {
                    e.target.classList.add('weight')
                } else {
                    e.target.classList.add('active')
                }
            })
        })

        window.onscroll = function () {
            scrollFunction()
        }

        async function scrollFunction() {
            if (document.getElementById('fixednavigator')) {
                if (document.body.scrollTop > 180 || document.documentElement.scrollTop > 180) {
                    document.getElementById('fixednavigator').style.display = 'block'
                    document.getElementById('fixednavigator').style.marginTop = '0px'
                } else {
                    document.getElementById('fixednavigator').style.marginTop = '-100px'
                    document.getElementById('fixednavigator').style.marginTop = '-200px'
                }
            }

            if (document.getElementsByClassName('back-container')[0]) {
                if (document.body.scrollTop > 50 || document.documentElement.scrollTop > 50) {
                    document.getElementsByClassName('back-container')[0].classList.add('bg-[#fffbfe]')
                } else {
                    document.getElementsByClassName('back-container')[0].classList.remove('bg-[#fffbfe]')
                }
            }
        }
    }

    function scrollNavigator() {
        var $navigationLinks = $('.scroll-navigator > div > a')
        var $sections = $($(".content > section").get().reverse())

        var sectionIdTonavigationLink = {}
        $sections.each(function() {
            var id = $(this).attr('id')
            sectionIdTonavigationLink[id] = $('.scroll-navigator > div > a[to=' + id + ']')
        })

        $(window).scroll(throttle(highlightNavigation, 100));

        function throttle(fn, interval) {
            var lastCall, timeoutId;
            return function () {
                var now = new Date().getTime();
                if (lastCall && now < (lastCall + interval) ) {
                    clearTimeout(timeoutId);
                    timeoutId = setTimeout(function () {
                        lastCall = now;
                        fn.call();
                    }, interval - (now - lastCall) );
                } else {
                    lastCall = now;
                    fn.call();
                }
            };
        }

        function highlightNavigation() {
            var scrollPosition = $(window).scrollTop();

            $sections.each(function() {
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

        function getOffset( el ) {
            var _x = 0;
            var _y = 0;
            while( el && !isNaN( el.offsetLeft ) && !isNaN( el.offsetTop ) ) {
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

    function getStoreFromURI(uri) {
        let parser = document.createElement('a')
        parser.href = uri
        let routeParametersRegex = parser.pathname.split('/')

        return routeParametersRegex[1]
    }

    async function storeStatus(store) {
        return new Promise((resolve, reject) => {
            fetch(`http://inovadelivery-env.eba-pibcpwue.sa-east-1.elasticbeanstalk.com/delivery/store/1/status`, {
                method: 'GET',
                headers: {
                    "Content-Type": "application/json",
                }
            })
            .then((response) => response.json())
            .then((data) => {
                return resolve(data);
            })
        });
    }

    function isStoreOpen(data) {
        const status = document.querySelector('.info > .open')
        status.setAttribute('class', '')

        if ((!data.open) && (!data.outside_business_hours)) {
            status.setAttribute('class', 'open closed')
            status.querySelector('.status').innerHTML = 'Loja Fechada'
        } else if ((!data.open) && (data.outside_business_hours)) {
            status.setAttribute('class', 'open schedule')
            status.querySelector('.status').innerHTML = 'Agendar Entrega'
        } else if (data.open) {
            status.setAttribute('class', 'open opened')
            status.querySelector('.status').innerHTML = 'Loja Aberta'
        }
    }

    function sumProduct() {
        document.querySelector('.increment').addEventListener('click', function() {
            const unit = (document.querySelector('.unit').innerHTML === 'un') ? 1 : 50
            const quantity = document.querySelector('.count-container > .count').getAttribute('quantity')
            const amount = document.querySelector('.price').getAttribute('amount')

            document.querySelector('.count-container > .count').setAttribute('quantity', parseInt(quantity) + parseInt(unit))

            if (unit === 1) {
                document.querySelector('.money').innerHTML = ((parseInt(quantity) + unit) * parseFloat(amount)).toLocaleString('pt-br',{style: 'currency', currency: 'BRL'});
            } else {
                document.querySelector('.money').innerHTML = ((parseFloat(amount) / 1000) * (parseInt(quantity) + unit)).toLocaleString('pt-br',{style: 'currency', currency: 'BRL'});
            }
        })

        document.querySelector('.decrement').addEventListener('click', function() {
            const unit = (document.querySelector('.unit').innerHTML === 'un') ? 1 : 50
            const quantity = document.querySelector('.count-container > .count').getAttribute('quantity')
            const amount = document.querySelector('.price').getAttribute('amount')

            document.querySelector('.count-container > .count').setAttribute('quantity', parseInt(quantity) - parseInt(unit))

            if (unit === 1) {
                if (parseInt(quantity) >= 2) {
                    document.querySelector('.money').innerHTML = ((parseInt(quantity) - unit) * parseFloat(amount)).toLocaleString('pt-br',{style: 'currency', currency: 'BRL'});
                }
            } else {
                if (parseInt(quantity) >= 100) {
                    document.querySelector('.money').innerHTML = ((parseFloat(amount) / 1000) * (parseInt(quantity) - unit)).toLocaleString('pt-br',{style: 'currency', currency: 'BRL'});
                }
            }
        })
    }

    function bagBadge() {

        document.querySelector('.product-cart > button').addEventListener('click', function() {
            const badge = document.querySelector('body > div.bag > .badge')
            const paramsJSON = {}

            let parser = document.createElement('a')
            parser.href = window.location.href
            let routeParametersRegex = parser.pathname.split('/')

            const id = routeParametersRegex[3]
            const name = document.querySelector('#swup > div > div.item-details > div.product-info > div.name').innerHTML
            const image = document.querySelector('#swup > div > div.item-image').style.backgroundImage
            const quantity = document.querySelector('#swup > div > div.item-details > div.product-cart > div > div > div').getAttribute('quantity')
            const amount = parseFloat((document.querySelector('#swup > div > div.item-details > div.product-cart > button > span.money').innerHTML).replace('R$ ', '').replace('.', '').replace(',', '.').replace('R$&nbsp;', ''))
            const unit = (document.querySelector('.counter').getAttribute('x-data') === '{ count: 50 }') ? 'KG' : 'UN'
            const price = parseFloat((document.querySelector('.product-info > .price').innerHTML).replace('R$ ', '').replace('.', '').replace(',', '.').replace('R$&nbsp;', ''))
            const observations = document.querySelector('#swup > div > div.item-details > div.comments > div.text > textarea').value

            paramsJSON['id'] = id
            paramsJSON['name'] = name
            paramsJSON['image'] = image
            paramsJSON['quantity'] = quantity
            paramsJSON['price'] = price
            paramsJSON['amount'] = amount
            paramsJSON['unit'] = unit
            paramsJSON['observations'] = observations

            if (!localStorage.getItem('bag')) {
                const now = new Date();
                const bagJSON = {}

                bagJSON['uuid'] = uuidv4()
                bagJSON['store'] = routeParametersRegex[1]
                bagJSON['user'] = null
                bagJSON['status'] = false
                bagJSON['amount'] = parseFloat(amount)
                bagJSON['quantity'] = parseInt(1)
                bagJSON['created_at'] = date.format(now, 'YYYY-MM-DD HH:mm:ss')
                bagJSON['items'] = [paramsJSON]

                localStorage.setItem('bag', JSON.stringify(bagJSON))
            } else {
                const responseBag = JSON.parse(localStorage.getItem('bag'))

                responseBag.amount = parseFloat(responseBag.amount) + parseFloat(amount)
                responseBag.quantity = parseInt(responseBag.quantity) + 1
                responseBag.items.push(paramsJSON)
                localStorage.setItem('bag', JSON.stringify(responseBag))
            }

            const bagLocalStorage = JSON.parse(localStorage.getItem('bag'))
            const badgeItemsQuantity = bagLocalStorage.quantity
            const badgeItemsAmount = bagLocalStorage.amount

            document.querySelector('body > div.bag > div > div.icon > div > span.quantity').innerHTML = badgeItemsQuantity
            document.querySelector('body > div.bag > div > div.price > span').innerHTML = new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(badgeItemsAmount)

            if (badge.classList.contains('hide')) {
                badge.classList.remove('hide')
                badge.classList.add('show')
            }

            document.querySelector('#swup > div > div.back-container > a').click()
        })
    }

    function getBadge() {
        let parser = document.createElement('a')
        parser.href = window.location.href
        let routeParametersRegex = parser.pathname.split('/')
        const badge = document.querySelector('body > div.bag > .badge')
        const bagLocalStorage = JSON.parse(localStorage.getItem('bag'))

        if (bagLocalStorage) {
            if (bagLocalStorage.store === routeParametersRegex[1]) {
                const badgeItemsQuantity = bagLocalStorage.quantity
                const badgeItemsAmount = bagLocalStorage.amount

                if (badgeItemsQuantity > 0) {
                    document.querySelector('body > div.bag > div > div.icon > div > span.quantity').innerHTML = badgeItemsQuantity
                    document.querySelector('body > div.bag > div > div.price > span').innerHTML = new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(badgeItemsAmount)

                    if (badge.classList.contains('hide')) {
                        badge.classList.remove('hide')
                        badge.classList.add('show')
                    }
                }
            }
        }
    }

    function hideBadge() {
        const badge = document.querySelector('body > div.bag > .badge')

        if (!badge.classList.contains('hide')) {
            badge.classList.add('hide')
            badge.classList.remove('show')
        }
    }

    function hideBadgeCart() {
        const badge = document.querySelector('body > .bag-continue')

        if (badge) {
            if (!badge.classList.contains('hide')) {
                badge.classList.add('hide')
                badge.classList.remove('show')
            }
        }
    }

    function showBadgeCart() {
        const badge = document.querySelector('body > .bag-continue')

        if (badge) {
            if (badge.classList.contains('hide')) {
                badge.classList.remove('hide')
                badge.classList.add('show')
            }
        }
    }

    function postLocalStorage() {
        if (!eventListener) {
            document.querySelector('body > div.navigator > ul > li:nth-child(2) > a').addEventListener('click', function(e) {
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
                childElement.querySelector('.product-info > div > .price').innerHTML = parseFloat(items['items'][chave]['amount']).toLocaleString('pt-br',{style: 'currency', currency: 'BRL'});
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
            document.querySelector('.total > .amount').innerHTML = parseFloat(items.amount).toLocaleString('pt-br',{style: 'currency', currency: 'BRL'});

            element.remove()
        } else {
            document.querySelector('.bag-continue').classList.add('hide')
            document.querySelector('.bag-continue').classList.remove('show')
        }
    }

    function setNatigatorWeight(uri) {
        const menus = document.querySelectorAll('.active')
        menus.forEach(menu => {
            menu.classList.remove('active')
        })

        switch(true) {
            case (uri.includes('carrinho')):
                document.querySelector('.material-symbols-outlined.cart').classList.add('active')
                break
            case (uri.includes('perfil')):
                document.querySelector('.material-symbols-outlined.account').classList.add('active')
                break
            default:
                document.querySelector('.material-symbols-outlined.search').classList.add('weight', 'active')
                break
        }
    }

    function editItems() {
        const countersDecrement = document.querySelectorAll('.decrement')
        const countersIncrement = document.querySelectorAll('.increment')

        countersDecrement.forEach(counter => {
            counter.addEventListener('click', function() {
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
                        counter.parentElement.parentElement.querySelector('.price').innerHTML = parseFloat((price / 1000) * (parseInt(count) - 50)).toLocaleString('pt-br',{style: 'currency', currency: 'BRL'})
                        counter.parentElement.querySelector('.count').innerHTML = String(parseInt(count) - 50)
                    } else {
                        counter.parentElement.parentElement.querySelector('.price').innerHTML = parseFloat(price * (parseInt(count) - 1)).toLocaleString('pt-br',{style: 'currency', currency: 'BRL'})
                        counter.parentElement.querySelector('.count').innerHTML = String(parseInt(count) - 1)
                    }
                }

                updateCart()
            })
        })

        countersIncrement.forEach(counter => {
            counter.addEventListener('click', function() {
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
                    counter.parentElement.parentElement.querySelector('.price').innerHTML = parseFloat((price / 1000) * (parseInt(count) + 50)).toLocaleString('pt-br',{style: 'currency', currency: 'BRL'})
                    counter.parentElement.querySelector('.count').innerHTML = String(parseInt(count) + 50)
                } else {
                    counter.parentElement.parentElement.querySelector('.price').innerHTML = parseFloat(price * (parseInt(count) + 1)).toLocaleString('pt-br',{style: 'currency', currency: 'BRL'})
                    counter.parentElement.querySelector('.count').innerHTML = String(parseInt(count) + 1)
                }

                updateCart()
            })
        })
    }

    function updateCart() {
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

        document.querySelector('.total > .amount').innerHTML = parseFloat(amountTotal).toLocaleString('pt-br',{style: 'currency', currency: 'BRL'});

        localStorage.setItem('bag', JSON.stringify(bagJSON))
    }

    function verifyUser() {
        if (document.querySelector('.bag-continue > div')) {
            const button = document.querySelector('.bag-continue > div').addEventListener('click', function() {
                const cartJSON = JSON.parse(localStorage.getItem('bag'))

                if (cartJSON.user) {
                    console.log('tem usuario')
                } else {
                    document.querySelector('.profile').click()
                }
            })
        }
    }



    let uri = window.location.href
    $(window).scrollTop(0, 0)
    setNatigatorWeight(uri)

    getBadge()

    switch(true) {
        case (uri.includes('item')):
            await storeStatus(getStoreFromURI(uri))
            windowResize()
            sumProduct()
            bagBadge()
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
            navigator()
            scrollNavigator()
            windowResize()
            isStoreOpen(await storeStatus(getStoreFromURI(uri)))
            break
    }


    //postLocalStorage()
    showBody()
}

if (document.readyState === 'complete') {
    init()
} else {
    document.addEventListener('DOMContentLoaded', () => init())
}
