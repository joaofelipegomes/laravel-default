import { v4 as uuidv4 } from 'https://jspm.dev/uuid';
let eventListener = false

async function init() {
  function scrollNavigator() {
    console.log('scrollNavigator')
    var $navigationLinks = $('.scroll-navigator > div > a')
    var $sections = $($(".content > section").get().reverse())

    var sectionIdTonavigationLink = {}
    $sections.each(function () {
      var id = $(this).attr('id')
      sectionIdTonavigationLink[id] = $('.scroll-navigator > div > a[to=' + id + ']')
    })

    $(window).scroll(throttle(highlightNavigation, 100));

    function throttle(fn, interval) {
      var lastCall, timeoutId;
      return function () {
        var now = new Date().getTime();
        if (lastCall && now < (lastCall + interval)) {
          clearTimeout(timeoutId);
          timeoutId = setTimeout(function () {
            lastCall = now;
            fn.call();
          }, interval - (now - lastCall));
        } else {
          lastCall = now;
          fn.call();
        }
      };
    }

    function highlightNavigation() {
      var scrollPosition = $(window).scrollTop();

      $sections.each(function () {
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

    function getOffset(el) {
      var _x = 0;
      var _y = 0;
      while (el && !isNaN(el.offsetLeft) && !isNaN(el.offsetTop)) {
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

  function hideBadge() {
    console.log('hideBadge')
    const badge = document.querySelector('body > div.bag > .badge')

    if (!badge.classList.contains('hide')) {
      badge.classList.add('hide')
      badge.classList.remove('show')
    }
  }

  function hideBadgeCart() {
    console.log('hideBadgeCart')
    const badge = document.querySelector('body > .bag-continue')

    if (badge) {
      if (!badge.classList.contains('hide')) {
        badge.classList.add('hide')
        badge.classList.remove('show')
      }
    }
  }

  function showBadgeCart() {
    console.log('showBadgeCart')
    const badge = document.querySelector('body > .bag-continue')

    if (badge) {
      if (badge.classList.contains('hide')) {
        badge.classList.remove('hide')
        badge.classList.add('show')
      }
    }
  }

  function postLocalStorage() {
    console.log('postLocalStorage')
    if (!eventListener) {
      document.querySelector('body > div.navigator > ul > li:nth-child(2) > a').addEventListener('click', function (e) {
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





  switch (true) {
    case (uri.includes('item')):
      await storeStatus(getStoreFromURI(uri))
      //windowResize()
      //sumProduct()
      //bagBadge()
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
      //navigator()
      //scrollNavigator()
      //windowResize()
      //isStoreOpen(await storeStatus(getStoreFromURI(uri)))
      break
  }


  postLocalStorage()
}
