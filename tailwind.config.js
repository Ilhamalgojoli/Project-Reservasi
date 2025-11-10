/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      screens: {
        'xs': '500px', 
      },
    },
  },
  plugins: [
      require("@designbycode/tailwindcss-text-shadow"),
  ],
}
