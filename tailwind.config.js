/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./resources/**/*.blade.php",
    "./resources/**/*.js",
  ],
  theme: {
    extend: {
      backgroundImage: {
        'banner': "url('/assets/images/banner.jpg')",
      }
    },
  },
  plugins: [],
}

