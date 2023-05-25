$(document).ready(function () {
  document.querySelectorAll('select[name="categories-dropdown"]').forEach(element => {
    element.addEventListener('change', function() {
      const section = document.querySelector('select[name="categories-dropdown"]').value
      var { top } = getOffset(document.getElementById(section))
      var { left } = 0

      window.scrollTo({ left: 0, top: top - 125, behavior: 'smooth' })

      // document.getElementById(section).scrollIntoView()
    })
  });
})

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
