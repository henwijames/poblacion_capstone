/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./*.{html,js,php}"],
  theme: {
    extend: {
      fontFamily: {
        custom: ["Outfit", "sans-serif"],
      },
      colors: {
        primary: "#C1C549",
        secondary: "#DEE197",
        accent: "#D0D45F",
        background: "#FBFBF3",
      },
    },
  },
  plugins: [],
};
