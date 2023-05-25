$(document).ready(function () {
  document.querySelector('select[name="categories-dropdown-mask"]').addEventListener('change', function () {
    document.querySelector('select[name="categories-dropdown"]').value = document.querySelector('select[name="categories-dropdown-mask"]').value
    scrollSection(document.querySelector('select[name="categories-dropdown-mask"]').value)
  })

  document.querySelector('select[name="categories-dropdown"]').addEventListener('change', function () {
    const section = document.querySelector('select[name="categories-dropdown"]').value
    scrollSection(section)
  })
})

const scrollSection = (section) => {
  var { top } = getOffset(document.getElementById(section))

  window.scrollTo({ left: 0, top: top - 125, behavior: 'smooth' })
}
