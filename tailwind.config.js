/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        coffee: {
          50: '#f9f7f4',
          100: '#f0ebe3',
          200: '#e1d7c7',
          300: '#cbb9a1',
          400: '#b59a7b',
          500: '#9e7d5d',
          600: '#8b6a4f',
          700: '#735544',
          800: '#5e463a',
          900: '#4d3a31',
        },
        cream: {
          50: '#fdfcfb',
          100: '#faf7f3',
          200: '#f5ede3',
          300: '#ecdfd0',
          400: '#e0cab3',
          500: '#d3b498',
          600: '#c19e7d',
          700: '#a67f5f',
          800: '#89694d',
          900: '#6f573f',
        },
      },
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
    require('@tailwindcss/typography'),
  ],
}
