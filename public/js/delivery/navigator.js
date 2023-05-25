$(document).ready(function () {
  document.querySelectorAll('select[name="categories-dropdown"]').forEach(element => {
    element.addEventListener('change', function() {
      const section = document.querySelector('select[name="categories-dropdown"]').value
      var { top } = getOffset(document.getElementById(section))
      var { left } = getOffset(0)

      window.scrollTo({ left: 0, top: top - 125, behavior: 'smooth' })

      // document.getElementById(section).scrollIntoView()
    })
  });
})


