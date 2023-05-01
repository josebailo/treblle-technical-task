/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue'
  ],
  theme: {
    extend: {},
    screens: {
      sm: '640px',
      md: '768px'
    }
  },
  plugins: [
    require('@tailwindcss/forms')
  ]
}
