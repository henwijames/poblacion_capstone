//Start Sidebar
const sidebarToggle = document.querySelector(".sidebar-toggle");
const sidebarOverlay = document.querySelector(".sidebar-overlay");
const sidebarMenu = document.querySelector(".sidebar-menu");
const main = document.querySelector(".main");

sidebarToggle.addEventListener("click", (e) => {
  e.preventDefault();
  main.classList.toggle("active");
  sidebarOverlay.classList.toggle("hidden");
  sidebarMenu.classList.toggle("-translate-x-full");
});

sidebarOverlay.addEventListener("click", (e) => {
  e.preventDefault();
  main.classList.add("active");
  sidebarOverlay.classList.toggle("hidden");
  sidebarMenu.classList.toggle("-translate-x-full");
});

document.querySelectorAll(".sidebar-dropdown-toggle").forEach((item) => {
  item.addEventListener("click", (e) => {
    e.preventDefault();
    const parent = item.closest(".group");
    if (parent.classList.contains("selected")) {
      parent.classList.remove("selected");
    } else {
      document.querySelectorAll(".sidebar-dropdown-toggle").forEach((item) => {
        item.closest(".group").classList.remove("selected");
      });
      parent.classList.add("selected");
    }
    parent.classList.add("selected");
  });
});

document.querySelectorAll(".dropdown-toggle").forEach((button) => {
  button.addEventListener("click", () => {
    const dropdownMenu = button.nextElementSibling;

    // Toggle the hidden class to show/hide the dropdown
    dropdownMenu.classList.toggle("hidden");

    // Close any other open dropdowns
    document.querySelectorAll(".dropdown-menu").forEach((menu) => {
      if (menu !== dropdownMenu) {
        menu.classList.add("hidden");
      }
    });
  });
});

// Optional: Close the dropdown if clicked outside
document.addEventListener("click", (e) => {
  const isDropdown =
    e.target.matches(".dropdown-toggle") || e.target.closest(".dropdown");
  if (!isDropdown) {
    document.querySelectorAll(".dropdown-menu").forEach((menu) => {
      menu.classList.add("hidden");
    });
  }
});

//End Sidebar

document.addEventListener("DOMContentLoaded", function () {
  const breadCrumb = document.getElementById("breadcrumb");
  const pageLinks = document.querySelectorAll("a[href]");

  pageLinks.forEach((link) => {
    link.addEventListener("click", function (event) {
      const pageName = this.textContent.trim();

      // Prevent duplicate "Dashboard / Dashboard" entries

      breadCrumb.textContent = `${pageName}`;

      // Store the breadcrumb in localStorage
      localStorage.setItem("breadcrumb", breadCrumb.textContent);
    });
  });

  // On page load, restore the breadcrumb from localStorage
  const savedBreadcrumb = localStorage.getItem("breadcrumb");
  if (savedBreadcrumb) {
    breadCrumb.textContent = savedBreadcrumb;
  } else {
    breadCrumb.textContent = "Dashboard";
  }
});
