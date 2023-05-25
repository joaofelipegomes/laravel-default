$(document).ready(function () {
  document.querySelector('select[name="categories-dropdown-mask"]').addEventListener('change', function() {
    document.querySelector('select[name="categories-dropdown"]').value = document.querySelector('select[name="categories-dropdown-mask"]').value
    scrollSection(document.querySelector('select[name="categories-dropdown-mask"]').value)
  })

  document.querySelector('select[name="categories-dropdown"]').addEventListener('change', function() {
    const section = document.querySelector('select[name="categories-dropdown"]').value
    scrollSection(section)
  })
})

const scrollSection = (section) => {
  var { top } = getOffset(document.getElementById(section))
  var { left } = 0

  window.scrollTo({ left: 0, top: top - 125, behavior: 'smooth' })
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
