/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
      "./resources/views/admin/**/*.{js,php}",
      "./resources/views/admin/**/**/*.{js,php}",
      "./resources/views/delivery/**/*.{js,php}",
      "./resources/views/delivery/**/**/*.{js,php}"
    ],
    theme: {
        extend: {},
    },
    plugins: [],
}
