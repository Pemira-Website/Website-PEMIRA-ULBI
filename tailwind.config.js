/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: { 
      boxShadow: {
        'text': '2px 2px 4px rgba(0, 0, 0, 0.5)', // Kustom shadow untuk teks
      },
    },
  },
  plugins: [
    function ({ addUtilities }) {
      addUtilities({
        '.text-shadow': {
          textShadow: '10px 2px 4px rgba(0, 0, 0, 0.5)', // Kustom shadow untuk teks
        },
      })
    },
  ],
}

