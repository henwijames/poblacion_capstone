/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./**/*.php", "./src/**/*.html", "./src/**/*.js"],
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
  plugins: [require("daisyui")],
  daisyui: {
    themes: ["light"],
  },
};
