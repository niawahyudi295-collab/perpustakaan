/** @type {import('tailwindcss').Config} */
export default {
  theme: {
    extend: {
      colors: {
        primary: {
          50: '#f9f7f4',
          100: '#f5f2ee',
          200: '#e8e1d5',
          300: '#dccbbc',
          400: '#c8a850',
          500: '#967830',
          600: '#7a5f26',
          700: '#5d481d',
          800: '#504840',
          900: '#2a2520',
        },
        accent: {
          50: '#fef9f3',
          100: '#fdf2e6',
          200: '#fce5cc',
          300: '#fab8a0',
          400: '#f59c6d',
          500: '#f08050',
          600: '#d86638',
          700: '#b85028',
          800: '#8f3d1f',
          900: '#6e2f17',
        },
      },
      fontFamily: {
        sans: ['Instrument Sans', 'ui-sans-serif', 'system-ui', 'sans-serif'],
      },
    },
  },
  plugins: [],
}
