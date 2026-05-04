/** @type {import('tailwindcss').Config} */
module.exports = {
  darkMode: 'class',
  content: [
    "./app/views/**/*.php",
    "./public/**/*.html"
  ],
  theme: {
    extend: {
      colors: {
        brand: {
          50:  '#eef2ff',
          100: '#e0e7ff',
          500: '#6366f1',
          600: '#4f46e5',
          700: '#4338ca',
          900: '#1e1b4b',
        },
        yt: {
          bg:      '#0f0f0f',  // fondo principal
          surface: '#212121',  // cards, tablas, topbar
          elevated:'#272727',  // hover, thead
          border:  '#3f3f3f',  // bordes y divisores
          text:    '#f1f1f1',  // texto principal
          muted:   '#aaaaaa',  // texto secundario
        },
        ytlight: {
          bg:      '#ffffff',  // fondo principal
          surface: '#f9f9f9',  // cards, tablas, topbar
          elevated:'#f2f2f2',  // hover, thead
          border:  '#e5e5e5',  // bordes y divisores
          text:    '#0f0f0f',  // texto principal
          muted:   '#606060',  // texto secundario
        },
      }
    },
  },
  plugins: [],
}