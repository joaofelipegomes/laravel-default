$(document).ready(function () {
  document.querySelector('select[name="categories-dropdown"]').addEventListener('change', function() {
    const section = document.querySelector('select[name="categories-dropdown"]').value
    window.scrollTo(section.offsetLeft, section.offsetTop);
  })
})
