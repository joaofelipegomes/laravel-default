$(document).ready(function () {
  document.querySelectorAll('select[name="categories-dropdown"]').forEach(element => {
    element.addEventListener('change', function() {
      const section = document.querySelector('select[name="categories-dropdown"]').value
      alert(section)
      document.getElementById(section).scrollIntoView();
    })
  });
})
