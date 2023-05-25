const throttle = (fn, interval) => {
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
      fn.call()
    }
  }
}

const highlightNavigation = () => {
  var scrollPosition = $(window).scrollTop();

  $sections.each(function () {
    var currentSection = $(this);
    var sectionTop = currentSection.offset().top;

    if (scrollPosition + 170 >= sectionTop) {
      var id = currentSection.attr('id');
      var $navigationLink = sectionIdTonavigationLink[id];

      document.querySelector('select[name="categories-dropdown"]').value = id
      document.querySelector('select[name="categories-dropdown-mask"]').value = id

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

const getOffset = (el) => {
  var _x = 0;
  var _y = 0;
  while (el && !isNaN(el.offsetLeft) && !isNaN(el.offsetTop)) {
    _x += el.offsetLeft - el.scrollLeft;
    _y += el.offsetTop - el.scrollTop;
    el = el.offsetParent;
  }
  return { top: _y, left: _x };
}

var $navigationLinks = $('.scroll-navigator > div > a')
var $sections = $($('.content > section').get().reverse())

var sectionIdTonavigationLink = {}
$sections.each(function () {
  var id = $(this).attr('id')
  sectionIdTonavigationLink[id] = $('.scroll-navigator > div > a[to=' + id + ']')
})

$(window).scroll(throttle(highlightNavigation, 100));

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
