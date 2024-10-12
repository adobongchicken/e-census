/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './resources/**/*.blade.php', // Include all Blade files
    './resources/js/**/*.js',      // Include all JavaScript files
    './resources/**/*.vue',         // Include all Vue files, if you're using Vue.js
  ],
  theme: {
    extend: {},
  },
  plugins: [],
}
