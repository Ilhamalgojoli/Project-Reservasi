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
        'sm': {
          'max' : '766px',
          'min' : '460px'
        }, 
      },
    },
  },
  plugins: [
      require("@designbycode/tailwindcss-text-shadow"),
  ],
}
