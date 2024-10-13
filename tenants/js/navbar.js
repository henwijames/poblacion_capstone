document.addEventListener("DOMContentLoaded", function () {
  let lastScrollTop = 0;
  const navbar = document.getElementById("navbar");

  window.addEventListener("scroll", function () {
    let scrollTop = window.pageYOffset || document.documentElement.scrollTop;

    if (window.scrollY === 0) {
      navbar.classList.remove("fixed", "top-0", "shadow");
    } else {
      navbar.classList.add("fixed", "top-0", "shadow", "z-50");
    }

    if (scrollTop > lastScrollTop) {
      // Scrolling down: Hide the navbar
      navbar.style.transform = "translateY(-100%)";
    } else {
      // Scrolling up: Show the navbar
      navbar.style.transform = "translateY(0)";
    }
    lastScrollTop = scrollTop;
  });
  // Select the mobile menu button and the mobile menu
  const mobileMenuButton = document.querySelector(
    '[aria-controls="mobile-menu"]'
  );
  const userMenuButton = document.getElementById("user-menu-button");
  const userMenu = document.getElementById("user-menu");
  const mobileMenu = document.getElementById("mobile-menu");
  const openIcon = mobileMenuButton.querySelector("svg.block");
  const closeIcon = mobileMenuButton.querySelector("svg.hidden");

  // Add a click event listener to the mobile menu button
  mobileMenuButton.addEventListener("click", function () {
    // Toggle the mobile menu visibility
    mobileMenu.classList.toggle("hidden");

    // Toggle the icons for open/close
    openIcon.classList.toggle("hidden");
    closeIcon.classList.toggle("hidden");
  });

  userMenuButton.addEventListener("click", function () {
    const isMenuOpen = userMenu.classList.contains("hidden");
    if (isMenuOpen) {
      // Open menu with transition
      userMenu.classList.remove("hidden");
      setTimeout(() => {
        userMenu.classList.remove("scale-95", "opacity-0");
        userMenu.classList.add("scale-100", "opacity-100");
      }, 10); // Delay to allow transition
    } else {
      // Close menu with transition
      userMenu.classList.add("scale-95", "opacity-0");
      userMenu.classList.remove("scale-100", "opacity-100");
      setTimeout(() => {
        userMenu.classList.add("hidden");
      }, 150); // Match the duration of the transition (100ms)
    }
  });

  // Close menu if clicked outside
  document.addEventListener("click", function (event) {
    if (
      !userMenuButton.contains(event.target) &&
      !userMenu.contains(event.target)
    ) {
      if (!userMenu.classList.contains("hidden")) {
        userMenu.classList.add("scale-95", "opacity-0");
        userMenu.classList.remove("scale-100", "opacity-100");
        setTimeout(() => {
          userMenu.classList.add("hidden");
        }, 150);
      }
    }
  });
});
